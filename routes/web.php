<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SondageController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\MentoratController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DemandeMentoratController;
use App\Http\Controllers\RegistrationController;


use App\Http\Controllers\SignalementController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 // administrateurrrrrrr
 Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
 // studenttttttttttt
 Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
 // mentorrrrrrrrrrr
 Route::get('/mentor/dashboard', [MentorController::class, 'dashboard'])->name('mentor.dashboardeu');



    //categorie qui s'affiche 
Route::get('/categorie', [CategoryController::class, 'index'])->name('categorie.index');
Route::get('/categorie/{id}/questions', [QuestionController::class, 'getQuestionsByCategory'])->name('categorie.show');

//creer question 
Route::get('/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/questionstore', [QuestionController::class, 'store'])->name('questions.store');

//chercher question
Route::get('/questions/search', [QuestionController::class, 'search'])->name('questions.search');
//afficher la liste des question
Route::get('/questions', [QuestionController::class, 'index'])->name('question.index');
//pour la reponses
Route::get('/questions/{question}/answers', [AnswerController::class, 'show'])->name('answers.show');
//supprimer reponses 
Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');
//enregister la reponse
Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');
//aimer question
Route::post('/questions/{question}/like', [QuestionController::class, 'like'])->name('questions.like');
 //affichage notification
 Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');   
    //affichage question
    Route::get('/questiones/{question}', [QuestionController::class, 'show'])->name('questions.show');
    //supression question
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    //route d'aime de reponse
    Route::post('/answers/{answer}/like', [AnswerController::class, 'like'])->name('answers.like');
    //mis a jouir de la reponse a pres modification
    Route::put('/answers/{answer}', [AnswerController::class, 'update'])->name('answers.update');
    //edition reponse
    Route::get('/answers/{answer}/edit', [AnswerController::class, 'edit'])->name('answers.edit');
    //liste des etidiants dans le systeme
    Route::get('/listeUser', [UserController::class, 'index'])->name('listeUser.index');
    //edition des utilisateur
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    //pour supprimer un utilisateur
    Route::delete('/users/{user}/destroy', [UserController::class, 'destroy'])->name('users.destroy');

    //affichage page notification
    Route::get('/notif', [NotificationController::class, 'show'])->name('notification.show');
    //route pour l'affichage du formulaire de creation de sondage
    Route::get('/sondage/create', [SondageController::class, 'create'])->name('sondage.create');
    //enregister sondage dan sla base de donnes
    Route::post('/surveys', [SondageController::class, 'store'])->name('sondage.store');
    //afficher page sondage pour les etudiants
    // Route::get('/surveys/{id}', [SondageController::class, 'show'])->name('sondage.show');
    //test pour afficher sondage sans id
    Route::get('/sondage', [SondageController::class, 'showForUser'])->name('sondage.showForUser');
    //editer sondage
    
Route::get('sondages/{id}/edit', [SondageController::class, 'edit'])->name('sondages.edit');
Route::put('sondages/{id}', [SondageController::class, 'update'])->name('sondages.update');
    //route entegister spndage
    // Route::get('/vote/{surveyId}/{option}', [VoteController::class, 'vote'])->name('vote');
    //
    // Route::get('/vote/{id}', [VoteController::class, 'show'])->name('vote.show');
    //
    // Route::get('/sondageuu', [VoteController::class, 'store'])->name('responses.store');
//
//enregister sondage dans la base de donnee
Route::post('/vote/{surveyId}/{option}', [VoterController::class, 'submitVote'])->name('vote.submit');
// Route::get('/vote/{surveyId}', [VoterController::class, 'show'])->name('vote.show');

//la vue pour mentor voit resulat sondage
Route::get('/survey/{surveyId}', [VoterController::class, 'show'])->name('view.survey');

//pour supprimer sondage
Route::get('/surveys/{surveyId}', [SondageController::class, 'destroy'])->name('sondages.destroy');

//pour creer mentorat 
Route::get('/mentorat/create/{surveyId}', [SondageController::class, 'createMentorat'])->name('mentorat.create');

//route pour formulaire de mentorat
// Route::post('/meetings/create/{surveyId}/{survey}', [MentoratController::class, 'create'])->name('meetings.create');

Route::get('/meetings/create', [MentoratController::class, 'create'])->name('meetings.create');

// Route::delete('/meetings/create/{surveyId}/{survey}', [MentoratController::class, 'destroy'])->name('meetings.destroy');

Route::post('/meetings', [MentoratController::class, 'store'])->name('meetings.store');

