<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInvestmentNotification extends Notification
{
    use Queueable;

    public $allocation;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($allocation, $user)
    {
        $this->allocation = $allocation;
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
        $url = $notifiable->role === 'admin' 
            ? route('admin.allocations.index') 
            : route('legal.dashboard');

        return (new MailMessage)
            ->subject('New Investment Received')
            ->line('New investment of ₦'.number_format($this->allocation->amount)." received from {$this->user->name}.")
            ->action('View Dashboard', $url)
            ->line('Please review the investment.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $url = $notifiable->role === 'admin' 
            ? route('admin.allocations.index') 
            : route('legal.dashboard');

        return [
            'message' => 'New investment of ₦'.number_format($this->allocation->amount)." by {$this->user->name}",
            'allocation_id' => $this->allocation->id,
            'user_id' => $this->user->id,
            'url' => $url,
        ];
    }
}
