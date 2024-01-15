@props([
    'targetId',
    'label',
    'modalTitle',
    'btnClass' => "btn btn-primary",
    'size' => "modal-lg",
    'isStacked' => false
])
<button type="button" class="{{ $btnClass }}" data-bs-toggle="modal" data-bs-target="#{{ $targetId }}">
    {{ __($label) }}
</button>

<div class="modal fade" tabindex="-1" id="{{ $targetId }}">
    <div class="modal-dialog {{ $size }}  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ $modalTitle }}</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                {{ $slot }}
            </div>


        </div>
    </div>
</div>
