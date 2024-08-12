<?php

namespace App\Actions;

use App\Models\Business;
use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\SystemIncome;
use App\Models\User;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use App\Utils\Enums\SystemIncomeStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
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

                if($userToComplete->referral_business_code != null && $initiatedPayment->amount > 0){
                    $uplineBusiness = Business::where('code',$userToComplete->referral_business_code)->first();
                    $description = $userToComplete->name()." referral commission";
                    $uplineBusiness->addBusinessAccountTransaction(TransactionTypeEnum::MONEY_IN->value,TransactionCategoryEnum::INCOME->value,$package->price_commission,$description);
                }
            }

            $description = "$initiatedPayment->description for $business->business_name $package->package_interval_days days";
        }
        //END:: COMPLETE SUBSCRIPTION PAYMENT

        if($initiatedPayment->amount > 0){
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
        }

        $initiatedPayment->expiry_time = now();
        $initiatedPayment->status = InitiatedPaymentStatusEnum::COMPLETED->value;
        $initiatedPayment->save();
    }
}
