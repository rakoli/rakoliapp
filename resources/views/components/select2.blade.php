@props([
    'placeholder' => "Select an option",
    'modalId' => null,
])
<select
    data-control="select2"
    @if(filled($modalId))
        data-dropdown-parent="#{{ $modalId }}"
    @endif

    data-allow-clear="true"
    {{ $attributes->merge(['class' => 'form-select']) }}
    data-placeholder="{{ __($placeholder) }}">
    {{ $slot }}
</select>
