@extends('layouts.users.admin')

@section('title', "Sales User Referrals")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="page-title d-flex flex-column me-3">
        <h1 class="d-flex text-white fw-bold my-1 fs-3">{{ __('Referrals by') }} {{ $salesUser->fname }} {{ $salesUser->lname }}</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
            <li class="breadcrumb-item text-white opacity-75">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-hover-primary">{{ __('Dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-white opacity-75">
                <a href="{{ route('admin.referrals.index') }}" class="text-white text-hover-primary">{{ __('Sales Users') }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-white opacity-75">{{ __('Referrals') }}</li>
        </ul>
    </div>
@endsection

@section('content')

    <!--begin::Container-->
    <br>
    <br>
    <br>
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">

                    <!--begin::Sales User Info-->
                    <div class="card-body pt-5">
                        <div class="d-flex align-items-center mb-5">
                            <div class="symbol symbol-40px me-4">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-user fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <h5 class="mb-1">{{ $salesUser->fname }} {{ $salesUser->lname }}</h5>
                                <span class="text-muted fs-7">{{ __('Sales User') }}</span>
                            </div>
                        </div>

                        <div class="separator separator-dashed mb-5"></div>

                        <div class="mb-3">
                            <div class="fw-bold">{{ __('Email') }}</div>
                            <div class="text-gray-600">{{ $salesUser->email }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-bold">{{ __('Phone') }}</div>
                            <div class="text-gray-600">{{ $salesUser->phone }}</div>
                        </div>

                        @if($salesUser->business)
                        <div class="mb-3">
                            <div class="fw-bold">{{ __('Business') }}</div>
                            <div class="text-gray-600">{{ $salesUser->business->business_name }}</div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <div class="fw-bold">{{ __('Country') }}</div>
                            <div class="text-gray-600">{{ $salesUser->country_code }}</div>
                        </div>
                    </div>
                    <!--end::Sales User Info-->

                    <!--begin::Details content-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            <div class="py-5 fs-6">

                                <div class="fw-bold mt-5">{{__("Total Referrals")}}</div>
                                <div class="text-gray-600">{{number_format($stats['total_referrals'])}}</div>

                                <div class="fw-bold mt-5">{{__("Active Referrals")}}</div>
                                <div class="text-gray-600">
                                    {{number_format($stats['active_referrals'])}}
                                </div>

                                <div class="fw-bold mt-5">{{__("Inactive Referrals")}}</div>
                                <div class="text-gray-600">
                                    {{number_format($stats['inactive_referrals'])}}
                                </div>

                                <div class="fw-bold mt-5">{{__("Total Commission Value")}}</div>
                                <div class="text-gray-600">
                                    {{session('currency', 'TZS')}} {{number_format($stats['total_commission'], 2)}}
                                </div>

                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>

                    <!--begin::Actions-->
                    <div class="separator separator-dashed"></div>
                    <div class="card-body pt-5">
                        <a href="{{ route('admin.referrals.index') }}" class="btn btn-secondary btn-sm w-100">
                            <i class="ki-duotone ki-arrow-left fs-3"><span class="path1"></span><span class="path2"></span></i>
                            {{ __('Back to Sales Users') }}
                        </a>
                    </div>
                    <!--end::Actions-->

                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!--begin::Table-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header pt-8">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <h3 class="fw-bold me-5 my-1">{{ __('All Referrals by') }} {{ $salesUser->fname }} {{ $salesUser->lname }}</h3>
                            </div>
                        </div>
                    </div>
                    <!--end::Card header-->

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
