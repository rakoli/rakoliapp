<?php

namespace App\Utils;

class ValidationRule
{
    public static function agentRegistration(): array
    {
        return [
            'country_dial_code' => ['required','exists:countries,dialing_code'],
            'business_name' => ['required', 'string'],
            'fname' => ['required', 'string', 'max:20'],
            'lname' => ['required', 'string', 'max:20'],
            'phone' => ['required','numeric', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'pin' => ['required', 'string', 'min:4', 'max:6', 'confirmed'],
            //'tax_id' => ['nullable', 'string', 'max:11'],
            'business_regno' => ['nullable', 'string', 'max:20'],
            'referral_business_code' => ['nullable', 'string', 'exists:businesses,code'],
        ];
    }

}
