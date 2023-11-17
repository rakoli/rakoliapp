<?php

namespace App\Actions;

use App\Models\InitiatedPayment;
use App\Models\User;
use App\Utils\DPOPayment;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckUserPendingSystemPayments
{
    use AsAction;

    public function handle(User $user, $initiatedPayments = null)
    {
        if($initiatedPayments == null){
            $initiatedPayments = $user->getBusinessPendingPayments();
        }

        foreach ($initiatedPayments as $initiatedPayment) {
            if($initiatedPayment->channel == 'dpopay'){
                $dpo = new DPOPayment();
                $completionStatus = $dpo->isPaymentComplete($initiatedPayment->channel_ref);
                if($completionStatus['success']){
                    CompleteInitiatedPayment::run($initiatedPayment);
                }

            }
        }
    }
}
