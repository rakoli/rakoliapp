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

        $minutes = (VerifyOTP::$validtime/60);
        $text = config('app.name') . " verification code: ".$user->getPhoneOTP() ."\nValid for ".$minutes." min." ;
        SMS::sendToUser($user, $text);

        Log::debug("SMS: $text");

        $user->phone_otp = VerifyOTP::generateOTPCode();
        $user->phone_otp_time = now();
        $user->phone_otp_count = $user->phone_otp_count + 1;
        $user->save();

        return true;
    }
}
