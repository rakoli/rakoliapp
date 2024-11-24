<?php

namespace App\Actions;

use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\User;
use App\Utils\DPORequestTokenFormat;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use App\Utils\Enums\SystemIncomeCategoryEnum;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class InitiateSubscriptionPayment
{
    use AsAction;

    public function handle($paymentmethod, User $user, $package,$isTrial)
    {
        if (! in_array($paymentmethod, config('payments.accepted_payment_methods'))) {

            if (! ($paymentmethod == 'test' && env('APP_ENV') != 'production')) {
                return [
                    'success' => false,
                    'result' => 'payment method',
                    'resultExplanation' => 'Unknown payment method',
                ];
            }
        }

        $tnxCode = generateCode($user->id, $package->name);
        $business = $user->business;
        $description = "$package->code for $business->business_name for $package->package_interval_days days";
        $requestResult = [];
        $redirectUrl = null;
        $reference = null;
        $referenceName = null;

        if ($paymentmethod == 'dpopay' && $package->price > 0 && !$isTrial) {

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
                'companyRef' => $tnxCode,
            ];

            $dpoRequestToken = new DPORequestTokenFormat($data['paymentAmount'], $data['paymentCurrency'], $data['customerFirstName'],
                $data['customerLastName'], $data['customerAddress'], $data['customerCountryISOCode'],
                $data['customerDialCode'], $data['customerPhone'], $data['customerEmail'], $data['companyRef']);

            $requestResult = GenerateDPOPayment::run($dpoRequestToken, '3854');

            if ($requestResult['success'] == false) {
                return [
                    'success' => false,
                    'result' => 'DPO Error',
                    'resultExplanation' => 'Unable to request payment',
                ];
            }

            $requestResult['url'] = $requestResult['result'];

            $redirectUrl = $requestResult['result'];
            $reference = $requestResult['transToken'];
            $referenceName = 'token';
        }

        if ($paymentmethod == 'pesapal' && $package->price > 0 && !$isTrial) {

            $paymentParams = [
                'id' => $tnxCode,
                'currency' => $package->price_currency,
                'amount' => $package->price,
                'description' => $description,
                'callback_url' => route('home'),
                'notification_id' => config('payments.pesapal_ipnid'),
                'billing_address' => [
                    'email_address' => $user->email,
                    'phone_number' => '0'.substr($user->phone, 3),
                    'country_code' => $user->country->code,
                    'first_name' => $user->fname,
                    'middle_name' => '',
                    'last_name' => $user->lname,
                    'line_1' => '',
                    'line_2' => '',
                    'city' => '',
                    'state' => '',
                    'postal_code' => '00'.substr($user->country->dialing_code, 1),
                    'zip_code' => '00'.substr($user->country->dialing_code, 1),
                ],
            ];

            $requestResult = GeneratePesapalPayment::run($paymentParams);

            if ($requestResult['success'] == false) {
                return [
                    'success' => false,
                    'result' => 'Pesapal Error',
                    'resultExplanation' => 'Unable to request payment',
                ];
            }

            $apiResponse = $requestResult['result'];
            $requestResult['url'] = $apiResponse->redirect_url;

            $redirectUrl = $apiResponse->redirect_url;
            $reference = $apiResponse->order_tracking_id;
            $referenceName = 'tracking_id';
        }

        if ($paymentmethod == 'selcom' && $package->price > 0 && !$isTrial) {

            $paymentParams = [
                "vendor" => config('payments.selcom_vendor'),
                "order_id" => $tnxCode,
                "buyer_email" => $user->email,
                "buyer_name" => $user->name(),
                "buyer_phone" => $user->phone,
                "amount" => $package->price,
                "currency" => strtoupper($package->price_currency),
                "redirect_url" => base64_encode(route('home')),
                "cancel_url" => base64_encode(route('home')),
                "webhook" => base64_encode(route('selcom.callback')),
                "buyer_remarks" => "None",
                "merchant_remarks" => "None",
                "no_of_items" => 1
            ];

            $requestResult = GenerateSelcomPayment::run($paymentParams);

            if ($requestResult['success'] == false || $requestResult['result']['resultcode'] != 0) {
                return [
                    'success' => false,
                    'result' => 'Selcom Error',
                    'resultExplanation' => 'Unable to request payment.'.$requestResult['result']['message'] ,
                ];
            }

            $apiResponse = $requestResult['result']['data'][0];
            $requestResult['url'] = base64_decode($apiResponse['payment_gateway_url']);

            $redirectUrl = base64_decode($apiResponse['payment_gateway_url']);
            $reference = $paymentParams['order_id'];
            $referenceName = 'order_id';
        }

        if ($paymentmethod == 'test' && env('APP_ENV') != 'production' && !$isTrial) {
            $reference = 'test_'.\Illuminate\Support\Str::random(4);
            $redirectUrl = route('pay.test', $reference);
            $referenceName = 'test_reference';
            $requestResult['url'] = $redirectUrl;
            $requestResult['success'] = true;
        }

        if($package->price == 0 && !$isTrial){
            $reference = $package->name.'_'.\Illuminate\Support\Str::random(8);
            $redirectUrl = route('pay.trial', $reference);
            $referenceName = 'trial_reference';

            $requestResult['url'] = $redirectUrl;
            $requestResult['success'] = true;
        }

        if($isTrial){
            $package->price = 0;
            $package->package_interval_days = 90;
            $reference = $package->name.'_'.\Illuminate\Support\Str::random(8);
            $redirectUrl = route('pay.trial', $reference);
            $referenceName = 'trial';

            $requestResult['url'] = $redirectUrl;
            $requestResult['success'] = true;
        }

        if ($reference != null) {

            $recordResult = self::recordPayment($user, $package, $tnxCode, $paymentmethod, $redirectUrl, $reference, $referenceName);

            if ($recordResult['success'] == false) {
                return [
                    'success' => false,
                    'result' => 'Recording Request Error',
                    'resultExplanation' => 'Unable to record the payment request',
                ];
            }

            $similarPendingPayments = InitiatedPayment::where('business_code', $user->business_code)
                ->where('expiry_time', '>', now())
                ->where('description', $package->code)
                ->where('status', InitiatedPaymentStatusEnum::INITIATED->value)->get();

            if (! $similarPendingPayments->isEmpty()) {
                foreach ($similarPendingPayments as $similarPendingPayment) {
                    if($similarPendingPayment->code == $recordResult['payment_code']){
                        continue;
                    }
                    $similarPendingPayment->expiry_time = now();
                    $similarPendingPayment->status = InitiatedPaymentStatusEnum::CANCELLED->value;
                    $similarPendingPayment->save();
                }
            }

        }

        return $requestResult;
    }

    public static function recordPayment(User $user, Package $package, $tnxCode, $paymentmethod, $url, $reference, $referenceName)
    {
        try {
            $initiatedPayment = InitiatedPayment::create([
                'country_code' => $user->country->code,
                'business_code' => $user->business->code,
                'code' => $tnxCode,
                'channel' => $paymentmethod,
                'income_category' => $package->package_interval_days == 90 ? SystemIncomeCategoryEnum::TRIAL : SystemIncomeCategoryEnum::SUBSCRIPTION,
                'description' => $package->code,
                'amount' => $package->price,
                'amount_currency' => $package->price_currency,
                'expiry_time' => now()->addHours(config('payments.payment_valid_time_hours')),
                'pay_url' => $url,
                'channel_ref_name' => $referenceName,
                'channel_ref' => $reference,
            ]);
        } catch (\Exception $exception) {
            Log::error($exception);
            Bugsnag::notifyException($exception);

            return [
                'success' => false,
                'result' => 'Initiate Error',
                'resultExplanation' => 'Unable to setup payment tracking',
                'payment_code'=> null
            ];
        }

        return [
            'success' => true,
            'result' => 'successful',
            'resultExplanation' => 'Recorded transaction successfully',
            'payment_code'=>$initiatedPayment->code
        ];
    }
}
