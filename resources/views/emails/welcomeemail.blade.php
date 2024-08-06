<x-mail::message>
Dear {{$receiver->name()}},

Thanks for registering at Rakoli. For more information on how to use our the system watch video

<x-mail::button :url="$url">
Watch Now
</x-mail::button>

Contact us during business hour at <a href="mailto:rakoli@rakoli.com" target="_blank">rakoli@rakoli.com</a>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
