<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
{
    $user = auth()->user(); // Récupérer l'utilisateur actuellement connecté

    if ($user->user_type === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->user_type === 'student') {
        return redirect()->route('student.dashboard');
    } elseif ($user->user_type === 'mentor') {
        return redirect()->route('mentor.dashboard');
    }

    return redirect()->route('home'); // Redirection par défaut
}
}
