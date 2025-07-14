<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ReferralPayment;

class ReferralBonusEarned extends Notification implements ShouldQueue
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
        $bonusType = $this->getBonusTypeDescription();
        $amount = number_format($this->referralPayment->amount, 0);

        return (new MailMessage)
                    ->subject('🎉 New Referral Bonus Earned!')
                    ->greeting("Hello {$notifiable->name}!")
                    ->line("Great news! You've earned a new referral bonus.")
                    ->line("**Bonus Type:** {$bonusType}")
                    ->line("**Amount:** {$amount} TSH")
                    ->line("**Date:** " . $this->referralPayment->created_at->format('M d, Y'))
                    ->action('View Payment Details', url('/admin/referrals'))
                    ->line('Thank you for being part of our sales team!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'referral_bonus_earned',
            'payment_id' => $this->referralPayment->id,
            'payment_type' => $this->referralPayment->payment_type,
            'amount' => $this->referralPayment->amount,
            'message' => "You've earned a new {$this->getBonusTypeDescription()} worth {$this->referralPayment->amount} TSH",
            'created_at' => $this->referralPayment->created_at->toISOString(),
        ];
    }

    /**
     * Get human-readable bonus type description
     */
    private function getBonusTypeDescription(): string
    {
        return match($this->referralPayment->payment_type) {
            'registration_bonus' => 'Registration Bonus',
            'transaction_bonus_week1' => 'Transaction Bonus (Week 1)',
            'transaction_bonus_week2' => 'Transaction Bonus (Week 2)',
            default => 'Referral Bonus'
        };
    }
}
