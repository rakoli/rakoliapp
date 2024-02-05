@props([
    'route',
    'label',
])
<a href="{{ $route }}" {{ $attributes->merge(['class' => 'btn btn-primary']) }}>
    {{ __($label) }}
</a>