Route::get('/meetings/mentorat/', [MentoratController::class, 'index'])->name('meetings.index');


// Route pour afficher le formulaire de modification
Route::get('/meetings/{meeting}/edit', [MentoratController::class, 'edit'])->name('meetings.edit');

// Route pour mettre à jour le meeting après modification
Route::put('/meetings/{meeting}', [MentoratController::class, 'update'])->name('meetings.update');

// Route pour supprimer le meeting
Route::delete('/meetings/{meeting}', [MentoratController::class, 'destroy'])->name('meetings.destroy');

//
Route::delete('/meetings/{meeting}', [MentoratController::class, 'destroy'])->name('meetings.destroy');

//la photo de profil
Route::get('/profile',[ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update',[ProfileController::class, 'update'])->name('profile.update');

    //associer un sondage a un meet 
    Route::get('/surveys/{survey}/meetings', [MentoratController::class, 'showMeetingsForSurvey'])->name('surveys.meetings');


//mentorat pour que les etudiants puissent voir les mentorats
// Route::get('/meetings/mentorat', [MentoratController::class, 'index'])->name('meetings.index');

//demande pour etre mentor

Route::get('/mentor-request', [DemandeMentoratController::class, 'showForm'])->name('mentor.request');
Route::post('/mentor-request', [DemandeMentoratController::class, 'submitForm'])->name('mentor.request.submit');



//vue statique 
// routes/web.php
Route::get('/admin/dashboardeu', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboardeu');
Route::get('/mentor/dashboardeu', [App\Http\Controllers\MentorController::class, 'index'])->name('mentor.dashboard');

//pour admin puisse ajouter etudiant et mentor 
Route::get('/register/studentss', [RegistrationController::class, 'showStudentForm'])->name('register.student.form');
Route::post('/register/studentss', [StudentController::class, 'register'])->name('register.student');

Route::get('/register/mentor', [RegistrationController::class, 'showMentorForm'])->name('register.mentor.form');
Route::post('/register/mentors', [MentorController::class, 'register'])->name('register.mentor');






// Routes for student management modifier Etudiants supprimer etudinats  
Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
Route::delete('/students/{id}', [AdminController::class, 'destroyStudent'])->name('students.destroy');

// Routes for mentor management (modifier mentors supprimer mentor
Route::get('/mentors/{id}/edit', [AdminController::class, 'editMentor'])->name('mentors.edit');
Route::put('/mentors/{id}', [AdminController::class, 'updateMentor'])->name('mentors.update');
Route::delete('/mentors/{id}', [AdminController::class, 'destroyMentor'])->name('mentors.destroy');

//voir le profil du mentor
Route::get('/mentors/{id}', [UserController::class, 'show'])->name('mentors.show');



//route pour signalement 
Route::post('/questions/{id}/report', [SignalementController::class, 'report'])->name('questions.report');

Route::get('/admin/reported-questions', [AdminController::class, 'manageReportedQuestions'])->name('reported.admin');

//page des questions signales

// Route::get('/questions/reporte', [AdminController::class, 'create'])->name('reported.questions');

//la notification de l'admin
// routes/web.php

//signalement pour admin
Route::get('/gerer-signalements', [SignalementController::class, 'index'])->name('reports.manage');


// Route::get('/admin/notifications', [SignalementController::class, 'indexe'])->name('admin.notifications.index');

Route::get('/admin/reported-questions/{id}', [AdminController::class, 'showReportedQuestion'])->name('admin.notification.show');



// Route::get('/gerer-signalements', [SignalementController::class, 'index'])->name('reports.manage');


Route::delete('/admin/reported-questions/{id}', [AdminController::class, 'deleteReportedQuestion'])->name('reported.questions.delete');

// Route::post('/signaler/contenue/{question_id}', [SignalementController::class, 'create'])->name('reports.create');


// Route::post('/signaler-contenu', [SignalementController::class, 'store'])->name('reports.store');

//admin peut voir question , reponses et aussi peut supprimer questions , reponses

Route::get('Unequestions', [QuestionController::class, 'indexAdmin'])->name('questionAdmin.index');
Route::get('Unequestions/{question}', [QuestionController::class, 'showAdmin'])->name('questionAdmin.show');
Route::delete('Unequestions/{question}', [QuestionController::class, 'destroyAdmin'])->name('questionAdmin.destroy');
Route::delete('Uneanswers/{answer}', [AnswerController::class, 'destroyAdmin'])->name('answerAdmin.destroy');




//le testtttt
// Route::get('/testeuuuu', [StudentController::class, 'test'])->name('test');
});

