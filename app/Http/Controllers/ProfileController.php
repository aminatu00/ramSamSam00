<?php

namespace App\Http\Controllers;

use App\Models\profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('profil');
    }

    public function update(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6', // Rendre le mot de passe facultatif
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image jusqu'à 2 Mo de type JPEG, PNG, JPG ou GIF
            'niveau' => 'nullable|string|max:255', // Rendre le niveau facultatif
            'interests' => 'nullable|array', // Les centres d'intérêt peuvent être facultatifs
        'interests.*' => 'string', // Chaque centre d'intérêt doit être une chaîne
       
        ]);
    
        // Obtenir l'utilisateur authentifié
        $user = Auth::user();
    
        // Mettre à jour le nom de l'utilisateur
        $user->name = $validatedData['name'];
    
        // Mettre à jour le mot de passe s'il est fourni
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
    

        // Mettre à jour le niveau de l'utilisateur si fourni et si l'utilisateur est un étudiant
    if ($user->user_type == 'student' && isset($validatedData['niveau'])) {
        $user->niveau = $validatedData['niveau'];
    }


        // Mettre à jour l'image de profil si une nouvelle image est téléchargée
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $imageName = time() . '_' . $profileImage->getClientOriginalName();
            $profileImage->storeAs('public/profile_images', $imageName);
            $user->profile_image = 'profile_images/' . $imageName;
        }
         // Mettre à jour les centres d'intérêt de l'utilisateur si fournis et si l'utilisateur est un étudiant
    if ($user->user_type == 'student' && isset($validatedData['interests'])) {
        $user->interests = json_encode($validatedData['interests']);
    }
    
        // Sauvegarder les modifications
        $user->save();
    
        // Rediriger l'utilisateur vers la page de profil avec un message de succès
        // return redirect()->route('profile.show')->with('success', 'Profil mis à jour avec succès.');
        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');

    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(profile $profile)
    {
        //
    }
}
