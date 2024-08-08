<x-mail::message>
Dear {{$receiver->name()}},

Thanks for registering at Rakoli. For more information on how to use our the system watch video

<x-mail::button :url="$url">
Watch Now
</x-mail::button>

Contact us at phone <a href="tel:+255743283839" target="_blank">+255 743 283 839</a> email <a href="mailto:support@rakoli.com" target="_blank">support@rakoli.com</a> or open a ticket at <a href="https://support.rakoli.com/" target="_blank">support.rakoli.com</a>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
