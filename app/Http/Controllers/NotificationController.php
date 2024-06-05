<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
public function showNotifications()
{
    $user = Auth::user();
    $notifications = $user->unreadNotifications;

    return view('notification', compact('notifications'));
}

    
    public function index()
    {
        // Récupérer toutes les notifications de l'utilisateur actuel
        $user = Auth::user();
        $notifications = $user->notifications;
    
        // Marquer les notifications comme lues si elles ne le sont pas déjà
        $user->unreadNotifications->markAsRead();
    
        return view('notification', compact('notifications'));
    }

    
    
//     public function showNotifications()
// {
//     $notifications = auth()->user()->notifications; // Récupère les notifications de l'utilisateur connecté
//     return view('notifications.index', compact('notifications'));
// }



// public function indexe()
//     {
//         $notifications = auth()->user()->unreadNotifications;

//         return view('admin.notif', compact('notifications'));
//     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
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
 * Display the specified resource.
 */
/**
 * Display the specified resource.
 */
public function show(Notification $notification)
{
    // Retrieve notifications for the current user
    $user = Auth::user();
    $notifications = $user->unreadNotifications;

    // Mark notifications as read
    $user->unreadNotifications->markAsRead();

    // Pass notifications data to the view along with the specific notification
    return view('notification', [
        'notifications' => $notifications,
        'notification' => $notification
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
