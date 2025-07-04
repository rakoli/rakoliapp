@extends('layouts.users.admin')

@section('title', "Sales Users & Referrals")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="page-title d-flex flex-column me-3">
        <h1 class="d-flex text-white fw-bold my-1 fs-3">{{ __('Sales Users & Referrals') }}</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
            <li class="breadcrumb-item text-white opacity-75">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-hover-primary">{{ __('Dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-white opacity-75">{{ __('Sales Users') }}</li>
        </ul>
    </div>
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl pt-8">

        <!--begin::Row-->
        <div class="row gy-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-2 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-people fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format($stats['total_sales_users'])}}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Sales Users')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-primary fs-base">
                            <i class="ki-outline ki-user fs-5 text-primary ms-n1"></i>{{__('Active')}}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-2 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-user-tick fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format($stats['total_referrals'])}}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Total Referrals')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-success fs-base">
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>{{__('All Time')}}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-2 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-shield-tick fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format($stats['active_referrals'])}}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Active Referrals')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-success fs-base">
                            <i class="ki-outline ki-check fs-5 text-success ms-n1"></i>{{__('With Packages')}}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-dollar fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{session('currency', 'TZS')}} {{number_format($stats['total_commission'], 0)}}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Total Commission Value')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-info fs-base">
                            <i class="ki-outline ki-chart-line-up fs-5 text-info ms-n1"></i>{{__('Revenue')}}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-5 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-chart-pie-simple fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            @php
                                $conversionRate = $stats['total_referrals'] > 0
                                    ? round(($stats['active_referrals'] / $stats['total_referrals']) * 100, 1)
                                    : 0;
                            @endphp
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{$conversionRate}}%</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Conversion Rate')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-{{ $conversionRate >= 50 ? 'success' : ($conversionRate >= 25 ? 'warning' : 'danger') }} fs-base">
                            <i class="ki-outline ki-{{ $conversionRate >= 50 ? 'arrow-up' : ($conversionRate >= 25 ? 'minus' : 'arrow-down') }} fs-5 text-{{ $conversionRate >= 50 ? 'success' : ($conversionRate >= 25 ? 'warning' : 'danger') }} ms-n1"></i>
                            {{ $conversionRate >= 50 ? __('Excellent') : ($conversionRate >= 25 ? __('Good') : __('Needs Work')) }}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">

                    <!--begin::Details content-->
                    <!-- <div class="separator separator-dashed"></div> -->
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            <div class="py-5 fs-6">

                                <div class="fw-bold mt-5">{{__("Total Sales Users")}}</div>
                                <div class="text-gray-600">{{number_format($stats['total_sales_users'])}}</div>

                                <div class="fw-bold mt-5">{{__("Total Referrals Made")}}</div>
                                <div class="text-gray-600">
                                    {{number_format($stats['total_referrals'])}}
                                </div>

                                <div class="fw-bold mt-5">{{__("Active Referrals")}}</div>
                                <div class="text-gray-600">
                                    {{number_format($stats['active_referrals'])}}
                                </div>

                                <div class="fw-bold mt-5">{{__("Total Commission Value")}}</div>
                                <div class="text-gray-600">
                                    {{session('currency', 'TZS')}} {{number_format($stats['total_commission'], 2)}}
                                </div>

                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>

                    <!--begin::Filters-->
                    <div class="separator separator-dashed"></div>
                    <div class="card-body pt-1">
                        <div class="collapse show">
                            <div class="py-5 fs-6">
                                <div class="fw-bold mb-5">{{__("Filters")}}</div>
                                <form method="GET" action="{{ route('admin.referrals.index') }}">
                                    <div class="fv-row mb-5">
                                        <label for="performance_filter" class="form-label">{{ __('Performance') }}</label>
                                        <select class="form-select" name="performance" id="performance_filter">
                                            <option value="">{{ __('All Sales Users') }}</option>
                                            <option value="high_performers" {{ request('performance') == 'high_performers' ? 'selected' : '' }}>{{ __('High Performers (5+ referrals)') }}</option>
                                            <option value="active" {{ request('performance') == 'active' ? 'selected' : '' }}>{{ __('Active (1+ referrals)') }}</option>
                                            <option value="inactive" {{ request('performance') == 'inactive' ? 'selected' : '' }}>{{ __('No Referrals') }}</option>
                                        </select>
                                    </div>
                                    <div class="fv-row mb-5">
                                        <label for="country_filter" class="form-label">{{ __('Country') }}</label>
                                        <select class="form-select" name="country" id="country_filter">
                                            <option value="">{{ __('All Countries') }}</option>
                                            <option value="TZ" {{ request('country') == 'TZ' ? 'selected' : '' }}>{{ __('Tanzania') }}</option>
                                            <option value="KE" {{ request('country') == 'KE' ? 'selected' : '' }}>{{ __('Kenya') }}</option>
                                            <option value="UG" {{ request('country') == 'UG' ? 'selected' : '' }}>{{ __('Uganda') }}</option>
                                            <option value="RW" {{ request('country') == 'RW' ? 'selected' : '' }}>{{ __('Rwanda') }}</option>
                                        </select>
                                    </div>
                                    <div class="fv-row mb-5">
                                        <label for="date_from" class="form-label">{{ __('Registered From') }}</label>
                                        <input type="date" class="form-control" name="date_from" id="date_from" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="fv-row mb-5">
                                        <label for="date_to" class="form-label">{{ __('Registered To') }}</label>
                                        <input type="date" class="form-control" name="date_to" id="date_to" value="{{ request('date_to') }}">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm">{{ __('Filter') }}</button>
                                        <a href="{{ route('admin.referrals.index') }}" class="btn btn-secondary btn-sm">{{ __('Reset') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Filters-->

                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!--begin::Table-->
                <div class="card card-flush">

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table container-->
                        <div class="table-responsive">

                            {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4'], true) !!}

                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            </div>
            <!--end::Content-->

        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->
@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
@endsection
