<?php

namespace App\Utils;

use App\Models\User;
use function Laravel\Prompts\select;

class VerifyOTP
{

//    public int $validtime = 300; //seconds
    public static int $validtime = 300; //seconds
    public static int $shouldLockCount = 5; //no of trials

    public static function generateOTPCode(){
        return random_int(100000, 999999);
    }

    public static function emailOTPTimeLeft(User $user)
    {
        return now()->diffInSeconds($user->email_otp_time);
    }

    public static function phoneOTPTimeLeft(User $user)
    {
        return now()->diffInSeconds($user->email_otp_time);
    }

    public static function isEmailOTPValid($userInput, User $user) : bool
    {
        $validity = false;
        if($user->email_otp == $userInput && (self::emailOTPTimeLeft($user) <= self::$validtime)){
            return true;
        }
        return $validity;
    }

    public static function isPhoneOTPValid($userInput, User $user) : bool
    {
        $validity = false;
        if($user->phone_otp == $userInput && (self::phoneOTPTimeLeft($user) <= self::$validtime)){
            return true;
        }
        return $validity;
    }

    public static function hasActiveEmailOTP(User $user) : bool
    {
        if($user->email_otp != null && (self::emailOTPTimeLeft($user) <= self::$validtime)){
            return true;
        }
        return false;
    }

    public static function hasActivePhoneOTP(User $user) : bool
    {
        if($user->phone_otp != null && (self::phoneOTPTimeLeft($user) <= self::$validtime)){
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
