@props([
    'placeholder' => "Select an option"
])
<select
    id="{{ str($placeholder)->slug()->value() }}"
    data-control="select2"
    {{ $attributes->merge(['class' => 'form-select']) }}
    data-placeholder="{{ __($placeholder) }}">
    {{ $slot }}
</select>



