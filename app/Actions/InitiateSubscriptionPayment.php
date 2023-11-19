<?php

namespace App\Actions;

use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\User;
use App\Utils\DPORequestTokenFormat;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use App\Utils\PesaPalPayment;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class InitiateSubscriptionPayment
{
    use AsAction;

    public function handle($paymentmethod, User $user, $package)
    {
        if(!in_array($paymentmethod, config('payments.accepted_payment_methods'))){
            return [
                'success'           => false,
                'result'            => 'payment method',
                'resultExplanation' => 'Unknown payment method',
            ];
        }

        $tnxCode = generateCode($user->id,$package->name);
        $business = $user->business;
        $description = "$package->code for $business->business_name for $package->package_interval_days days";
        $requestResult = [];

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

            $requestResult = GenerateDPOPayment::run($dpoRequestToken,'3854');

            if($requestResult['success'] == false){
                return [
                    'success'           => false,
                    'result'            => 'DPO Error',
                    'resultExplanation' => 'Unable to request payment',
                ];
            }

            $saveRecordResult = self::recordPayment($user,$package,$tnxCode,$paymentmethod,$requestResult['result'],$requestResult['transToken'],'token');

            if($saveRecordResult['success'] == false){
                return [
                    'success'           => false,
                    'result'            => 'Recording Request Error',
                    'resultExplanation' => 'Unable to record the payment request',
                ];
            }

            $requestResult['url'] = $requestResult['result'];
        }



        if($paymentmethod == 'pesapal'){

            $paymentParams = [
                "id" => $tnxCode,
                "currency" => $package->price_currency,
                "amount" => $package->price,
                "description" => $description,
                "callback_url" => route('home'),
                "notification_id" => config('payments.pesapal_ipnid'),
                "billing_address" => [
                    "email_address" => $user->email,
                    "phone_number" => "0".substr($user->phone, 3),
                    "country_code" => $user->country->code,
                    "first_name" => $user->fname,
                    "middle_name" => "",
                    "last_name" =>  $user->lname,
                    "line_1" => "",
                    "line_2" => "",
                    "city" => "",
                    "state" => "",
                    "postal_code" => "00".substr($user->country->dialing_code, 1),
                    "zip_code" => "00".substr($user->country->dialing_code, 1)
                ]
            ];

            $requestResult = GeneratePesapalPayment::run($paymentParams);

            if($requestResult['success'] == false){
                return [
                    'success'           => false,
                    'result'            => 'Pesapal Error',
                    'resultExplanation' => 'Unable to request payment',
                ];
            }

            $apiResponse = $requestResult['result'];

            $recordResult = self::recordPayment($user,$package,$tnxCode,$paymentmethod,$apiResponse->redirect_url,$apiResponse->order_tracking_id,'tracking_id');

            if($recordResult['success'] == false){
                return [
                    'success'           => false,
                    'result'            => 'Recording Request Error',
                    'resultExplanation' => 'Unable to record the payment request',
                ];
            }

            $requestResult['url'] = $apiResponse->redirect_url;
        }


        return $requestResult;
    }

    public static function recordPayment(User $user, Package $package,$tnxCode,$paymentmethod, $url,$reference,$referenceName)
    {
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
                "expiry_time"=> now()->addHours(config('payments.payment_valid_time_hours')),
                "pay_url"=> $url,
                "channel_ref_name"=> $referenceName,
                "channel_ref"=> $reference,
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

        return [
            'success'           => true,
            'result'            => 'successful',
            'resultExplanation' => 'Recorded transaction successfully',
        ];
    }

}
