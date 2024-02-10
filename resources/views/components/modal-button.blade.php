@props([
    'targetId',
    'label',
])
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $targetId }}">
    {{ __($label) }}
</button>

