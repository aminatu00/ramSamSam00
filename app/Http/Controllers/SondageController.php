<?php

namespace App\Http\Controllers;

use App\Models\Sondage;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use App\Models\Voter;


class SondageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function createMentorat()
    {
        return view('mentorat.mentorat');
    }

    public function showForUser(Request $request)
    {
        // Récupérer l'expertise sélectionnée par le mentor lors de la création du sondage
        $expertise = $request->subject;
    
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Initialiser la requête pour récupérer les étudiants
        $studentsQuery = User::where('user_type', 'student');
    
        // Filtrer les étudiants en fonction de l'expertise sélectionnée
        $studentsQuery->whereJsonContains('interests', $expertise)
                      ->where('niveau', '<=', $user->niveau);
    
        // Récupérer la liste des étudiants filtrés
        $students = $studentsQuery->get();
    
        // Initialiser la requête pour récupérer les sondages
        $surveysQuery = Sondage::query();
    
        // Vérifier si l'utilisateur connecté est un mentor
        if ($user->user_type === 'mentor') {
            // Filtrer les sondages en fonction de l'identifiant du mentor
            $surveysQuery->where('mentor_id', $user->id);
        }
    
        // Récupérer tous les sondages qui correspondent aux critères
        $surveys = $surveysQuery->get();

        // Récupérer les options de chaque sondage
    $options = [];
    foreach ($surveys as $survey) {
        $options[$survey->id] = json_decode($survey->options);
    }
    // dd($options);

$percentage = [];
    $voteCounts = [];
    $totalVotesForSondage = [];

    foreach ($options as $sondageId => $sondageOptions) {
        $totalVotesForSondage[$sondageId] = Voter::where('sondage_id', $sondageId)->count();
        foreach ($sondageOptions as $option) {
            $totalVotesForOption = Voter::where('sondage_id', $sondageId)
                                        ->where('option_voted', $option)
                                        ->count();
            $percentage[$sondageId][$option] = $totalVotesForSondage[$sondageId] > 0 ? ($totalVotesForOption / $totalVotesForSondage[$sondageId]) * 100 : 0;
            $voteCounts[$option] = $totalVotesForOption;
        }
    }

    return view('mentorat.pageSondage', compact('students', 'surveys', 'expertise', 'options', 'percentage', 'voteCounts', 'totalVotesForSondage','user'));
}
    


    // public function show(Sondage $sondage)
    // {
    //     $surveys = Sondage::all();
    //     // Passer $sondage à la vue lors de son rendu
    //     return view('mentorat.pageSondage', ['sondage' => $sondage, 'surveys' => $surveys]);
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $expertises = json_decode(auth()->user()->expertise);
    $subExpertises = json_decode(auth()->user()->sub_expertises); // Récupérer les sous-expertises
    $expertiseMap = [
        'informatique' => ['java', 'php', 'html', 'css', 'javascript'],
        'reseaux' => ['reseaux sans fil', 'reseaux avec fil'],
        'chimie' => ['chimie organique', 'chimie analytique'],
        'physique' => ['physique quantique', 'physique classique'],
        'math' => ['algèbre', 'analyse'],
    ];
   
    
    return view('mentorat.formCreationSondage', compact('expertises', 'subExpertises','expertiseMap'));
}

    /**
     * Store a newly created resource in storage.
     */
    // SondageController.php

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'subject' => 'required|string',
            'question' => 'required|string',
            'options' => 'required|array',
            'expiry_date' => 'required|date',
        ]);
    
        // Récupération de l'utilisateur connecté
        $user = auth()->user();
    
        // Création du sondage dans la base de données
        $sondage = Sondage::create([
            'user_id' => $user->id, // ID de l'utilisateur connecté
            'subject' => $request->subject,
            'question' => $request->question,
            'options' => json_encode($request->options),
            'expiry_date' => $request->expiry_date,
            'mentor_id' => $user->id, // Assurez-vous d'assigner le mentor_id ici

     
        ]);
      
    
        // Redirection vers la page de visualisation du sondage
        return redirect()->route('sondage.showForUser', $sondage)->with('success', 'Le sondage a été créé avec succès.');
    }
    






    /**
     * Display the specified resource.
     */
   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sondage = Sondage::findOrFail($id);

        // Vérifiez si l'utilisateur connecté est le créateur du sondage
        if (Auth::id() !== $sondage->user_id) {
            return redirect()->route('sondage.showForUser')->with('error', 'Vous n\'êtes pas autorisé à modifier ce sondage.');
        }

        return view('mentorat.editSondage', compact('sondage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sondage = Sondage::findOrFail($id);

        // Vérifiez si l'utilisateur connecté est le créateur du sondage
        if (Auth::id() !== $sondage->user_id) {
            return redirect()->route('sondage.showForUser')->with('error', 'Vous n\'êtes pas autorisé à modifier ce sondage.');
        }

        // Validation des données du formulaire
        $request->validate([
            'subject' => 'required|string',
            'question' => 'required|string',
            'options' => 'required|string',
            'expiry_date' => 'required|date',
        ]);

        // Mise à jour du sondage dans la base de données
        $sondage->update([
            'subject' => $request->subject,
            'question' => $request->question,
            'options' => $request->options,
            'expiry_date' => $request->expiry_date,
        ]);

        // Redirection avec un message de succès
        return redirect()->route('sondage.showForUser')->with('success', 'Le sondage a été modifié avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    /**
 * Remove the specified resource from storage.
 */
public function destroy($surveyId)
{
    // Rechercher le sondage par son ID
    $sondage = Sondage::findOrFail($surveyId);

    // Supprimer le sondage de la base de données
    $sondage->delete();

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Le sondage a été supprimé avec succès.');
}
    /**
     * Show the form for creating a new resource.
     */
   
}
