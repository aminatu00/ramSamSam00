<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReplyNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $question;
    protected $answer;
    protected $comment;

    public function __construct($user, $question, $answer, $comment = null)
    {
        $this->user = $user;
        $this->question = $question;
        $this->answer = $answer;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database']; // Cette notification sera stockée dans la base de données
    }

    public function toArray($notifiable)
    {
        // Vérifiez si l'utilisateur qui a répondu à la question est différent de l'utilisateur qui a posé la question
        if ($this->question && $this->answer->user_id !== $this->question->user_id) {
            return [
                'reply_id' => $this->answer->id,
                'message' => 'Vous avez une nouvelle réponse à votre question.', // Message de la notification
                'link' => route('answers.show', $this->answer->id), // Lien vers la réponse
            ];
        }
        
        return [];
    }
}
