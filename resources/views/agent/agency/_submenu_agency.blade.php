<!--begin::Hero card-->
<div class="card mb-12">
    <!--begin::Hero body-->
    <div class="card-body flex-column">
        <!--begin::Hero nav-->
        <div class="card-rounded d-flex flex-stack flex-wrap">
            <!--begin::Nav-->
            <ul class="nav flex-wrap border-transparent fw-bold">

                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('shift')}}"
                       href="{{route('agency.shift')}}">{{__('Shift')}}</a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('networks')}}"
                       href="{{route('agency.networks')}}">{{__('Networks')}}</a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('transactions')}}"
                       href="{{route('agency.transactions')}}">{{__('Transactions')}}</a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('ads')}}"
                       href="{{route('exchange.ads')}}">{{__('Ads')}}</a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('posts')}}"
                       href="{{route('exchange.posts')}}">{{__('Posts')}}</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('methods')}}"
                       href="{{route('exchange.methods')}}">{{__('Payment Methods')}}</a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--end::Nav-->
            <!--begin::Action-->

            @php
                $shift = getOpenShift();
            @endphp

            @if(!hasOpenShift())
                <a href="{{route('agency.shift.open.index')}}" class="btn btn-primary fw-bold fs-8 fs-lg-base">{{__('Open Shift')}}</a>
            @else
                <a href="{{route('agency.shift.show',$shift->id)}}" class="btn btn-primary fw-bold fs-8 fs-lg-base">{{__('View Open Shift')}}</a>
            @endif

            <!--end::Action-->
        </div>
        <!--end::Hero nav-->
    </div>
    <!--end::Hero body-->
</div>
<!--end::Hero card-->
