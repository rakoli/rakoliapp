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
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 
                       {{ returnActiveSubMenuStyle('subscription') }} 
                       {{ request()->is('business/subscription') || request()->is('business/subscription_buy') ? 'active' : '' }}"
                       href="{{ route('business.subscription') }}">
                       {{__('Account Subscription')}}
                    </a>
                </li>                
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('referrals')}}"
                       href="{{route('business.referrals')}}">{{__('Referrals')}}</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('role')}}"
                       href="{{route('business.role')}}">{{__('Roles')}}</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 
                    {{returnActiveSubMenuStyle('users')}}
                    {{ request()->is('business/users') || request()->is('business/users/create') ? 'active' : '' }}"
                    href="{{route('business.users')}}">
                    {{__('Users')}}</a>
                </li>
                <!--end::Nav item-->
                 <!--begin::Nav item-->
                 <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('finance')}}"
                       href="{{route('business.finance')}}">{{__('Finance')}}</a>
                </li>
                <!--end::Nav item-->
                 <!--begin::Nav item-->
                 <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{ request()->is('business/profile/update') ? 'active' : '' }}"
                    href="{{route('business.profile.update')}}">{{__('Business Profile')}}</a>
                </li>
                <!--end::Nav item-->
                 <!--begin::Nav item-->
                 <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{ request()->is('business/profile/verification') ? 'active' : '' }}"
                    href="{{route('business.profile.verification')}}">{{__('Verification')}}</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                 <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 
                    {{returnActiveSubMenuStyle('branches')}}
                    {{ request()->is('business/branches') || request()->is('business/branches/create') ? 'active' : '' }}"
                    href="{{route('business.branches')}}">
                    {{__('Branches')}}</a>
                </li>
                <!--end::Nav item-->
                 <!--begin::Nav item-->
                 <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 
                    {{returnActiveSubMenuStyle('close_account')}}
                    {{ request()->is('business/users/close_account') ? 'active' : '' }}"
                    href="{{route('business.users.close_account')}}">
                    {{__('Close Account')}}</a>
                </li>
                <!--end::Nav item-->

            </ul>
            <!--end::Nav-->
            <!--begin::Action-->
            <!--end::Action-->
        </div>
        <!--end::Hero nav-->
    </div>
    <!--end::Hero body-->
</div>
<!--end::Hero card-->
