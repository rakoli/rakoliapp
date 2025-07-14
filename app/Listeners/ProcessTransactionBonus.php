<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Models\ReferralPayment;
use App\Models\User;
use App\Models\Transaction;
use App\Notifications\ReferralBonusEarned;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessTransactionBonus
{
    /**
     * Handle the event.
     */
    public function handle(TransactionCreated $event): void
    {
        $transaction = $event->transaction;

        // Find the business owner for this transaction
        $businessOwner = User::where('business_code', $transaction->business_code)->first();

        if (!$businessOwner || !$businessOwner->referral_business_code) {
            return; // Not a referred business
        }

        // Find the sales user who made the referral
        $salesUser = User::where('business_code', $businessOwner->referral_business_code)->first();

        if (!$salesUser) {
            return;
        }

        // Check if we're within the 2-week bonus window
        $referralDate = $businessOwner->created_at;
        $twoWeeksAfter = $referralDate->copy()->addWeeks(2);

        if (Carbon::now()->gt($twoWeeksAfter)) {
            return; // Outside bonus window
        }

        // Check for week 1 bonus (first week after referral)
        $this->checkWeeklyBonus($salesUser, $businessOwner, $transaction, 1);

        // Check for week 2 bonus (second week after referral)
        $this->checkWeeklyBonus($salesUser, $businessOwner, $transaction, 2);
    }

    /**
     * Check if weekly transaction bonus should be awarded
     */
    private function checkWeeklyBonus(User $salesUser, User $businessOwner, Transaction $transaction, int $week): void
    {
        $referralDate = $businessOwner->created_at;
        $weekStart = $week === 1 ? $referralDate : $referralDate->copy()->addWeek();
        $weekEnd = $weekStart->copy()->addWeek();

        // Check if transaction is in this week
        if (!$transaction->created_at->between($weekStart, $weekEnd)) {
            return;
        }

        $paymentType = $week === 1 ? 'transaction_bonus_week1' : 'transaction_bonus_week2';

        // Check if bonus already awarded for this week
        $existingPayment = ReferralPayment::where('user_id', $salesUser->id)
            ->where('referral_id', $businessOwner->id)
            ->where('payment_type', $paymentType)
            ->exists();

        if ($existingPayment) {
            return; // Already awarded
        }

        // Count transactions in this week
        $transactionCount = Transaction::where('business_code', $transaction->business_code)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count();

        // Award bonus if threshold is met
        if ($transactionCount >= 10) {
            try {
                $payment = $salesUser->createTransactionBonusPayment($businessOwner->id, $week);

                if ($payment) {
                    Log::info("Automatically created transaction bonus week {$week} for sales user {$salesUser->id}, referral {$businessOwner->id}. Transaction count: {$transactionCount}");

                    // Send notification to sales user
                    $salesUser->notify(new ReferralBonusEarned($payment));
                }
            } catch (\Exception $e) {
                Log::error("Failed to create automatic transaction bonus: " . $e->getMessage());
            }
        }
    }

    /**
     * Send notification to sales user about new transaction bonus
     */
    private function notifySalesUser(User $salesUser, ReferralPayment $payment, int $week, int $transactionCount): void
    {
        // TODO: Implement notification logic
        // This could be email, SMS, or in-app notification
    }
}
