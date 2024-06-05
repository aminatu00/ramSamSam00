<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
    
        // Initialiser la requête pour récupérer les étudiants
        $studentsQuery = User::where('user_type', 'student');
    
        // Initialiser la requête pour récupérer les mentors
        $mentorsQuery = User::where('user_type', 'mentor');
    
        // Supprimer les guillemets doubles supplémentaires autour de la valeur "math"
        $expertise = json_decode($user->expertise, true);
    
        // Si l'utilisateur est un mentor
        if ($user->user_type === 'mentor') {
            // Filtrer les étudiants selon les critères du mentor
            $studentsQuery->where(function ($query) use ($user, $expertise) {
                foreach ($expertise as $exp) {
                    $query->orWhereJsonContains('interests', $exp);
                }
            })->where('niveau', '<', $user->niveau); // Le niveau de l'étudiant est inférieur ou égal au niveau du mentor
    
            // Filtrer les mentors selon les critères du mentor
            $niveau = $user->niveau;
    
            // Vérifiez que $niveau n'est pas vide ou null
            if (!empty($niveau)) {
                $niveauArray = json_decode($niveau);
    
                // Si $niveauArray est toujours null, définissez une valeur par défaut ou gérez cette condition
                if ($niveauArray !== null) {
                    $mentorsQuery->where(function ($query) use ($expertise, $niveauArray) {
                        foreach ($expertise as $exp) {
                            $query->orWhereJsonContains('expertise', $exp);
                        }
                    })->where('niveau', '>', $niveauArray); // Le niveau du mentor est supérieur à celui du mentor actuel
                }
            }
        }
        // Si l'utilisateur est un étudiant
        elseif ($user->user_type === 'student') {
            // Filtrer les mentors selon les centres d'intérêt et le niveau de l'étudiant
            $mentorsQuery->where(function ($query) use ($user) {
                // Filtrer les mentors ayant au moins un centre d'intérêt commun avec l'étudiant
                foreach (json_decode($user->interests) as $interest) {
                    $query->orWhereJsonContains('expertise', $interest);
                }
            })
            ->where('niveau', '>', $user->niveau) // Le niveau du mentor est supérieur à celui de l'étudiant
            ->whereNotIn('id', function ($query) use ($user) {
                // Exclure les mentors qui ne correspondent pas aux critères spécifiques des étudiants
                $query->select('id')
                    ->from('users')
                    ->where('user_type', 'mentor')
                    ->where('niveau', '<=', $user->niveau) // Le niveau du mentor est inférieur ou égal à celui de l'étudiant
                    ->whereIn('expertise', json_decode($user->interests)); // Utiliser whereIn pour correspondre aux centres d'intérêt
            });
        }
    
        // Exclure l'utilisateur actuellement connecté de la liste des mentors
        $mentorsQuery->where('id', '!=', $user->id);
    
        // dd($mentorsQuery->toSql(), $mentorsQuery->getBindings());
    
        // Récupérer la liste des étudiants et des mentors en fonction du type d'utilisateur
        $students = $studentsQuery->get();
        $mentors = $mentorsQuery->get();
    
        return view('listeUser', compact('students', 'mentors'));
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
    public function show($id)
{
    $mentor = User::findOrFail($id);
    return view('mentor.profilMentor', compact('mentor'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
