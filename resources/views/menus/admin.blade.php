<div data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>

        <span class="menu-title"> <a class="menu-link" href="dashboard">{{ $translator('Home', 'Nyumbani') }} </a></span>

    </span>
    <!--end:Menu link-->
</div>
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title"> {{ $translator('Users', 'Watumiaji') }}</span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1"> {{ $translator('Users', 'Watumiaji') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">

                <a class="menu-link" href="/dashboard/admin/create-user">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Create User</span>
                </a>
                <a class="menu-link" href="/dashboard/admin/users">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">List Users</span>
                </a>
                <a class="menu-link" href="/dashboard/admin/roles-user">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Roles</span>
                </a>
                <a class="menu-link" href="/dashboard/admin/permissions">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">User permissions</span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->

    </div>
    <!--end:Menu sub-->
</div>
<!-- Exchange -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ $translator('Exchange', 'Mabadilishano') }}
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
                    data-kt-menu-translation="English|Swahili">{{ $translator('Exchange', 'Mabadilishano') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/admin/ads"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Ads', 'Matangazo') }}</a>
                <a class="menu-link" href="/dashboard/admin/ex-pending"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Pending Exchanges', 'Mabadilishano yanayosubiri') }}</a>
                <a class="menu-link" href="/dashboard/admin/transactions"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Transaction', 'Biashara') }}</a>
                <a class="menu-link" href="/dashboard/admin/security"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Security', 'Usalama') }}</a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- VAS -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ $translator('VAS', 'VAS') }}
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
                    data-kt-menu-translation="English|Swahili">{{ $translator('VAS', 'VAS') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/admin/vas-available"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Available', 'Inayopatikana') }}</a>
                <a class="menu-link" href="/dashboard/admin/vas-ongoing"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Ongoing', 'Inayoendelea') }}</a>
                <a class="menu-link" href="/dashboard/admin/vas-completed"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Completed', 'Iliyomekamilika') }}</a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- Income -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ $translator('Income', 'Mapato') }}
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
                    data-kt-menu-translation="English|Swahili">{{ $translator('Income', 'Mapato') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/admin/payments"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Payments (VAS)', 'Malipo (VAS)') }}</a>
                <a class="menu-link" href="/dashboard/admin/subscriptions"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Subscriptions', 'Usimamizi wa Subscriptions na Bei') }}</a>
                <a class="menu-link" href="/dashboard/admin/ads"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Ads', 'Matangazo') }}</a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- System -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
    class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ $translator('System', 'Mfumo') }}
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
                    data-kt-menu-translation="English|Swahili">{{ $translator('System', 'Mfumo') }}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/admin/api"
                    data-kt-menu-translation="English|Swahili">{{ $translator('API', 'API') }}</a>
                <a class="menu-link" href="/dashboard/admin/maintenance"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Maintenance', 'Matengenezo') }}</a>
                <a class="menu-link" href="/dashboard/admin/sms"
                    data-kt-menu-translation="English|Swahili">{{ $translator('SMS Communication', 'Mawasiliano ya SMS') }}</a>
                <a class="menu-link" href="/dashboard/admin/email"
                    data-kt-menu-translation="English|Swahili">{{ $translator('Email Communication', 'Mawasiliano ya Barua pepe') }}</a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>
