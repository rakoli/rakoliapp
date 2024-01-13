<?php

namespace App\Actions;

use App\Models\User;
use App\Utils\SMS;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Utils\VerifyOTP;
use Illuminate\Support\Facades\Log;



class SendPasswordEmail
{
    use AsAction;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function handle(User $user)
    {
        $password = VerifyOTP::generateOTPCode();
        $hashedPassword = VerifyOTP::generateHashedPassword($password);
        Mail::to($user->email)->send(new \App\Mail\SendPassword($user, $password));

        $text = config('app.name') . " verification code: ".$password;
        if(env('APP_ENV') == 'production'){
            SMS::sendToUser($user, $text);
        }else{
            Log::debug("SMS: $text");
        }
        $user->update([
            'password' => $hashedPassword,
        ]);
        return true;
    }
}
