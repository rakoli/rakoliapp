@props([
    'route'
])
<x-a-button
    {{ $attributes->merge(['class' => 'btn btn-google  mt-sm-4 mt-md-6text-gray-100']) }}
    route="{{ $route }}"
>
    <i class="bi bi-arrow-left"></i>

    {{ __('Back ') }}
</x-a-button>
