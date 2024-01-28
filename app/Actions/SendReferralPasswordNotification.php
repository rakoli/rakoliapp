<?php

namespace App\Actions;

use App\Models\User;
use App\Utils\SMS;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Utils\VerifyOTP;
use Illuminate\Support\Facades\Log;


class SendReferralPasswordNotification
{
    use AsAction;

    public function handle(User $user, $password, User $referral)
    {

        Mail::to($user->email)->send(new \App\Mail\SendReferPasswordMail($user, $password));

        $text = $referral->name(). ' has created a '.config('app.name') . " account for you with login details\nemail: $user->email\npassword: ".$password;
        if(env('APP_ENV') == 'production'){
            SMS::sendToUser($user, $text);
        }else{
            Log::debug("SMS: $text");
        }

        return true;
    }
}
