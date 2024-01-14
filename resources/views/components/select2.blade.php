@props([
    'placeholder' => "Select an option",
    'modalId' => null,
])
<select
    data-control="select2"
    data-dropdown-parent="#{{ $modalId }}"
    data-allow-clear="true"
    {{ $attributes->merge(['class' => 'form-select']) }}
    data-placeholder="{{ __($placeholder) }}">
    {{ $slot }}
</select>



