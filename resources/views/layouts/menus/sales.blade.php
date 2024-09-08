<!-- Home -->
<div class="menu-item py-2">
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

<!-- Business Management -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-gear fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('Business') }}
        </span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1">
                    {{ __('Business Management') }}
                </span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="{{route('business.subscription')}}"><span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Account Subscription') }}</span>
                </a>
                <a class="menu-link" href="{{route('business.referrals')}}"><span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Referrals',) }}</span>
                </a>
                <a class="menu-link" href="{{route('business.role')}}"><span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Roles') }}</span>
                </a>
                <a class="menu-link" href="{{route('business.users')}}"><span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Users') }}</span>
                </a>
                <a class="menu-link" href="{{route('business.finance')}}"><span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Finance') }}</span>
                </a>
                <a class="menu-link" href="{{route('business.profile.update')}}"><span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Business Profile') }}</span>
                </a>
                <a class="menu-link" href="{{route('business.branches')}}"><span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Branches') }}</span>
                </a>
                <a class="menu-link close_account" href="{{route('business.users.close_account')}}"><span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ __('Close Account') }}</span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>