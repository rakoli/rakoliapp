<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\ReferralPayment;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProcessReferralBonusesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting automated referral bonus processing...');

        $this->processRegistrationBonuses();
        $this->processTransactionBonuses();

        Log::info('Completed automated referral bonus processing.');
    }

    /**
     * Process registration bonuses for newly registered businesses
     */
    private function processRegistrationBonuses(): void
    {
        // Find users with businesses that have packages but no registration bonus payment yet
        $eligibleReferrals = User::whereNotNull('referral_business_code')
            ->whereHas('business', function($query) {
                $query->whereNotNull('package_code');
            })
            ->whereDoesntHave('referralPaymentsReceived', function($query) {
                $query->where('payment_type', 'registration_bonus');
            })
            ->get();

        foreach ($eligibleReferrals as $referral) {
            $salesUser = User::where('business_code', $referral->referral_business_code)->first();

            if ($salesUser) {
                try {
                    ReferralPayment::createRegistrationBonus($salesUser->id, $referral->id);
                    Log::info("Created registration bonus for sales user {$salesUser->id}, referral {$referral->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to create registration bonus: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Process transaction bonuses for users who meet the criteria
     */
    private function processTransactionBonuses(): void
    {
        // Find referrals within the 2-week bonus window
        $twoWeeksAgo = Carbon::now()->subWeeks(2);

        $activeReferrals = User::whereNotNull('referral_business_code')
            ->whereHas('business')
            ->where('created_at', '>=', $twoWeeksAgo)
            ->get();

        foreach ($activeReferrals as $referral) {
            $salesUser = User::where('business_code', $referral->referral_business_code)->first();

            if (!$salesUser || !$referral->business) {
                continue;
            }

            $this->processWeeklyTransactionBonus($salesUser, $referral, 1);
            $this->processWeeklyTransactionBonus($salesUser, $referral, 2);
        }
    }

    /**
     * Process transaction bonus for a specific week
     */
    private function processWeeklyTransactionBonus(User $salesUser, User $referral, int $week): void
    {
        $referralDate = $referral->created_at;
        $weekStart = $week === 1 ? $referralDate : $referralDate->copy()->addWeek();
        $weekEnd = $weekStart->copy()->addWeek();

        // Check if we're past this week
        if (Carbon::now()->lt($weekEnd)) {
            return; // Week hasn't completed yet
        }

        $paymentType = $week === 1 ? 'transaction_bonus_week1' : 'transaction_bonus_week2';

        // Check if payment already exists
        $existingPayment = ReferralPayment::where('user_id', $salesUser->id)
            ->where('referral_id', $referral->id)
            ->where('payment_type', $paymentType)
            ->exists();

        if ($existingPayment) {
            return; // Payment already processed
        }

        // Count transactions for this week
        $transactionCount = Transaction::where('business_code', $referral->business->code)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count();

        // Create payment if threshold is met
        if ($transactionCount >= 10) {
            try {
                ReferralPayment::createTransactionBonus($salesUser->id, $referral->id, $week);
                Log::info("Created transaction bonus week {$week} for sales user {$salesUser->id}, referral {$referral->id}. Transactions: {$transactionCount}");
            } catch (\Exception $e) {
                Log::error("Failed to create transaction bonus: " . $e->getMessage());
            }
        }
    }
}
