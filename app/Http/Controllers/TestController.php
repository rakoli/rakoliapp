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
            'paymentAmount' => "60000",
            'paymentCurrency' => "TZS",
            'customerFirstName' => "Erick",
            'customerLastName' => "Thomas",
            'customerAddress' => "Tanzania",
            'customerCity' => "Arusha",
            'customerCountryISOCode' => "TZ",
            'customerDialCode' => "TZ",
            'customerPhone' => "0752991650",
            'customerEmail' => "novath@gmail.com",
            'companyRef' => "898TESTREFF"
        ];
        // Now make  payment
        $token = $dpo->createToken($order); // return array of response with transaction code

        Log::debug($token);

        $payment_url = "https://secure.3gdirectpay.com/payv2.php?ID=".$token['transToken'];
//
        return redirect($payment_url);
//        dd(count(AgentRegistrationStepsEnums::cases()));

//        SMS::sendToUser($user, 'function to send updated');

//        dd(RequestEmailVerificationCode::run($user));

//        Mail::to('emabusi@gmail.com')->send(new SendCodeMail());


//        return (new SendCodeMail(User::where('email','agent@rakoli.com')->first()))->render();
    }
}
