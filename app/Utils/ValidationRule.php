<?php

namespace App\Utils;

class ValidationRule
{
    public static function agentRegistration(): array
    {
        return [
            'country_dial_code' => ['exists:countries,dialing_code'],
            'fname' => ['required', 'string', 'max:20'],
            'lname' => ['required', 'string', 'max:20'],
            'phone' => ['required','numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referral_business_code' => ['nullable', 'string', 'exists:businesses,code'],
        ];
    }

}
