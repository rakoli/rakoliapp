@props([
    'route'
])
<x-a-button
    {{ $attributes->merge(['class' => 'btn-google text-gray-100']) }}
    route="{{ $route }}"
>
    <i class="bi bi-arrow-left"></i>

    {{ __('Back ') }}
</x-a-button>
