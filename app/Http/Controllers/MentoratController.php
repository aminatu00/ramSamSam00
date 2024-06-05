<?php

namespace App\Http\Controllers;

use App\Models\Mentorat;
use Illuminate\Http\Request;
use App\Models\Sondage;
use App\Models\User; 

use Illuminate\Support\Facades\Auth;

class MentoratController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function showMeetingsForSurvey($surveyId)
     {
         $survey = Sondage::findOrFail($surveyId);
         $user = Auth::user();
     
         // Récupérer les meetings spécifiques à ce sondage
         $meetings = Mentorat::where('sondage_id', $surveyId)->get();
     
         // Vérifiez que l'utilisateur est un étudiant ou un mentor
         if ($user->user_type === 'student' && $user->niveau >= $survey->niveau) {
             return view('mentorat.mentorat', compact('survey', 'meetings'));
         } elseif ($user->user_type === 'mentor') {
             return view('mentorat.mentorat', compact('survey', 'meetings'));
         }
     
         // Sinon, rediriger avec un message d'erreur
         return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à voir ces meetings.');
     }
     
     
          
          public function index(Request $request)
          {
              // Récupérer le mentor connecté
              $mentor = Auth::user();
              
              // Récupérer le domaine du mentor depuis la base de données
              $mentorat = Mentorat::where('mentor_id', $mentor->id)->first();
              $domaine = $mentorat ? $mentorat->domaine : null;
              
               // Récupérer les meetings créés par ce mentor
         $meetings = Mentorat::where('mentor_id', $mentor->id)->get();
              
         
              // Passer la variable $meetings à la vue
              return view('mentorat.mentorat', compact('meetings'));
          }
         
         
          public function store(Request $request)
          {
              // Validation des données envoyées par le formulaire
              $validatedData = $request->validate([
                  'date' => 'required|date',
                  'time' => 'required',
                  'meeting_link' => 'required|string', // Retirez la règle 'url'
                  'domaine' => 'required',
                  'subject' => 'required',
                  'survey_id' => 'required',
                  'session_type' => 'required|string|in:online,in_person',
              ]);
          
              // Récupérer l'ID du sondage à partir de la requête
              $surveyId = $request->input('survey_id');
          
              // Récupérer l'identifiant du mentor à partir de l'utilisateur connecté
              $mentorId = auth()->id();
          
              // Créer un nouvel objet Mentorat avec les données validées
              $meeting = new Mentorat([
                  'date' => $validatedData['date'],
                  'time' => $validatedData['time'],
                  'meeting_link' => $validatedData['meeting_link'],
                  'subject' => $validatedData['subject'],
                  'mentor_id' => $mentorId,
                  'sondage_id' => $surveyId,
                  'domaine' => $validatedData['domaine'],
                  'session_type' => $validatedData['session_type'],
              ]);
          
              // Enregistrer le nouvel objet Mentorat dans la base de données
              $meeting->save();
          
              // Redirection ou autre logique
              return redirect()->route('meetings.index')->with('success', 'Meeting created successfully.');
          }
          
         /**
          * Display the specified resource.
          */
       
     
         /**
          * Show the form for editing the specified resource.
          */
         public function edit(Mentorat $meeting)
         {
             return view('mentorat.editMentorat', compact('meeting'));
         }
     
         /**
          * Update the specified resource in storage.
          */
         public function update(Request $request, Mentorat $meeting)
         {
             $validatedData = $request->validate([
                 'date' => 'required|date',
                 'time' => 'required',
                 'meeting_link' => 'required|string', // Retirez la règle 'url'
                 'subject' => 'required',
                 
             ]);
     
             $meeting->update($validatedData);
     
             return redirect()->route('meetings.index')->with('success', 'Meeting updated successfully!');
         }
     
         /**
          * Remove the specified resource from storage.
          */
         public function destroy(Mentorat $meeting)
         {
             $meeting->delete();
     
             return redirect()->route('meetings.index')->with('success', 'Meeting deleted successfully!');
         }
     
         public function create(Request $request)
         {
             // Récupérer les données des étudiants, le domaine du sondage sélectionné et les informations sur le sondage depuis la requête
             $students = json_decode($request->query('students'), true);
             $selected_subject = $request->query('selected_subject');
             $survey = json_decode($request->query('survey'), true);
             //  dd($students, $selected_subject, $survey);
             // Effectuer toute autre logique nécessaire ici
        
             // Passer les données à la vue
             return view('mentorat.formulaireMentorat', compact('students', 'selected_subject', 'survey'));
         }

    /**
     * Display the specified resource.
     */
    public function show(Mentorat $mentorat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   
}
