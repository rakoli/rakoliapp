<div class="d-flex align-items-center w-250px">
    <!--begin::Wrapper-->
    <div class="me-5 position-relative">
        <!--begin::Avatar-->
        <div class="symbol symbol-35px symbol-circle">
            <span class="symbol-label bg-light-info text-info fw-semibold">{{substr($ad->business->business_name, 0, 1)}}</span>
        </div>
        <!--end::Avatar-->
        <!--begin::Online-->
        <div class="bg-success position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1"></div>
        <!--end::Online-->
    </div>
    <!--end::Wrapper-->
    <!--begin::Info-->
    <div class="d-flex flex-column justify-content-center">
        <a href="" class="fs-6 text-gray-800 text-hover-primary">{{$ad->business->business_name}}</a>
        <div class="fw-semibold text-gray-600">{{$ad->business->exchange_stats->no_of_trades_completed}} {{__('general.exchange.trades.bd')}} | {{$ad->business->exchange_stats->getCompletionRatePercentage()}}% {{__('completion')}}</div>
        <div class="fw-semibold text-gray-600"><i class="ki-solid ki-like fs-6"></i> {{$ad->business->exchange_stats->getFeedbackRatePercentage()}}%</div>
    </div>
    <!--end::Info-->
</div>
