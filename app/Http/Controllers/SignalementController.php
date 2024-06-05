<?php

namespace App\Http\Controllers;

use App\Models\Signalement;
use Illuminate\Http\Request;
use App\Notifications\QuestionReportedNotification;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SignalementController extends Controller
{

   
    



    public function report($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return redirect()->back()->with('error', 'Question not found.');
        }
    
      
        // Incrémentez le compteur de signalements dans la base de données
        DB::table('questions')->where('id', $question->id)->increment('reports_count');
    
        // Envoyez la notification à l'administrateur
        $admin = User::where('user_type', 'admin')->first();
        $admin->notify(new QuestionReportedNotification($question));
    
        // Redirigez l'utilisateur vers la page précédente ou une autre page appropriée
        return redirect()->back()->with('success', 'Le signalement a été envoyé avec succès, merci de votre bienveillance.');
    }
    



   
    public function index()
    {
        $reports = Signalement::with('question')->get();
        return view('admin.gestionSignalement', compact('reports'));
    }


  
    /**
     * Store a newly created resource in storage.
     */
   
    /**
     * Display the specified resource.
     */
    public function show(Signalement $signalement)
    {
        //
          return view('admin.pageSignalement');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Signalement $signalement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Signalement $signalement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

}
