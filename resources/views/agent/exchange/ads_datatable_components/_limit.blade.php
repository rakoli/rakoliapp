<div class="d-flex flex-center w-250px">
    <!--begin::Stats-->
    <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
        <div class="fs-6 fw-bold text-gray-600">
            <span class="w-75px">{{number_format($ad->min_amount,0)}}</span>
            <i class="ki-outline ki-arrow-down fs-3 text-warning-emphasis"></i>
        </div>
        <div class="fw-semibold text-muted">{{__('Minimum')}}</div>
    </div>
    <!--end::Stats-->
    <!--begin::Stats-->
    <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
        <div class="fs-6 fw-bold text-gray-600">
            <span class="w-50px">{{number_format($ad->max_amount,0)}}</span>
            <i class="ki-outline ki-arrow-up fs-3 text-success-emphasis"></i>
        </div>
        <div class="fw-semibold text-muted">{{__('Maximum')}}</div>
    </div>
    <!--end::Stats-->
</div>
