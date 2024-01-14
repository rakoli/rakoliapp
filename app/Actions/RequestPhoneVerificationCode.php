<?php

namespace App\Actions;

use App\Models\User;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestPhoneVerificationCode
{
    use AsAction;

    public function handle(User $user)
    {
        if (VerifyOTP::shouldLockPhoneOTP($user)) {
            return false;
        }

        $otp = VerifyOTP::generateOTPCode();
        $minutes = (VerifyOTP::$validtime / 60);
        $text = config('app.name').' verification code: '.$otp."\nValid for ".$minutes.' min.';

        if (env('APP_ENV') != 'local') {
            SMS::sendToUser($user, $text);
        } else {
            Log::debug("SMS: $text");
        }

        $user->phone_otp = $otp;
        $user->phone_otp_time = now();
        $user->phone_otp_count = $user->phone_otp_count + 1;
        $user->save();

        return true;
    }
}
