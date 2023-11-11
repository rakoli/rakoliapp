<x-mail::message>
Dear {{$receiver->name()}},

Thank you for registering at Rakoli. To complete your registration and ensure the security of your account,
    we need to verify your email address. Please find your verification code below:

<x-mail::panel>
    Verification Code: {{$code}}
</x-mail::panel>

This code will be valid for {{$minutes}} minutes. Once account is successfully verified, and you can start enjoying the benefits of Rakoli.<br>

If you didn't request this verification code, or if you have any concerns about your account's security, please contact our support team immediately.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
