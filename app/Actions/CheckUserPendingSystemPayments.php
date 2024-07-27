<?php

namespace App\Actions;

use App\Models\User;
use App\Utils\DPOPayment;
use App\Utils\PesaPalPayment;
use App\Utils\SelcomPayment;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckUserPendingSystemPayments
{
    use AsAction;

    public function handle(User $user, $initiatedPayments = null)
    {
        if ($initiatedPayments == null) {
            $initiatedPayments = $user->getBusinessPendingPayments();
        }

        foreach ($initiatedPayments as $initiatedPayment) {
            if ($initiatedPayment->channel == 'dpopay') {
                $dpo = new DPOPayment();
                $completionStatus = $dpo->isPaymentComplete($initiatedPayment->channel_ref);
                if ($completionStatus['success']) {
                    CompleteInitiatedPayment::run($initiatedPayment);
                }
            }
            if ($initiatedPayment->channel == 'pesapal') {
                $pesapal = new PesaPalPayment();
                $completionStatus = $pesapal->isPaymentComplete($initiatedPayment->channel_ref);
                if ($completionStatus['success']) {
                    CompleteInitiatedPayment::run($initiatedPayment);
                }
            }
            if ($initiatedPayment->channel == 'selcom') {
                $selcom = new SelcomPayment();
                $completionStatus = $selcom->isPaymentComplete($initiatedPayment->channel_ref);
                if ($completionStatus['success']) {
                    CompleteInitiatedPayment::run($initiatedPayment);
                }
            }
        }
    }
}
