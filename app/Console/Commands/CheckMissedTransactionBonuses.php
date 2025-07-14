<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ReferralPayment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckMissedTransactionBonuses extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'referrals:check-missed-transaction-bonuses';

    /**
     * The console command description.
     */
    protected $description = 'Check for missed transaction bonuses and create payment records for qualifying referrals';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for missed transaction bonuses...');

        $missedBonuses = 0;

        // Get all sales users with referrals in the last 3 weeks
        $cutoffDate = Carbon::now()->subWeeks(3);

        $salesUsersWithReferrals = User::whereHas('referrals', function ($query) use ($cutoffDate) {
            $query->where('created_at', '>=', $cutoffDate);
        })->with(['referrals' => function ($query) use ($cutoffDate) {
            $query->where('created_at', '>=', $cutoffDate);
        }])->get();

        foreach ($salesUsersWithReferrals as $salesUser) {
            foreach ($salesUser->referrals as $referredUser) {
                $missedBonuses += $this->checkMissedBonusesForReferral($salesUser, $referredUser);
            }
        }

        $this->info("Created {$missedBonuses} missed transaction bonus payments.");

        return 0;
    }

    /**
     * Check for missed bonuses for a specific referral
     */
    private function checkMissedBonusesForReferral(User $salesUser, User $referredUser): int
    {
        $bonusesCreated = 0;
        $referralDate = $referredUser->created_at;
        $twoWeeksAfter = $referralDate->copy()->addWeeks(2);

        // Skip if we're outside the 2-week bonus window
        if (Carbon::now()->lt($referralDate) || Carbon::now()->gt($twoWeeksAfter)) {
            return 0;
        }

        // Check week 1 (first week after referral)
        $bonusesCreated += $this->checkWeeklyBonusMissed($salesUser, $referredUser, 1);

        // Check week 2 (second week after referral) only if we're past week 1
        if (Carbon::now()->gt($referralDate->copy()->addWeek())) {
            $bonusesCreated += $this->checkWeeklyBonusMissed($salesUser, $referredUser, 2);
        }

        return $bonusesCreated;
    }

    /**
     * Check if a weekly bonus was missed and create it if qualified
     */
    private function checkWeeklyBonusMissed(User $salesUser, User $referredUser, int $week): int
    {
        $referralDate = $referredUser->created_at;
        $weekStart = $week === 1 ? $referralDate : $referralDate->copy()->addWeek();
        $weekEnd = $weekStart->copy()->addWeek();

        $paymentType = $week === 1 ? 'transaction_bonus_week1' : 'transaction_bonus_week2';

        // Check if bonus already exists
        $existingPayment = ReferralPayment::where('user_id', $salesUser->id)
            ->where('referral_id', $referredUser->id)
            ->where('payment_type', $paymentType)
            ->exists();

        if ($existingPayment) {
            return 0; // Already exists
        }

        // Skip if we haven't completed this week yet
        if (Carbon::now()->lt($weekEnd)) {
            return 0;
        }

        // Count transactions in this week for the referred business
        $transactionCount = Transaction::where('business_code', $referredUser->business_code)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count();

        // Create bonus if threshold is met
        if ($transactionCount >= 10) {
            try {
                $payment = $salesUser->createTransactionBonusPayment($referredUser->id, $week);

                if ($payment) {
                    $this->line("✓ Created missed transaction bonus week {$week} for sales user {$salesUser->name} (ID: {$salesUser->id}), referral {$referredUser->name} (ID: {$referredUser->id}). Transaction count: {$transactionCount}");

                    Log::info("Created missed transaction bonus week {$week} for sales user {$salesUser->id}, referral {$referredUser->id}. Transaction count: {$transactionCount}");

                    return 1;
                }
            } catch (\Exception $e) {
                $this->error("Failed to create missed transaction bonus: " . $e->getMessage());
                Log::error("Failed to create missed transaction bonus: " . $e->getMessage());
            }
        }

        return 0;
    }
}
