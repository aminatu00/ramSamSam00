<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionDeletedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $questionId;

    public function __construct($questionId)
    {
        $this->questionId = $questionId;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Votre question a été supprimée par l\'administrateur. Veuillez ne plus enfreindre les règles du forum.',
            'link' => route('question.index'),
            'user_type' => $notifiable->user_type,
            'question_id' => $this->questionId,
        ];
    }
}
