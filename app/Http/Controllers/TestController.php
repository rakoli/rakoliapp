<?php

namespace App\Http\Controllers;

use App\Actions\RequestEmailVerificationCode;
use App\Mail\SendCodeMail;
use App\Models\SystemIncome;
use App\Models\User;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class TestController extends Controller
{
    public function testing()
    {
        $step = 1;

        $user = User::where('email','emabusi@gmail.com')->first();

//        SMS::sendToUser($user, 'function to send updated');

        dd(VerifyOTP::emailOTPTimeLeft($user), Carbon::create($user->email_otp_time)->diffInRealSeconds(now()));

//        dd(RequestEmailVerificationCode::run($user));

//        Mail::to('emabusi@gmail.com')->send(new SendCodeMail());


//        return (new SendCodeMail(User::where('email','agent@rakoli.com')->first()))->render();
    }
}
