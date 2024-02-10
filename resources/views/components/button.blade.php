@props([
    'type' => "button",

])

<button type="{{ $type }}" {{ $attributes->merge(["class" => "btn btn-light"]) }} >{{  $slot }}</button>
