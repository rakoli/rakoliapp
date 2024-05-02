@props([
    'route',
    'label' => null,
])
<a href="{{ $route }}" {{ $attributes->merge(['class' => 'btn btn-primary  mt-sm-4 mt-md-6']) }}>
    {{ __($label) ?? $slot }}
</a>

