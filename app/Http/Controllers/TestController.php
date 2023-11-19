<?php

namespace App\Http\Controllers;

use App\Actions\GenerateDPOPayment;
use App\Actions\RequestEmailVerificationCode;
use App\Actions\SendTelegramNotification;
use App\Mail\SendCodeMail;
use App\Models\SystemIncome;
use App\Models\User;
use App\Utils\DPOPayment;
use App\Utils\DPORequestTokenFormat;
use App\Utils\Enums\AgentRegistrationStepsEnums;
use App\Utils\PesaPalPayment;
use App\Utils\TelegramCommunication;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class TestController extends Controller
{
    public function testing()
    {
        $pesapal = new PesaPalPayment();

//        $paymentParams = [
//            "id" => random_int(1,999),
//            "currency" => 'TZS',
//            "amount" => 10000,
//            "description" => 'tunajaribu kulipa',
//            "callback_url" => 'https://app.rakoli.com/registration/agent',
//            "notification_id" => 'a979ec29-2ff0-42c6-a02d-ddeee8cdcf04',
//            "billing_address" => [
//                "email_address" => 'emabusi@gmail.com',
//                "phone_number" => '0763466080',
//                "country_code" => "TZ",
//                "first_name" => 'Erick',
//                "middle_name" => "",
//                "last_name" =>  'Boni',
//                "line_1" => "",
//                "line_2" => "",
//                "city" => "",
//                "state" => "",
//                "postal_code" => "00255",
//                "zip_code" => "00255"
//            ]
//        ];
//        $trackingId = 'f0c192b7-a937-4132-926f-ddee5fb4681c';

        $result = $pesapal->IPNList()['result'];

        foreach ($result as $ipn) {
//            print_r($ipn['url']);
            if($ipn->url == 'https://app.rakoli.com/api/pesapal/callback'){
                print_r($ipn);
            }
        }

//        dd($result);
//        print_r($pesapal->transactionStatus($trackingId));
    }
}
