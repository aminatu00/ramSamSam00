<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyLikedNotification extends Notification
{
    use Queueable;

    protected $liker;
    protected $question;
    protected $reply;

    public function __construct($liker, $question, $reply)
    {
        $this->liker = $liker;
        $this->question = $question;
        $this->reply = $reply;
    }

    public function via($notifiable)
    {
        return ['database']; // Cette notification sera stockée dans la base de données
    }

    public function toArray($notifiable)
    {
        // Vérifiez si l'utilisateur qui aime le commentaire est différent de l'utilisateur qui a publié le commentaire
        if ($this->liker->id !== $this->reply->user_id) {
            return [
                'question_id' => $this->question->id,
                'reply_id' => $this->reply->id,
                'message' => $this->liker->name . ' a aimé votre commentaire.', // Message de la notification
                'link' => route('answers.show', $this->question->id), // Lien vers la question
            ];
        }
        
        return [];
    }
}
