<?php

namespace App\Actions;

use App\Mail\SendCodeMail;
use App\Models\User;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
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

        $user->phone_otp = VerifyOTP::generateOTPCode();
        $user->phone_otp_time = now();
        $user->phone_otp_count = $user->phone_otp_count + 1;
        $user->save();

        $minutes = (VerifyOTP::$validtime/60);
        $text = config('app.name') . " verification code: ".$user->phone_otp ."\nValid for ".$minutes." min." ;
        SMS::sendToUser($user, $text);

        return true;
    }
}
