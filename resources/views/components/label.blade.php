@props([
    "label",
    "for"
])
<label
    for="{{ $for }}"
    {{ $attributes->merge(['class' => 'required fw-semibold fs-6 mb-2']) }}
    class="">{{ __($label) }}</label>
