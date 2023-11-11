<?php

namespace App\Actions;

use App\Mail\SendCodeMail;
use App\Models\User;
use App\Utils\VerifyOTP;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestEmailVerificationCode
{
    use AsAction;

    public function handle(User $user)
    {
        if(VerifyOTP::shouldLockEmailOTP($user)){
            return false;
        }

        Mail::to($user->email)->send(new SendCodeMail($user));

        $user->email_otp = VerifyOTP::generateOTPCode();
        $user->email_otp_time = now();
        $user->email_otp_count = $user->email_otp_count + 1;
        $user->save();


        return true;
    }
}
