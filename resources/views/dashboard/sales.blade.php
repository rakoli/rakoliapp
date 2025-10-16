@extends('layouts.users.agent')

@section('title', __("Dashboard"))

@section('header_js')
@endsection
<style>
    .d-flex.flex-column.content-justify-center.flex-row-fluid{width:100%}
    .align-start{align-items: flex-start;}
</style>
@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Analytics Widgets Row-->
        <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
            <!--begin::Total Earnings Widget-->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card bg-success hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20 19.725V18.725C20 18.125 19.6 17.725 19 17.725H5C4.4 17.725 4 18.125 4 18.725V19.725H3C2.4 19.725 2 20.125 2 20.725V21.725C2 22.325 2.4 22.725 3 22.725H21C21.6 22.725 22 22.325 22 21.725V20.725C22 20.125 21.6 19.725 21 19.725H20Z" fill="currentColor"/>
                                <path opacity="0.3" d="M22 6.725V7.725C22 8.325 21.6 8.725 21 8.725H3C2.4 8.725 2 8.325 2 7.725V6.725L11 2.225C11.6 1.925 12.4 1.925 13 2.225L22 6.725ZM12 3.725C11.2 3.725 10.5 4.425 10.5 5.225S11.2 6.725 12 6.725C12.8 6.725 13.5 6.025 13.5 5.225S12.8 3.725 12 3.725Z" fill="currentColor"/>
                                <path opacity="0.3" d="M18.1 21.725H5.9C5.4 21.725 4.9 21.325 4.8 20.825L3 10.725H21L19.2 20.825C19.1 21.325 18.6 21.725 18.1 21.725Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">TZS{{ number_format($stats['total_earnings'], 0) }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('Total Earnings') }}</div>
                    </div>
                </div>
            </div>
            <!--end::Total Earnings Widget-->

            <!--begin::Total Referrals Widget-->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card bg-primary hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                                <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                                <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">{{ $stats['total_referred_businesses'] }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('Total Referrals') }}</div>
                    </div>
                </div>
            </div>
            <!--end::Total Referrals Widget-->

            <!--begin::Active Referrals Widget-->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M8.7 4.19L4 6.3V18.7L8.7 16.6C9.1 16.4 9.6 16.6 9.6 17.1V18.8C9.6 19.1 9.2 19.3 8.9 19.3C8.8 19.3 8.7 19.3 8.6 19.2L2.3 16.6C1.9 16.4 1.6 16 1.6 15.6V5.8C1.6 5.4 1.9 5 2.3 4.8L8.6 2.2C8.7 2.1 8.8 2.1 8.9 2.1C9.2 2.1 9.6 2.3 9.6 2.6V4.3C9.6 4.8 9.1 5 8.7 4.8V4.19Z" fill="currentColor"/>
                                <path opacity="0.3" d="M15.3 4.19L20 6.3V18.7L15.3 16.6C14.9 16.4 14.4 16.6 14.4 17.1V18.8C14.4 19.1 14.8 19.3 15.1 19.3C15.2 19.3 15.3 19.3 15.4 19.2L21.7 16.6C22.1 16.4 22.4 16 22.4 15.6V5.8C22.4 5.4 22.1 5 21.7 4.8L15.4 2.2C15.3 2.1 15.2 2.1 15.1 2.1C14.8 2.1 14.4 2.3 14.4 2.6V4.3C14.4 4.8 14.9 5 15.3 4.8V4.19Z" fill="currentColor"/>
                                <path opacity="0.3" d="M10.9 16.6L15.6 18.7V6.3L10.9 4.2C10.5 4 10 4.2 10 4.7V16.1C10 16.6 10.5 16.8 10.9 16.6Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">{{ $stats['active_referrals'] }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('Active Referrals') }}</div>
                        <div class="fw-bold text-white opacity-50 fs-7">({{ $stats['performance_percentage'] }}% Performance)</div>
                    </div>
                </div>
            </div>
            <!--end::Active Referrals Widget-->

            <!--begin::This Month Widget-->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card bg-warning hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor"/>
                                <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor"/>
                                <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">{{ $stats['monthly_referrals'] }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('This Month') }}</div>
                    </div>
                </div>
            </div>
            <!--end::This Month Widget-->
        </div>
        <!--end::Analytics Widgets Row-->

        <!--begin::Form Submissions Row-->
        <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
            <!--begin::Total Form Submissions Widget-->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card bg-dark hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M14 18V16H10V18C10 19.1 10.9 20 12 20S14 19.1 14 18ZM20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H8V18H4V8H20V18H16V20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4Z" fill="currentColor"/>
                                <path opacity="0.3" d="M6 12H18V14H6V12ZM7 16H17V18H7V16ZM7 8H17V10H7V8Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">{{ $stats['total_form_submissions'] ?? 0 }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('Total Form Submissions') }}</div>
                    </div>
                </div>
            </div>
            <!--end::Total Form Submissions Widget-->

            <!--begin::Form Submission Earnings Widget-->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card bg-danger hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M18.3 8.5C17.9 8.3 17.4 8.1 16.9 8.1C16.6 8.1 16.3 8.2 16.1 8.3L15.5 6.4C15.4 6.1 15.1 5.9 14.8 5.9H9.2C8.9 5.9 8.6 6.1 8.5 6.4L7.9 8.3C7.7 8.2 7.4 8.1 7.1 8.1C6.6 8.1 6.1 8.3 5.7 8.5C5.3 8.7 5 9.1 4.9 9.6L4.5 11.9C4.4 12.4 4.6 12.9 5 13.2L6.8 14.5V19C6.8 19.6 7.2 20 7.8 20H16.2C16.8 20 17.2 19.6 17.2 19V14.5L19 13.2C19.4 12.9 19.6 12.4 19.5 11.9L19.1 9.6C19 9.1 18.7 8.7 18.3 8.5Z" fill="currentColor"/>
                                <path opacity="0.3" d="M12 2C10.3 2 8.9 3.4 8.9 5.1V5.9H15.1V5.1C15.1 3.4 13.7 2 12 2Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">TZS {{ number_format($stats['form_submission_earnings'] ?? 0, 0) }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('Form Submission Earnings') }}</div>
                        <div class="fw-bold text-white opacity-50 fs-7">TZS 1,000 per valid submission</div>
                    </div>
                </div>
            </div>
            <!--end::Form Submission Earnings Widget-->
        </div>
        <!--end::Form Submissions Row-->

        <!--begin::Earnings Breakdown Row-->
        <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
            <!--begin::Registration Earnings Card-->
            <div class="col-xl-6 col-lg-6">
                <div class="card card-flush h-md-50">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">{{ __('Registration Earnings') }}</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">TZS{{ number_format($stats['registration_earnings'], 0) }} from {{ $stats['total_referred_businesses'] }} referrals</span>
                        </h3>
                    </div>
                    <div class="card-body d-flex align-items-end pt-0">
                        <div class="d-flex align-items-center flex-column w-100">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-bolder fs-6 text-dark">TZS{{ number_format(1000, 0) }} per referral</span>
                                <span class="fw-bold fs-6 text-gray-400">{{ $stats['total_referred_businesses'] }} × TZS1,000</span>
                            </div>
                            <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                <div class="bg-success rounded h-8px" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Registration Earnings Card-->

            <!--begin::Usage Earnings Card-->
            <div class="col-xl-6 col-lg-6">
                <div class="card card-flush h-md-50">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">{{ __('Usage Earnings (2 Weeks)') }}</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">TZS{{ number_format($stats['usage_earnings'], 0) }} from shift bonuses</span>
                        </h3>
                    </div>
                    <div class="card-body d-flex align-items-end pt-0">
                        <div class="d-flex align-items-center flex-column w-100">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-bolder fs-6 text-dark">TZS500 per milestone</span>
                                <span class="fw-bold fs-6 text-gray-400">7+ shifts/week bonus</span>
                            </div>
                            <div class="h-8px mx-3 w-100 bg-light-warning rounded">
                                @php
                                    $usagePercentage = $stats['total_referred_businesses'] > 0 ? ($stats['usage_earnings'] / ($stats['total_referred_businesses'] * 1000)) * 100 : 0;
                                @endphp
                                <div class="bg-warning rounded h-8px" role="progressbar" style="width: {{ min($usagePercentage, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Usage Earnings Card-->
        </div>
        <!--end::Earnings Breakdown Row-->

        <!--begin::Row-->
        <div class="row g-5 gx-xl-10 mb-5 mb-xl-10 align-start">

            <!--begin::Col-->
            <div class="col-xxl-6">
                <!--begin::Engage widget 10-->
                <div class="card card-flush h-md-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0">
                        <!--begin::Wrapper-->
                        <div class="mb-10">
                            <!--begin::Title-->
                            <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                                <span class="me-2">Welcome to the leading<br />
                                <span class="position-relative d-inline-block text-danger">
                                    <!--begin::Separator-->
                                    <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                    <!--end::Separator-->
                                </span></span>Sales Management
                            </div>
                            <!--end::Title-->
                            <!--begin::Action-->
                            <div class="text-center">
                                <a href="{{ route('business.referrals') }}" class="btn btn-lg btn-primary me-3">
                                    {{ __('View Referrals') }}
                                </a>
                            </div>
                            <!--end::Action-->
                        </div>
                        <!--begin::Wrapper-->
                        <!--begin::Illustration-->
                        <img class="mx-auto h-150px h-lg-200px theme-light-show" src="{{asset('assets/media/illustrations/misc/upgrade.svg')}}" alt="" />
                        <img class="mx-auto h-150px h-lg-200px theme-dark-show" src="{{asset('assets/media/illustrations/misc/upgrade-dark.svg')}}" alt="" />
                        <!--end::Illustration-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Engage widget 10-->
            </div>
            <!--end::Col-->

            <!--begin::Quick Actions Col-->
            <div class="col-xxl-6">
                <div class="card card-flush h-md-100">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">{{ __('Quick Actions') }}</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">{{ __('Manage your referral activities') }}</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="d-flex flex-column gap-5">
                            <!--begin::Action Item-->
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-5">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="ki-outline ki-people fs-1 text-primary"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="{{ route('business.referrals') }}" class="text-dark fw-bold text-hover-primary fs-6">{{ __('Manage Referrals') }}</a>
                                    <span class="text-muted fw-semibold">{{ __('View and manage your referred businesses') }}</span>
                                </div>
                            </div>
                            <!--end::Action Item-->

                            <!--begin::Action Item-->
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-5">
                                    <span class="symbol-label bg-light-success">
                                        <i class="ki-outline ki-dollar fs-1 text-success"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <span class="text-dark fw-bold fs-6">{{ __('Total Earnings') }}</span>
                                    <span class="text-muted fw-semibold">TZS{{ number_format($stats['total_earnings'], 0) }} {{ __('earned so far') }}</span>
                                </div>
                            </div>
                            <!--end::Action Item-->

                            <!--begin::Action Item-->
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-5">
                                    <span class="symbol-label bg-light-info">
                                        <i class="ki-outline ki-chart-line-up fs-1 text-info"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <span class="text-dark fw-bold fs-6">{{ __('Performance') }}</span>
                                    <span class="text-muted fw-semibold">{{ $stats['performance_percentage'] }}% {{ __('of referrals are active') }}</span>
                                </div>
                            </div>
                            <!--end::Action Item-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Quick Actions Col-->

        </div>
        <!--end::Row-->

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
@endsection
