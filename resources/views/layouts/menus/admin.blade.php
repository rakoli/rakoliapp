<!-- Home -->
<div class="menu-item py-2 {{returnActiveMenuStyle('')}}">
    <!--begin:Menu link-->
    <a class="menu-link menu-center" href="{{route('home')}}" target="_self">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('Home') }}
        </span>
    </a>
    <!--end:Menu link-->
</div>
<!-- End: Home -->

<!-- Business and User Management -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{returnActiveMenuStyle('business')}}">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-profile-user fs-2x"></i>
        </span>
        <span class="menu-title"> {{ __('Business') }}</span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1"> {{ __('Business and User Management') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">

                <a class="menu-link" href="{{route('admin.business.listbusiness')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{__('List Business')}}</span>
                </a>

                <a class="menu-link" href="{{route('admin.business.listusers')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{__('List Users')}}</span>
                </a>
                <a class="menu-link" href="{{route('admin.business.registeringuser')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{__('Registering Users')}}</span>
                </a>
                <a class="menu-link" href="{{route('admin.business.users.sales')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{__('Sales User')}}</span>
                </a>
                <a class="menu-link" href="{{route('admin.referrals.index')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{__('Referral Management')}}</span>
                </a>
                <a class="menu-link" href="https://backoffice.rakoli.com/api/auth/login?token={{ session('referral_token') }}" target="_blank">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{__('Referral Backoffice')}}</span>
                </a>

                  <a class="menu-link" href="https://form.rakoli.com/admin" target="_blank">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{__('Forms Dashboard')}}</span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->

    </div>
    <!--end:Menu sub-->
</div>

<!-- Exchange -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{returnActiveMenuStyle('adminexchange')}}">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-share fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('Exchange') }}
        </span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1"
                    >{{ __('Exchange Management') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="{{route('admin.exchange.ads')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Ads') }}</span>
                </a>
                <a class="menu-link" href="{{route('admin.exchange.transactions')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Transactions') }}</span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- VAS -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{returnActiveMenuStyle('vas')}}">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-technology fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('VAS') }}
        </span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{ __('VAS Management') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/admin/vas-available">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Listing') }}</span>
                </a>
                <a class="menu-link" href="/dashboard/admin/vas-ongoing">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Contracts') }}</span>
                </a>
                <a class="menu-link" href="/dashboard/admin/vas-completed">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Configuration') }}</span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- Income -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{returnActiveMenuStyle('income')}}">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-tag fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('Income') }}
        </span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{ __('Income Management') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/admin/payments">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Listing') }}</span>
                </a>
                <a class="menu-link" href="/dashboard/admin/subscriptions">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Subscription Pricing') }}</span>
                </a>
                <a class="menu-link" href="/dashboard/admin/ads">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Ads') }}</span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- System -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{returnActiveMenuStyle('system')}}">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-setting-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('System') }}
        </span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{ __('System') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion" >

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/admin/api">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Configuration') }}</span>
                </a>
                <a class="menu-link" href="/dashboard/admin/api">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Email Notification') }}</span>
                </a>
                <a class="menu-link" href="{{ route('admin.system.send-message') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('SMS') }}</span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>
