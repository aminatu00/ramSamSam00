<?php

namespace App\Http\Controllers;
use App\Models\Question;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return view('student.dashboard');
    // }

    public function index()
    {
        $questions = Question::latest()->paginate(10); // Replace 'Question' with your actual model name.
    return view('question.index', compact('questions'));
       
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'niveau' => 'nullable|string',
            'interests' => ['nullable', 'array'],
            'interests.*' => ['string'],
        ]);
// Convertir les intérêts en JSON
$interestsJson = json_encode($data['interests']);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'student',
            'niveau' => $data['niveau'],
              'interests' => $interestsJson,
        ]);

        return redirect()->route('listeUser.index')->with('success', 'Inscription étudiant réussie.');
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
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
