@extends('layouts.users.admin')

@section('title', __("Dashboard"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

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
{{--                        <i class="ki-outline ki-compass fs-2hx text-gray-600"></i>--}}
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format_short($stats['business'])}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">{{__('Business')}}</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Badge-->
                    <span class="badge badge-light-success fs-base">
{{--                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.1%--}}
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
{{--                        <i class="ki-outline ki-chart-simple fs-2hx text-gray-600"></i>--}}
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format_short($stats['total_income'])}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">{{__('Total Income')}}</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Badge-->
                    <span class="badge badge-light-success fs-base">
{{--                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.1%--}}
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
{{--                        <i class="ki-outline ki-abstract-39 fs-2hx text-gray-600"></i>--}}
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format_short($stats['exchange_listings'])}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">{{__('Exchange Listing')}}</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Badge-->
                    <span class="badge badge-light-danger fs-base">
{{--                                        <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.47%--}}
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
{{--                        <i class="ki-outline ki-map fs-2hx text-gray-600"></i>--}}
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format_short($stats['vas_listings'])}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">{{__('VAS Listing')}}</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Badge-->
                    <span class="badge badge-light-success fs-base">
{{--                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.1%--}}
                    </span>
                    <!--end::Badge-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2 mb-5 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
{{--                        <i class="ki-outline ki-abstract-35 fs-2hx text-gray-600"></i>--}}
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format_short($stats['active_subscription'])}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">{{__('Active Subscription')}}</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Badge-->
                    <span class="badge badge-light-danger fs-base">
{{--                                        <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.647%--}}
                    </span>
                    <!--end::Badge-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2 mb-5 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
{{--                        <i class="ki-outline ki-abstract-26 fs-2hx text-gray-600"></i>--}}
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format_short($stats['users'])}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">{{__('Users')}}</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Badge-->
                    <span class="badge badge-light-success fs-base">
{{--                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.1%--}}
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

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-5">
            <!--begin::Table-->
                {!! $dataTableHtml->table(['class' => 'table table-striped table-row-bordered gy-5 gs-7'],true) !!}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    </div>
    <!--end::Container-->

@endsection


@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
@endsection
