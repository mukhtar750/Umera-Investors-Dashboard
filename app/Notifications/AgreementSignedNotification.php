<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgreementSignedNotification extends Notification
{
    use Queueable;

    public $document;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($document, $user)
    {
        $this->document = $document;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Agreement Signed')
            ->line("User {$this->user->name} has signed the agreement: {$this->document->title}.")
            ->action('View Document', route('legal.documents.index'))
            ->line('You can view the signed document in the dashboard.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Agreement signed by {$this->user->name}",
            'document_id' => $this->document->id,
            'user_id' => $this->user->id,
            'url' => route('legal.documents.index'),
        ];
    }
}
