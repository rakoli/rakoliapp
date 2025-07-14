<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ReferralPayment;

class PaymentProcessed extends Notification implements ShouldQueue
{
    use Queueable;

    public $referralPayment;

    /**
     * Create a new notification instance.
     */
    public function __construct(ReferralPayment $referralPayment)
    {
        $this->referralPayment = $referralPayment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $amount = number_format($this->referralPayment->amount, 0);
        $method = ucfirst($this->referralPayment->payment_method ?? 'system');

        return (new MailMessage)
                    ->subject('💰 Payment Processed Successfully')
                    ->greeting("Hello {$notifiable->name}!")
                    ->line("Your referral bonus payment has been processed successfully.")
                    ->line("**Amount:** {$amount} TSH")
                    ->line("**Payment Method:** {$method}")
                    ->line("**Transaction Reference:** {$this->referralPayment->transaction_reference}")
                    ->line("**Processing Date:** " . $this->referralPayment->paid_at->format('M d, Y H:i'))
                    ->action('View Payment History', url('/admin/referrals'))
                    ->line('The payment should reflect in your account within the next business day.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_processed',
            'payment_id' => $this->referralPayment->id,
            'amount' => $this->referralPayment->amount,
            'payment_method' => $this->referralPayment->payment_method,
            'transaction_reference' => $this->referralPayment->transaction_reference,
            'message' => "Your payment of {$this->referralPayment->amount} TSH has been processed successfully",
            'processed_at' => $this->referralPayment->paid_at->toISOString(),
        ];
    }
}
