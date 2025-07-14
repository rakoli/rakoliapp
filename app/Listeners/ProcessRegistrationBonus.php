<?php

namespace App\Listeners;

use App\Events\BusinessRegistrationCompleted;
use App\Models\ReferralPayment;
use App\Models\User;
use App\Notifications\ReferralBonusEarned;
use Illuminate\Support\Facades\Log;

class ProcessRegistrationBonus
{
    /**
     * Handle the event.
     */
    public function handle(BusinessRegistrationCompleted $event): void
    {
        $user = $event->user;

        // Check if this user was referred
        if (!$user->referral_business_code) {
            return;
        }

        // Find the sales user who made the referral
        $salesUser = User::where('business_code', $user->referral_business_code)->first();

        if (!$salesUser) {
            Log::warning("Sales user not found for referral business code: {$user->referral_business_code}");
            return;
        }

        // Check if business has a package (completed registration)
        if (!$user->business || !$user->business->package_code) {
            return;
        }

        // Create registration bonus payment record
        try {
            $payment = $salesUser->createRegistrationBonusPayment($user->id);

            if ($payment) {
                Log::info("Automatically created registration bonus for sales user {$salesUser->id}, referral {$user->id}");

                // Send notification to sales user
                $salesUser->notify(new ReferralBonusEarned($payment));
            }
        } catch (\Exception $e) {
            Log::error("Failed to create automatic registration bonus: " . $e->getMessage());
        }
    }

    /**
     * Send notification to sales user about new bonus
     */
    private function notifySalesUser(User $salesUser, ReferralPayment $payment): void
    {
        // TODO: Implement notification logic
        // This could be email, SMS, or in-app notification
    }
}
