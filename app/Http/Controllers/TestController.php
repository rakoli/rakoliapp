<?php

namespace App\Http\Controllers;

use App\Actions\GenerateDPOPayment;
use App\Actions\RequestEmailVerificationCode;
use App\Mail\SendCodeMail;
use App\Models\User;
use App\Utils\DPOPayment;
use App\Utils\DPORequestTokenFormat;
use App\Utils\Enums\AgentRegistrationStepsEnums;
use App\Utils\SMS;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function testing()
    {

        return view('auth.registration_vas.index');
        //        $step = 1;

        //        $user = User::where('email','jmabusi@gmail.com')->first();

        //        dd(config('dpo-laravel.payment_valid_time_hours'),now()->addHours(config('dpo-laravel.payment_valid_time_hours')));

        // Convert xml string into an object
        /*        $response = '<?xml version="1.0" encoding="utf-8"?><API3G><Result>000</Result><ResultExplanation>Transaction Paid</ResultExplanation><TransactionToken>2F4700BE-20AE-4D60-A478-39A4CCC4B884</TransactionToken><TransactionRef>rwa_21609</TransactionRef><CustomerName>Erick Mabusi</CustomerName><CustomerEmail>emabusi@gmail.com</CustomerEmail><CustomerCredit>8367</CustomerCredit><CustomerCreditType>MASC</CustomerCreditType><TransactionApproval>4444444416</TransactionApproval><TransactionCurrency>TZS</TransactionCurrency><TransactionAmount>500.00</TransactionAmount><FraudAlert>000</FraudAlert><FraudExplnation>Genuine transaction</FraudExplnation><TransactionNetAmount>500.00</TransactionNetAmount><TransactionSettlementDate></TransactionSettlementDate><TransactionRollingReserveAmount>0.00</TransactionRollingReserveAmount><TransactionRollingReserveDate></TransactionRollingReserveDate><CustomerPhone>0763466080</CustomerPhone><CustomerCountry>Tanzania</CustomerCountry><CustomerAddress>Tanzania</CustomerAddress><CustomerCity>Arusha</CustomerCity><CustomerZip></CustomerZip><MobilePaymentRequest>Not sent</MobilePaymentRequest><AccRef></AccRef></API3G>';*/
        //
        //        dd(xmlToArrayConvert($response));

        //        $data = [
        //            'paymentAmount' => "500",
        //            'paymentCurrency' => "TZS",
        //            'customerFirstName' => "Erick",
        //            'customerLastName' => "Boni",
        //            'customerAddress' => "Tanzania",
        //            'customerCity' => "Arusha",
        //            'customerCountryISOCode' => "TZ",
        //            'customerDialCode' => "TZ",
        //            'customerPhone' => "0763466080",
        //            'customerEmail' => "emabusi@gmail.com",
        //            'companyRef' => "rwa_".random_int(10000,100000)
        //        ];
        //
        //        $dpoRequestToken = new DPORequestTokenFormat($data['paymentAmount'],$data['paymentCurrency'],$data['customerFirstName'],
        //            $data['customerLastName'],$data['customerAddress'],$data['customerCity'],$data['customerCountryISOCode'],
        //            $data['customerDialCode'],$data['customerPhone'],$data['customerEmail'],$data['companyRef']);
        //
        //        $url = GenerateDPOPayment::run($dpoRequestToken,'3165');
        //
        //        dd($url);

        //        $dpo = new DPOPayment();
        //        $order = [
        //            'paymentAmount' => "500",
        //            'paymentCurrency' => "TZS",
        //            'customerFirstName' => "Erick",
        //            'customerLastName' => "Boni",
        //            'customerAddress' => "Tanzania",
        //            'customerCity' => "Arusha",
        //            'customerCountryISOCode' => "TZ",
        //            'customerDialCode' => "TZ",
        //            'customerPhone' => "0763466080",
        //            'customerEmail' => "emabusi@gmail.com",
        //            'companyRef' => "rwa_".random_int(10000,100000)
        //        ];
        //
        //        // Now make  payment
        //        $token = $dpo->createToken($order); // return array of response with transaction code
        //
        //        Log::debug($token);
        //
        //        $payment_url = $dpo->getPaymentUrlWithoutVerifyToken($token);
        ////
        //        return redirect($payment_url['result']);

        //        $token = [
        //            'result' => '000',
        //            'resultExplanation' => 'Transaction created',
        //            'success' => 'true',
        //            'transToken' => 'D4307697-8919-4DD6-95E1-3DB80DED12D8',
        //            'transRef' => 'R51614365',
        //        ];
        //
        //        $url = $dpo->getPaymentUrlWithoutVerifyToken($token);
        //
        //        print_r($url['result']);

        //        dd(count(AgentRegistrationStepsEnums::cases()));

        //        SMS::sendToUser($user, 'function to send updated');

        //        dd(RequestEmailVerificationCode::run($user));

        //        Mail::to('emabusi@gmail.com')->send(new SendCodeMail());

        //        return (new SendCodeMail(User::where('email','agent@rakoli.com')->first()))->render();
    }
}
