<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscussionLikedNotification extends Notification
{
    use Queueable;

    protected $liker;
    protected $discussion;

    public function __construct($liker, $discussion)
    {
        $this->liker = $liker;
        $this->discussion = $discussion;
    }

    public function via($notifiable)
    {
        return ['database']; // Cette notification sera stockée dans la base de données
    }

    public function toArray($notifiable)
    {
        // Vérifiez si l'utilisateur qui aime la discussion est différent de l'utilisateur qui a publié la discussion
        if ($this->liker->id !== $this->discussion->user_id) {
            return [
                'discussion_id' => $this->discussion->id,
                'message' => $this->liker->name . ' a aimé votre discussion.', // Message de la notification
                'link' => route('questions.show', $this->discussion->id), // Lien vers la discussion
            ];
        }
        
        return [];
    }

}
