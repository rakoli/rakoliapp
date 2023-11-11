<?php

namespace App\Actions;

use App\Mail\SendCodeMail;
use App\Models\User;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestPhoneVerificationCode
{
    use AsAction;

    public function handle(User $user)
    {
        if(VerifyOTP::shouldLockPhoneOTP($user)){
            return false;
        }

        $otp = VerifyOTP::generateOTPCode();
        $minutes = (VerifyOTP::$validtime/60);
        $text = config('app.name') . " verification code: ".$otp ."\nValid for ".$minutes." min." ;
//        SMS::sendToUser($user, $text);

        Log::debug("SMS: $text");

        $user->phone_otp = $otp;
        $user->phone_otp_time = now();
        $user->phone_otp_count = $user->phone_otp_count + 1;
        $user->save();

        return true;
    }
}
