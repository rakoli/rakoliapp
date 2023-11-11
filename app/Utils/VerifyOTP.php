<?php

namespace App\Utils;

use App\Models\User;
use Carbon\Carbon;
use function Laravel\Prompts\select;

class VerifyOTP
{

//    public int $validtime = 300; //seconds
    public static int $validtime = 600; //seconds
    public static int $shouldLockCount = 10; //no of trials

    public static function generateOTPCode(){
        return random_int(100000, 999999);
    }

    public static function emailOTPTimePassed(User $user)
    {
        return now()->diffInSeconds($user->email_otp_time);
    }

    public static function phoneOTPTimePassed(User $user)
    {
        return now()->diffInSeconds($user->phone_otp_time);
    }

    public static function emailOTPTimeRemaining(User $user)
    {
        return Carbon::create($user->email_otp_time )->addSeconds(self::$validtime)->diffInSeconds(now());
    }

    public static function phoneOTPTimeRemaining(User $user)
    {
        return Carbon::create($user->phone_otp_time )->addSeconds(self::$validtime)->diffInSeconds(now());
    }

    public static function isEmailOTPValid($userInput, User $user) : bool
    {
        $validity = false;
        if(self::hasActiveEmailOTP($user) && $userInput == $user->getEmailOTPCode()){
            return true;
        }
        return $validity;
    }

    public static function isPhoneOTPValid($userInput, User $user) : bool
    {
        $validity = false;
        if(self::hasActivePhoneOTP($user) && $userInput == $user->getPhoneOTPCode()){
            return true;
        }
        return $validity;
    }

    public static function hasActiveEmailOTP(User $user) : bool
    {
        if($user->email_otp != null && (self::emailOTPTimePassed($user) <= self::$validtime)){
            return true;
        }
        return false;
    }

    public static function hasActivePhoneOTP(User $user) : bool
    {
        if($user->phone_otp != null && (self::phoneOTPTimePassed($user) <= self::$validtime)){
            return true;
        }
        return false;
    }

    public static function shouldLockEmailOTP(User $user)
    {
        if(!($user->email_otp_count <= VerifyOTP::$shouldLockCount)){
            return true;
        }
        return false;
    }

    public static function shouldLockPhoneOTP(User $user)
    {
        if(!($user->phone_otp_count <= VerifyOTP::$shouldLockCount)){
            return true;
        }
        return false;
    }

}
