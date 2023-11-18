@props([
    'placeholder' => "Select an option"
])
<select
    data-dropdown-parent="body"
    {{ $attributes->merge(['class' => 'form-select']) }}
    data-control="select2"
    data-placeholder="{{ __($placeholder) }}">
    {{ $slot }}
</select>
