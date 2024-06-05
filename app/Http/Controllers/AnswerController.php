<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Notifications\NewReplyNotification;
use App\Notifications\ReplyLikedNotification;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    

    /**
     * Display the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request, Question $question)
    {
        // 1. Vérifie si l'utilisateur est authentifié
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez vous connecter pour répondre à une question.');
        }
    
        // 2. Validation des données de la requête
        $request->validate([
            'content' => 'required',
        ]);
    
        // 3. Filtrage du contenu indésirable
        if ($this->containsForbiddenWords($request->content)) {
            return redirect()->back()->withErrors(['error' => 'Votre réponse contient du contenu non autorisé. Veuillez réessayer avec un contenu approprié.']);
        }
    
        // 4. Création de la réponse
$answer = $question->answers()->create([
    'content' => $request->content,
    'user_id' => auth()->id(),
])->load('question');

    
        // 5. Redirection de l'utilisateur
        if ($answer) {
            // Notifier le propriétaire de la question
$questionOwner = $question->user;
$questionOwner->notify(new NewReplyNotification(auth()->user(), $question, $answer));

// Notifier UserB si des commentaires sont ajoutés à cette réponse
if ($answer->comments && $answer->comments->isNotEmpty()) {
    foreach ($answer->comments as $comment) {
        // Vérifier si UserB est différent de l'auteur du commentaire
        if ($comment->user_id !== auth()->id()) {
            // Envoyer la notification à UserB
            $comment->user->notify(new NewReplyNotification(auth()->user(), $question, $answer, $comment));
        }
    }
}


    
            // Redirection de l'utilisateur
            return view('answer.show', compact('answer', 'question'));
        } else {
            // Gestion de l'échec de la création de la réponse
            return view('question.index', compact('answer', 'question'));
        }
    }
    
    private function containsForbiddenWords($content) {
        // Liste de mots interdits ou motifs de contenu indésirable
        $forbiddenWords = ['spam', 'merde', 'degage']; // Remplacez-les par vos mots indésirables
    
        // Vérifie si le contenu contient des mots indésirables
        foreach ($forbiddenWords as $word) {
            if (stripos($content, $word) !== false) {
                return true;
            }
        }
    
        return false;
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        $answers = $question->answers;
    
        // Charger la vue avec les données de la question et ses réponses
        return view('answer.show', compact('question', 'answers'));
    }
    

    public function like(Answer $answer, Request $request)
    {
        // Vérifie si l'utilisateur a déjà aimé cette réponse
        if (!$request->session()->has('liked_answers')) {
            $request->session()->put('liked_answers', []);
        }
    
        $likedAnswers = $request->session()->get('liked_answers');
    
        if (!in_array($answer->id, $likedAnswers)) {
            // Incrémente le nombre de likes dans la base de données
            $answer->increment('likes');
    
            // Enregistre l'état de like dans la session
            $likedAnswers[] = $answer->id;
            $request->session()->put('liked_answers', $likedAnswers);

            $answer->user->notify(new ReplyLikedNotification(auth()->user(), $answer->question, $answer));

            
        }
    
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        return view('answer.show', compact('answer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        // Vérifiez si l'utilisateur est autorisé à modifier cette réponse
        if ($request->user()->id !== $answer->user_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier cette réponse.');
        }
    
        // Valider les données de la requête
        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);
    
        // Mettez à jour le contenu de la réponse dans la base de données
        $answer->content = $validatedData['content'];
        $answer->save();
    
        // Rediriger l'utilisateur vers la même page avec un message de succès
       // return redirect()->back()->with('success', 'La réponse a été mise à jour avec succès.');
        // Rediriger l'utilisateur vers la page d'accueil avec un message de succès
    
        // Rediriger l'utilisateur vers la page show.blade.php avec un message de succès
    return redirect()->route('answers.show', ['question' => $answer->question_id])->with('success', 'La réponse a été mise à jour avec succès.');
    
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        // Vérifiez si l'utilisateur est autorisé à supprimer cette réponse
        if (auth()->user()->id !== $answer->user_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cette réponse.');
        }

        // Supprimez la réponse
        $answer->delete();

        // Redirigez l'utilisateur vers la page de la question avec un message de succès
        return redirect()->route('answers.show', $answer->question_id)->with('success', 'La réponse a été supprimée avec succès.');
    }

    public function destroyAdmin(Answer $answer)
    {
        $answer->delete();
        return redirect()->back()->with('success', 'Réponse supprimée avec succès');
    }
}
