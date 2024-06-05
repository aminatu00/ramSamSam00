<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Question;
use App\Models\Mentorat;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use App\Notifications\QuestionDeletedNotification;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function deleteReportedQuestion($id)
{
    $question = Question::find($id);
    if ($question) {
        $question->delete();


    // Déclencher la notification pour le propriétaire de la question
    $question->user->notify(new QuestionDeletedNotification($question));    }
    return redirect()->back()->with('success', 'Question supprimée avec succès.');
}




    public function index()
    {
        return view('admin.dashboard');
    }

    public function dashboard()
    {

// Nombre d'étudiants
$studentsCount = User::where('user_type', 'student')->count();

// Nombre de mentors
$mentorsCount = User::where('user_type', 'mentor')->count();

// Nombre d'administrateurs
$adminsCount = User::where('user_type', 'admin')->count();

 // Nombre de questions
 $questionsCount = Question::count();

 // Nombre de signalements
 $reportsCount = Question::sum('reports_count');

// Vous pouvez également récupérer d'autres statistiques à partir de la table users si nécessaire

 // Requête pour le graphique en courbes
 $forumActivityData = DB::table('questions')
 ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as num_questions'))
 ->groupBy(DB::raw('DATE(created_at)'))
 ->get()
 ->pluck('num_questions', 'date')
 ->toArray();

// Requête pour le diagramme en cercle
$mentorshipDistributionData = Mentorat::select('domaine', DB::raw('COUNT(*) as num_mentorats'))
 ->groupBy('domaine')
 ->get()
 ->pluck('num_mentorats', 'domaine')
 ->toArray();

  $colors = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
        '#e74a3b', '#858796', '#5a5c69', '#f8f9fc',
        '#e9ecef', '#343a40'
    ];

    
return view('admin.vueStatiqueAdmin', [
    'studentsCount' => $studentsCount,
    'mentorsCount' => $mentorsCount,
    'adminsCount' => $adminsCount,
    'questionsCount' => $questionsCount,
    'reportsCount' => $reportsCount,
    'forumActivityData' => $forumActivityData,
    'mentorshipDistributionData' => $mentorshipDistributionData,
    'colors'=>$colors
    // Passer d'autres données si nécessaire
]);

//  return view('admin.vueStatiqueAdmin',compact('studentsCount','mentorsCount','adminsCount',''));
        
      
    }

    /**
     * Show the form for creating a new resource.
     */

     public function showReportedQuestion($id)
     {
         $question = Question::where('id', $id)->where('reports_count', '>', 0)->first();
         if (!$question) {
             return redirect()->route('reported.admin')->with('error', 'Question not found or not reported.');
         }
     
         // Rediriger vers la page de gestion des signalements avec la question spécifique
         return view('admin.voirQuestionSignale', compact('question'));
     }
     



     public function manageReportedQuestions()
     {
         // Récupérer les questions avec des signalements
         $reportedQuestions = Question::where('reports_count', '>', 0)->get();
 
         // Passer les questions signalées à la vue
         return view('admin.gestionSignalement', compact('reportedQuestions'));
     }

    public function create()
    {
      
        // return view('admin.pageSignalement');
        
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editStudent($id)
    {
        $student = User::findOrFail($id);
        return view('admin.editEtu', compact('student'));
    }

    // Method to update a student
    public function updateStudent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'niveau' => 'required|string|max:255',
            'interests' => 'required|array',
        ]);

        $student = User::findOrFail($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->niveau = $request->niveau;
        $student->interests = json_encode($request->interests);
        $student->save();

        return redirect()->route('listeUser.index')->with('success', 'Student updated successfully.');
    }

    // Method to delete a student
    public function destroyStudent($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return redirect()->route('listeUser.index')->with('success', 'Student deleted successfully.');
    }

    // Similar methods for mentors if needed
    public function editMentor($id)
    {
        $mentor = User::findOrFail($id);
        return view('admin.editMentor', compact('mentor'));
    }

    public function updateMentor(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'niveau' => 'required|string|max:255',
            'expertise' => 'required|array',
            'sub_expertises' => 'required|array',
        ]);

        $mentor = User::findOrFail($id);
        $mentor->name = $request->name;
        $mentor->email = $request->email;
        $mentor->niveau = $request->niveau;
        $mentor->expertise = json_encode($request->expertise);
        $mentor->sub_expertises = json_encode($request->sub_expertises);
        $mentor->save();

        return redirect()->route('listeUser.index')->with('success', 'Mentor updated successfully.');
    }

    public function destroyMentor($id)
    {
        $mentor = User::findOrFail($id);
        $mentor->delete();

        return redirect()->route('listeUser.index')->with('success', 'Mentor deleted successfully.');
    }
}
