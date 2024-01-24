<div class="d-flex align-items-center w-250px">
    <!--begin::Wrapper-->
    <div class="me-5 position-relative">
        <!--begin::Avatar-->
        <div class="symbol symbol-35px symbol-circle">
            <span class="symbol-label bg-light-info text-info fw-semibold">{{substr($ad->business->business_name, 0, 1)}}</span>
        </div>
        <!--end::Avatar-->
        <!--begin::Online-->
        @if(\Carbon\Carbon::create($ad->business->last_seen)->diffInMinutes(now()) <= 30)
            <div class="bg-success position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1"></div>
        @endif
        @if(\Carbon\Carbon::create($ad->business->last_seen)->diffInMinutes(now()) > 30 && \Carbon\Carbon::create($ad->business->last_seen)->diffInMinutes(now()) <= 60)
            <div class="bg-warning position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1"></div>
        @endif

        @if(\Carbon\Carbon::create($ad->business->last_seen)->diffInMinutes(now()) > 60 && \Carbon\Carbon::create($ad->business->last_seen)->diffInMinutes(now()) <= 120)
            <div class="bg-danger position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1"></div>
        @endif

        @if(\Carbon\Carbon::create($ad->business->last_seen)->diffInMinutes(now()) > 120)
            <div class="bg-gray-600 position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1"></div>
        @endif

        <!--end::Online-->
    </div>
    <!--end::Wrapper-->
    <!--begin::Info-->
    <div class="d-flex flex-column justify-content-center">
        <a href="" class="fs-6 text-gray-800 text-hover-primary">{{$ad->business->business_name}}</a>
        <div class="fw-semibold text-gray-600">{{$ad->trades}} {{__('general.exchange.trades.bd')}} | {{$ad->completion}}% {{__('completion')}}</div>
        <div class="fw-semibold text-gray-600"><i class="ki-solid ki-like fs-6"></i> {{$ad->feedback}}%</div>
        <div class="fw-semibold text-gray-600">{{__('general.online')}}: {{\Carbon\Carbon::create($ad->business->last_seen)->locale(session('locale'))->diffForHumans(\Carbon\CarbonInterface::DIFF_RELATIVE_AUTO,true)}} {{__('general.last_seen')}}</div>
    </div>
    <!--end::Info-->
</div>
