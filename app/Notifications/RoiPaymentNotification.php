<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoiPaymentNotification extends Notification
{
    use Queueable;

    public $transaction;
    public $offeringName;

    /**
     * Create a new notification instance.
     */
    public function __construct($transaction, $offeringName)
    {
        $this->transaction = $transaction;
        $this->offeringName = $offeringName;
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
                    ->subject('ROI Payment Received')
                    ->line('You have received an ROI payment of ₦' . number_format($this->transaction->amount, 2) . ' for ' . $this->offeringName . '.')
                    ->action('View Wallet', route('investor.wallet.index'))
                    ->line('Thank you for investing with Umera!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'ROI Payment of ₦' . number_format($this->transaction->amount, 2) . ' received for ' . $this->offeringName . '.',
            'transaction_id' => $this->transaction->id,
            'amount' => $this->transaction->amount,
            'url' => route('investor.wallet.index'),
        ];
    }
}
