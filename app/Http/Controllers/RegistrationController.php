<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expertise;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function showStudentForm()
     {
         return view('admin.ajoutEtu');
     }

 



    public function showMentorForm()
    {
        $domains = [
            'informatique' => ['java', 'php', 'html', 'css', 'javascript'],
            'reseaux' => ['reseaux sans fil', 'reseaux avec fil'],
            'chimie' => ['chimie organique', 'chimie analytique'],
            'physique' => ['physique quantique', 'physique classique'],
            'math' => ['algèbre', 'analyse'],
        ];

        return view('admin.ajoutMentor', compact('domains'));
    }

   

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $registration)
    {
        //
    }
}
