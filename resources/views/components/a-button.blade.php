@props([
    'route',
    'label' => null,
])
<a href="{{ $route }}" {{ $attributes->merge(['class' => 'btn btn-primary']) }}>
    {{ __($label) ?? $slot }}
</a>

