<?php

namespace App\Http\Controllers;

use App\Actions\RequestEmailVerificationCode;
use App\Mail\SendCodeMail;
use App\Models\SystemIncome;
use App\Models\User;
use App\Utils\DPOPayment;
use App\Utils\Enums\AgentRegistrationStepsEnums;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Zepson\Dpo\Dpo;

class TestController extends Controller
{
    public function testing()
    {
//        $step = 1;

//        $user = User::where('email','jmabusi@gmail.com')->first();


        $dpo = new DPOPayment();
        $order = [
            'paymentAmount' => "500",
            'paymentCurrency' => "TZS",
            'customerFirstName' => "Erick",
            'customerLastName' => "Boni",
            'customerAddress' => "Tanzania",
            'customerCity' => "Arusha",
            'customerCountryISOCode' => "TZ",
            'customerDialCode' => "TZ",
            'customerPhone' => "0763466080",
            'customerEmail' => "emabusi@gmail.com",
            'companyRef' => "rwa_".random_int(10000,100000)
        ];

        // Now make  payment
        $token = $dpo->createToken($order); // return array of response with transaction code

        Log::debug($token);

        $payment_url = $dpo->getPaymentUrlWithoutVerifyToken($token);
//
        return redirect($payment_url['result']);


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
