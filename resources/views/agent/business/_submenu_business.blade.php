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
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('ads')}}"
                       href="{{route('exchange.ads')}}">{{__('Account Subscription')}}</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('transactions')}}"
                       href="{{route('exchange.transactions')}}">{{__('Referrals')}}</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('posts')}}"
                       href="{{route('exchange.posts')}}">{{__('Roles')}}</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('methods')}}"
                       href="{{route('exchange.methods')}}">{{__('Users')}}</a>
                </li>
                <!--end::Nav item-->
                 <!--begin::Nav item-->
                 <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('methods')}}"
                       href="{{route('exchange.methods')}}">{{__('Payments')}}</a>
                </li>
                <!--end::Nav item-->
                 <!--begin::Nav item-->
                 <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('methods')}}"
                    href="{{route('business.profile.update')}}">{{__('Business Profile')}}</a>
                </li>
                <!--end::Nav item-->
                 <!--begin::Nav item-->
                 <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('methods')}}"
                       href="{{route('exchange.methods')}}">{{__('Branches')}}</a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--end::Nav-->
            <!--begin::Action-->
            {{-- <a href="{{route('exchange.roles.create')}}" class="btn btn-primary fw-bold fs-8 fs-lg-base">{{__('Create role')}}</a> --}}
            <!--end::Action-->
        </div>
        <!--end::Hero nav-->
    </div>
    <!--end::Hero body-->
</div>
<!--end::Hero card-->
