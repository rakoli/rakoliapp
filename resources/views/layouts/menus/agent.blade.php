<!-- Home -->
<div class="menu-item py-2">
    <!--begin:Menu link-->
    <a class="menu-link menu-center" href="{{route('home')}}" target="_self">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('general.LBL_HOME') }}
        </span>
    </a>
    <!--end:Menu link-->
</div>

<!-- Agency -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{returnActiveMenuStyle('agency')}}">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-shop fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('general.LBL_AGENCY') }}
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
                    {{ __('general.LBL_AGENCY') }}
                </span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">

                <a class="menu-link"  href ="{{route('agency.shift')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_SHIFT') }}</span>
                </a>

                <a
                    class="menu-link"
                    href ="{{route('agency.networks')}}"
                >
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_NETWORKS') }}</span>
                </a>

                <a
                    class="menu-link"
                    href ="{{route('agency.loans')}}"
                >
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_LOANS') }}</span>
                </a>

                <a
                    class="menu-link"
                    href ="{{route('agency.shift.transfer.request')}}"
                >
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_TRANSFER_REQUEST') }}</span>
                </a>

            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- Exchange Management -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{returnActiveMenuStyle('exchange')}}" >
    <!--begin:Menu link-->
    <span class="menu-link menu-center" >
        <span class="menu-icon me-0">
            <i class="ki-outline ki-share fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('general.LBL_EXCHANGE') }}
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
                    {{ __('general.LBL_EXCHANGE_MANAGEMENT') }}
                </span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">

                <a class="menu-link" href="{{route('exchange.ads')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_ADS') }}</span>
                </a>

                <a class="menu-link" href="{{route('exchange.transactions')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_TRANSACTIONS') }}</span>
                </a>

                <a class="menu-link" href="{{route('exchange.posts')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_POSTS') }}</span>
                </a>

                <a class="menu-link" href="{{route('exchange.methods')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_PAYMENT_METHODS') }}</span>
                </a>

                <a class="menu-link" href="{{route('exchange.posts.create')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{__('general.LBL_CREATE_AD')}}</span>
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
            <i class="ki-outline ki-bill fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('general.LBL_OPPORTUNITY') }}
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
                    {{ __('general.LBL_VAS_OPPORTUNITY') }}
                </span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="{!! route('agent.tasks',array('type'=>'available')) !!}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_AVAILABLE') }}
                    </span>
                </a>
                <a class="menu-link" href="{!! route('agent.tasks') !!}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_TASKS') }} <!--Ongoing-->
                    </span>
                </a>
                <a class="menu-link" href="{!! route('contracts.index') !!}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('general.LBL_CONTRACTS') }} <!--Completed-->
                    </span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- Business Management -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-gear fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('general.LBL_BUSINESS') }}
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
                    {{ __('general.LBL_BUSINESS_MANAGEMENT') }}
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
                <a class="menu-link" href="{{route('business.profile.verification')}}"><span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Verification') }}</span>
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

<!-- Reports -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{returnActiveMenuStyle('reports')}}">
    <!--begin:Menu link 
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-chart-line-up fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ __('Reports') }}
        </span>
    </span>
    end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1">
                    {{ __('Reports') }}
                </span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/agent/requests">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Income') }}
                    </span>
                </a>
                <a class="menu-link" href="/dashboard/agent/pending">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Expenses') }}
                    </span>
                </a>
                <a class="menu-link" href="/dashboard/agent/transaction">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Loans Analysis') }}
                    </span>
                </a>
                <a class="menu-link" href="/dashboard/agent/transaction">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Tills Report') }}
                    </span>
                </a>
                <a class="menu-link" href="/dashboard/agent/transaction">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{ __('Branch Analysis') }}
                    </span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>
