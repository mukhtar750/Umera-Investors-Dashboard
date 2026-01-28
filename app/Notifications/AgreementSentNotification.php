<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgreementSentNotification extends Notification
{
    use Queueable;

    public $document;

    /**
     * Create a new notification instance.
     */
    public function __construct($document)
    {
        $this->document = $document;
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
            ->subject('Action Required: Sign Agreement')
            ->line('A new agreement has been sent for your review and signature.')
            ->action('View Documents', route('investor.documents.index'))
            ->line('Please sign and upload the document.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "New agreement sent: {$this->document->title}",
            'document_id' => $this->document->id,
            'url' => route('investor.documents.index'),
        ];
    }
}
