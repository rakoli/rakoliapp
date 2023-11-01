@extends('layouts.app')

@section('title', "Admin - Dashboard")

@section('aside_background')
    style="background-color: #570b05"
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
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">23</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Business</span>
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
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">27.5M</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Total Income</span>
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
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">34</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Exchange Listing</span>
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
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">87</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">VAS Listing</span>
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
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">18</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Active Subscription</span>
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
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">32</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Users</span>
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
        <div class="card-body pt-0">
            <!--begin::Table-->
                {{ $dataTable->table() }}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    </div>
    <!--end::Container-->

@endsection


@section('footer_js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection
