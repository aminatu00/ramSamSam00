<?php

namespace App\Http\Controllers;

// use App\Models\Voter;
use App\Models\Sondage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Voter;
class VoterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function submitVote(Request $request, $sondageId, $option)
    {
        $user = Auth::user();
        $sondage = Sondage::find($sondageId);
    
        $existingVote = Voter::where('user_id', $user->id)->where('sondage_id', $sondageId)->first();
    
        if ($existingVote) {
            if ($existingVote->option_voted !== $option) {
                $existingVote->update(['option_voted' => $option]);
            }
        } else {
            $newVote = Voter::create([
                'user_id' => $user->id,
                'sondage_id' => $sondageId,
                'option_voted' => $option,
                'vote_count' => 1,
            ]);

              // Ajouter le nouveau vote à la session de l'utilisateur
        $userVotes = session()->get('user_votes', []);
        $userVotes[$sondageId] = $newVote;
        session()->put('user_votes', $userVotes);
        }
    
        // Récupérer tous les votes pour ce sondage
        // Mettre à jour les compteurs de vote pour chaque option
    $voteCounts = [];

    // Récupérer tous les votes pour ce sondage
    $votes = Voter::where('sondage_id', $sondageId)->get();

    // Compter les votes pour chaque option
    foreach ($votes as $vote) {
        $optionVoted = $vote->option_voted;

        // Vérifier si l'option existe déjà dans le tableau
        if (isset($voteCounts[$optionVoted])) {
            $voteCounts[$optionVoted]++;
        } else {
            $voteCounts[$optionVoted] = 1;
        }
    }
        
    $totalVotesForSondage = Voter::where('sondage_id', $sondageId)->count();


$surveys = Sondage::all();
$options = json_decode($sondage->options, true);

return view('mentorat.pageSondage', compact(  'voteCounts', 'surveys','totalVotesForSondage'));

    }




    
    public function show($surveyId)
    {
        $survey = Sondage::findOrFail($surveyId);
        $options = json_decode($survey->options, true);
        $voteCounts = [];
        
        // Vérifier si l'utilisateur actuel est le créateur du sondage
        if (auth()->user()->id === $survey->mentor_id) {
            // Récupérer tous les votes pour ce sondage
            $votes = Voter::where('sondage_id', $surveyId)->get();
            
            // Compter les votes pour chaque option
            foreach ($votes as $vote) {
                $optionVoted = $vote->option_voted;
    
                // Vérifier si l'option existe déjà dans le tableau
                if (isset($voteCounts[$optionVoted])) {
                    $voteCounts[$optionVoted]++;
                } else {
                    $voteCounts[$optionVoted] = 1;
                }
            }
            
            $totalVotesForSondage = $votes->count();
            $surveys = Sondage::all();
    
            return view('mentorat.pageSondage', compact('survey', 'options', 'voteCounts', 'totalVotesForSondage','surveys'));
        } else {
            // Rediriger l'utilisateur vers une page d'erreur ou une autre page appropriée
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à afficher ce sondage.');
        }
    }
    

    // public function show($surveyId)
    // {
    //     $survey = Sondage::findOrFail($surveyId);
    //     $options = json_decode($survey->options, true);
    //     $voteCounts = [];
    
    //     // Récupérer les données agrégées des votes à partir de la table Sondage
    //     $votes = $survey->votes()->get();
    
    //     foreach ($options as $option) {
    //         // Initialiser le compteur de votes pour chaque option
    //         $voteCounts[$option] = 0;
    
    //         // Parcourir les données agrégées et mettre à jour le compteur de votes
    //         foreach ($votes as $vote) {
    //             if ($vote->option_voted === $option) {
    //                 $voteCounts[$option] += $vote->vote_count;
    //             }
    //         }
    //     }
    
    //     // Récupérer tous les sondages pour affichage
    //     $surveys = Sondage::all();
    //     $totalVotesForSondage = $votes->count();

    
    //     return view('mentorat.pageSondage', compact('survey', 'options', 'voteCounts', 'surveys','totalVotesForSondage'));
    // }




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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voter $voter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voter $voter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voter $voter)
    {
        //
    }
}
