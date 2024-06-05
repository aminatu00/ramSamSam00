<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Question;
class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::latest()->paginate(10); // Replace 'Question' with your actual model name.
    return view('question.index', compact('questions'));
        // return view('mentor.accueil');
    }

    


    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'niveau' => 'nullable|string',
            'expertise' => 'required|array', // L'expertise est requise pour les mentors
            'expertise.*' => 'string',
            'sub_expertises' => 'nullable|array', // Les sous-expertises sont facultatives
            'sub_expertises.*' => 'string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'mentor', // Définir le type d'utilisateur comme mentor
            'niveau' => $data['niveau'],
            'expertise' => json_encode($data['expertise']), // Convertir en JSON
    'sub_expertises' => json_encode($data['sub_expertises']), // Convertir en JSON
        ]);

        return redirect()->route('listeUser.index')->with('success', 'Inscription mentor réussie.');
    }

    


    public function dashboard()

    {

    // Nombre d'étudiants
    $studentsCount = User::where('user_type', 'student')->count();
    
    
    
    // Vous pouvez également récupérer d'autres statistiques à partir de la table users si nécessaire
    
    return view('mentor.vueStatiqueMentor', [
        'studentsCount' => $studentsCount,
      
        // Passer d'autres données si nécessaire
    ]);
            
          
        
       
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mentor $mentor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mentor $mentor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mentor $mentor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mentor $mentor)
    {
        //
    }
}
