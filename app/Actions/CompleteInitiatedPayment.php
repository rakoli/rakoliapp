<?php

namespace App\Actions;

use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\SystemIncome;
use App\Models\User;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use App\Utils\Enums\SystemIncomeStatusEnum;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class CompleteInitiatedPayment
{
    use AsAction;

    public function handle(InitiatedPayment $initiatedPayment)
    {
        $business = $initiatedPayment->business;
        $description = "complete";

        //COMPLETE SUBSCRIPTION PAYMENT
        if($initiatedPayment->income_category == SystemIncomeCategoryEnum::SUBSCRIPTION->value){

            $package = Package::where('code',$initiatedPayment->description)->first();
            $business->package_code = $package->code;
            $business->package_expiry_at = now()->addDays($package->package_interval_days);
            $business->save();

            $userToComplete = User::where('business_code',$business->code)->where('registration_step','>',0)->first();
            if($userToComplete != null){
                $userToComplete->registration_step = $userToComplete->registration_step + 1;
                $userToComplete->save();
            }

            $description = "$initiatedPayment->description for $business->business_name $package->package_interval_days days";
        }
        //END:: COMPLETE SUBSCRIPTION PAYMENT

        SystemIncome::create([
            'country_code' => $initiatedPayment->country_code,
            'category' => $initiatedPayment->income_category,
            'amount' => $initiatedPayment->amount,
            'amount_currency' => $initiatedPayment->amount_currency,
            'channel' => $initiatedPayment->channel,
            'channel_reference' => $initiatedPayment->code,
            'channel_timestamp' => now(),
            'description' => $description,
            'status' => SystemIncomeStatusEnum::RECEIVED->value,
        ]);

        $initiatedPayment->expiry_time = now();
        $initiatedPayment->status = InitiatedPaymentStatusEnum::COMPLETED;
        $initiatedPayment->save();
    }
}
