<?php

namespace App\Actions;

use App\Models\InitiatedPayment;
use App\Models\User;
use App\Utils\DPORequestTokenFormat;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class InitiateSubscriptionPayment
{
    use AsAction;

    public function handle($paymentmethod, User $user, $package)
    {
        if(!in_array($paymentmethod, config('dpo-laravel.accepted_payment_methods'))){
            return [
                'success'           => false,
                'result'            => 'payment method',
                'resultExplanation' => 'Unknown payment method',
            ];
        }

        $tnxCode = generateCode($user->id,$package->name);

        if($paymentmethod == 'dpopay'){

            $data = [
                'paymentAmount' => $package->price,
                'paymentCurrency' => $package->price_currency,
                'customerFirstName' => $user->fname,
                'customerLastName' => $user->lname,
                'customerAddress' => $user->country->name,
                'customerCountryISOCode' => $user->country->code,
                'customerDialCode' => $user->country->code,
                'customerPhone' => $user->phone,
                'customerEmail' => $user->email,
                'companyRef' => $tnxCode
            ];

            $dpoRequestToken = new DPORequestTokenFormat($data['paymentAmount'],$data['paymentCurrency'],$data['customerFirstName'],
                $data['customerLastName'],$data['customerAddress'],$data['customerCountryISOCode'],
                $data['customerDialCode'],$data['customerPhone'],$data['customerEmail'],$data['companyRef']);

            $requestResult = GenerateDPOPayment::run($dpoRequestToken,'5291');

            if($requestResult['success'] == false){
                return [
                    'success'           => false,
                    'result'            => 'DPO Error',
                    'resultExplanation' => 'Unable to request payment',
                ];
            }

            try{
                InitiatedPayment::create([
                    "country_code"=>$user->country->code,
                    "business_code"=>$user->business->code,
                    "code"=> $tnxCode,
                    "channel"=> $paymentmethod,
                    "income_category"=> SystemIncomeCategoryEnum::SUBSCRIPTION,
                    "description"=>$package->code,
                    "amount"=>$package->price,
                    "amount_currency"=>$package->price_currency,
                    "expiry_time"=> now()->addHours(config('dpo-laravel.payment_valid_time_hours')),
                    "pay_url"=> $requestResult['result'],
                    "channel_ref_name"=> 'token',
                    "channel_ref"=> $requestResult['transToken'],
                ]);
            }catch (\Exception $exception){
                Log::error($exception);
                Bugsnag::notifyException($exception);
                return [
                    'success'           => false,
                    'result'            => 'Initiate Error',
                    'resultExplanation' => 'Unable to setup payment tracking',
                ];
            }

            return $requestResult;
        }
    }

}
