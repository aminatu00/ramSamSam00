<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Auth;
use App\Notifications\DiscussionLikedNotification;
// use App\Notifications\NewQuestionNotification;
use App\Notifications\NewReplyNotification;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */



     public function getQuestionsByCategory($id)
     {
         // Récupérer les questions pour la catégorie spécifiée par $id
         $category = Category::find($id);
     
         if ($category) {
             $questions = $category->questions;
             return view('question.index', ['questions' => $questions, 'category' => $category]);
         } else {
             return view('question.index')->with('error', 'Aucune question associée à cette catégorie.');
         }
     }


     public function search(Request $request)
     {
         $query = $request->input('query');
         $category_id = $request->input('category_id');
     
         // Récupérer la catégorie sélectionnée dans la session s'il y en a une
         $selectedCategory = session('selectedCategory');
     
         $questions = Question::query();
     
         if ($query) {
             // Si un terme de recherche est fourni, ajoutez-le à la requête
             $questions->where(function ($q) use ($query) {
                 $q->where('title', 'like', '%' . $query . '%')
                     ->orWhere('content', 'like', '%' . $query . '%');
             });
         }
     
         // Vérifier s'il y a une catégorie sélectionnée
         if ($selectedCategory) {
             // Filtrer par la catégorie sélectionnée
             $questions->where('category_id', $selectedCategory);
         } elseif ($category_id) {
             // S'il n'y a pas de catégorie sélectionnée dans la session, utiliser celle fournie dans la requête
             $questions->where('category_id', $category_id);
             // Enregistrer la catégorie sélectionnée dans la session
             session(['selectedCategory' => $category_id]);
         }
     
         $questions = $questions->get();
     
         // Réinitialiser la variable $category_id après chaque recherche
         $category_id = null;
     
         return view('question.index', ['questions' => $questions]);
     }
     
     


    public function like(Question $question, Request $request)
    {
        // Vérifie si l'utilisateur a déjà aimé cette question
        if (!$request->session()->has('liked_questions')) {
            $request->session()->put('liked_questions', []);
        }
    
        $likedQuestions = $request->session()->get('liked_questions');
    
        if (!in_array($question->id, $likedQuestions)) {
            // Incrémente le nombre de likes dans la base de données
            $question->increment('likes');
    
            // Enregistre l'état de like dans la session
            $likedQuestions[] = $question->id;
            $request->session()->put('liked_questions', $likedQuestions);

            
        // Déclencher la notification DiscussionLikedNotification
        $question->user->notify(new DiscussionLikedNotification(auth()->user(), $question));
        }
    
        return redirect()->back();
    }

    public function index()
   {
     $questions = Question::latest()->paginate(10); // Replace 'Question' with your actual model name.
    return view('question.index', compact('questions'));
   }


   public function indexAdmin()
   {
       $questions = Question::all();
       return view('admin.voirQuestion', compact('questions'));
   }

   public function showAdmin(Question $question)
   {
       return view('admin.voirReponse', compact('question'));
   }

   public function destroyAdmin(Question $question)
   {
       $question->delete();
       return redirect()->route('admin.voirQuestion')->with('success', 'Question supprimée avec succès');
   }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vérifier si l'utilisateur est connecté
        if (Auth::check()) {
            // Vérifier le type d'utilisateur
            if (Auth::user()->user_type === 'mentor') {
                // Si c'est un mentor, récupérer ses expertises
                $userExpertise = json_decode(Auth::user()->expertise);
                // Récupérer les catégories correspondant à ses expertises
                $categories = Category::whereIn('nom', $userExpertise)->get();
            } elseif (Auth::user()->user_type === 'student') {
                // Si c'est un étudiant, récupérer ses centres d'intérêt
                $userInterests = json_decode(Auth::user()->interests);
                // Récupérer les catégories correspondant à ses centres d'intérêt
                $categories = Category::whereIn('nom', $userInterests)->get();
            }
    
            return view('question.create', compact('categories'));
        }
    
        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        return redirect()->route('login');
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifiez si l'utilisateur est authentifié
        if (!auth()->check()) {
            // Si l'utilisateur n'est pas authentifié, redirigez-le vers la page de connexion
            return redirect()->route('login')->with('error', 'Vous devez vous connecter pour poser une question.');
        }
    
        // Validation des données de la requête
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categorie' => 'required|exists:categories,id', // Assurez-vous que l'ID de la catégorie existe dans la table des catégories
            'media' => 'nullable|file|mimes:jpeg,png,mp4|max:10240', // Taille maximale : 10 Mo
        ]);

      
    
        // Liste des mots considérés comme spam
        $spamWords = ['spam', 'insulte', 'merde'];
    
        // Convertir le contenu et le titre en minuscules pour une comparaison insensible à la casse
        $questionContent = strtolower($request->content);
        $questionTitle = strtolower($request->title);
    
        // Vérification des mots spam dans le contenu de la question
        foreach ($spamWords as $spamWord) {
            if (strpos($questionContent, $spamWord) !== false) {
                // Si un mot spam est trouvé dans le contenu, redirigez l'utilisateur avec un message d'avertissement mais reste sur la meme page
                return redirect()->back()->withErrors(['error' => 'Votre question contient des mots considérés comme spam dans le contenu. Veuillez reformuler votre question.']);

            }
        }
    
        // Vérification des mots spam dans le titre de la question
        foreach ($spamWords as $spamWord) {
            if (strpos($questionTitle, $spamWord) !== false) {
                // Si un mot spam est trouvé dans le titre, redirigez l'utilisateur vers questions.index avec un message d'erreur
                // return redirect()->route('question.index')->withErrors(['error' => 'Le titre de votre question contient des mots considérés comme spam. Veuillez reformuler votre question.']);

                return redirect()->back()->withErrors(['error' => 'Le titre de votre question contient des mots considérés comme spam. Veuillez reformuler votre question.']);
            }
        }

        
    // Vérification si un fichier média a été téléchargé
    if ($request->hasFile('media')) {
        // Téléchargement du fichier
        $mediaPath = $request->file('media')->store('public/media');
        // dd($mediaPath);

        // Enregistrement du chemin du fichier dans la base de données
        $question = Question::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'category_id' => $request->categorie,
            'media_path' => $mediaPath,
        ]);
    } else {
        // Création de la question sans fichier média
        $question = Question::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'category_id' => $request->categorie,
        ]);
    }
    
        
        // Redirigez l'utilisateur vers la page des questions avec un message de succès
        return redirect()->route('question.index')->with('success', 'Question ajoutée avec succès.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
   {
      $question = Question::findOrFail($id);
      return view('question.show', compact('question'));
   }

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Question $question)
{
    // Vérifiez si l'utilisateur connecté est le créateur de la question
    if (auth()->user()->id !== $question->user_id) {
        return redirect()->route('question.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer cette question.');
    }

    // Supprimer la question
    $question->delete();

    return redirect()->route('question.index')->with('success', 'Question supprimée avec succès.');
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   
}
