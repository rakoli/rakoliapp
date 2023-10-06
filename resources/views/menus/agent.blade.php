<!-- Agency -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ $translator('Agency', 'Shirika') }}
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
                    {{ $translator('Agency', 'Shirika') }}
                </span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <a class="menu-link" href="/dashboard/agent/agency-transactions">
                    {{ $translator('Transaction', 'Biashara') }}
                </a>
                <a class="menu-link" href="/dashboard/agent/shift">
                    {{ $translator('Shift', 'Mabadiliko') }}
                </a>
                <a class="menu-link" href="/dashboard/agent/tills">
                    {{ $translator('Tills', 'Tills') }}
                </a>
                <a class="menu-link" href="/dashboard/agent/networks">
                    {{ $translator('Networks', 'Mfumo wa Mawasiliano') }}
                </a>
                <a class="menu-link" href="/dashboard/agent/loans">
                    {{ $translator('Loans', 'Mikopo') }}
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>

<!-- Exchange Management -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title">
            {{ $translator('Exchange', 'Kubadilishana') }}
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
                    {{ $translator('Exchange Management', 'Usimamizi wa Kubadilishana') }}
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
                    {{ $translator('Requests', 'Maombi') }}
                </a>
                <a class="menu-link" href="/dashboard/agent/pending">
                    {{ $translator('Pending', 'Inasubiri') }}
                </a>
                <a class="menu-link" href="/dashboard/agent/transaction">
                    {{ $translator('Transaction', 'Biashara') }}
                </a>
                <a class="menu-link" href="/dashboard/agent/ads">
                    {{ $translator('Ads', 'Matangazo') }}
                </a>
                <a class="menu-link" href="/dashboard/agent/security">
                    {{ $translator('Security', 'Usalama') }}
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>
