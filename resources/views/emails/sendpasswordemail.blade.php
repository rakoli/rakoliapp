<x-mail::message>
Dear {{$receiver->name()}},

{{ str_camelcase($upline->name())}} has registered a Rakoli account for you. To complete your registration and ensure the security of your account use the below credentials to login to your account

<x-mail::panel>
    Email: {{$receiver->email}}
    Password: {{$password}}
</x-mail::panel>

If you have any concerns about your account's security or this email, please contact our support team immediately.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
