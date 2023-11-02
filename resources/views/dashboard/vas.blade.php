@extends('layouts.app')

@section('title', "VAS - Dashboard")

@section('aside_background')

@endsection

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Row-->
        <div class="row g-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-xl-4 mb-xl-10">
                <!--begin::Lists Widget 19-->
                <div class="card card-flush h-xl-100">
                    <!--begin::Heading-->
                    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" data-bs-theme="light">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column pt-15">
                            <span class="fw-bold fs-2x mb-3">Provider</span>
                            <div class="fs-4">
                                <span>Account summary</span>
                            </div>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Body-->
                    <div class="card-body mt-n20">
                        <!--begin::Stats-->
                        <div class="mt-n20 position-relative">
                            <!--begin::Row-->
                            <div class="row g-3 g-lg-6">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Items-->
                                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-30px me-5 mb-8">
                                            <span class="symbol-label">
{{--                                                <i class="ki-outline ki-flask fs-1 text-primary"></i>--}}
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Stats-->
                                        <div class="m-0">
                                            <!--begin::Number-->
                                            <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{number_format_short($stats['total_services'])}}</span>
                                            <!--end::Number-->
                                            <!--begin::Desc-->
                                            <span class="text-gray-500 fw-semibold fs-6">Total Services</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Items-->
                                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-30px me-5 mb-8">
																<span class="symbol-label">
{{--																	<i class="ki-outline ki-bank fs-1 text-primary"></i>--}}
																</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Stats-->
                                        <div class="m-0">
                                            <!--begin::Number-->
                                            <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{number_format_short($stats['total_submission'])}}</span>
                                            <!--end::Number-->
                                            <!--begin::Desc-->
                                            <span class="text-gray-500 fw-semibold fs-6">Submissions</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Items-->
                                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-30px me-5 mb-8">
																<span class="symbol-label">
{{--																	<i class="ki-outline ki-award fs-1 text-primary"></i>--}}
																</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Stats-->
                                        <div class="m-0">
                                            <!--begin::Number-->
                                            <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{number_format_short($stats['users'])}}</span>
                                            <!--end::Number-->
                                            <!--begin::Desc-->
                                            <span class="text-gray-500 fw-semibold fs-6">Users</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Items-->
                                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-30px me-5 mb-8">
																<span class="symbol-label">
{{--																	<i class="ki-outline ki-timer fs-1 text-primary"></i>--}}
																</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Stats-->
                                        <div class="m-0">
                                            <!--begin::Number-->
                                            <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{number_format_short($stats['payments_made'])}}</span>
                                            <!--end::Number-->
                                            <!--begin::Desc-->
                                            <span class="text-gray-500 fw-semibold fs-6">Payments Made</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Lists Widget 19-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-8 mb-5 mb-xl-10">
                <!--begin::Table Widget 4-->
                <div class="card card-flush h-xl-100">
                    <!--begin::Card header-->
                    <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Service Payments</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">Recent service payments</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Actions-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-2">
                        <!--begin::Table-->
                        {!! $dataTableHtml->table(['class' => 'table table-striped table-row-bordered gy-5 gs-7'],true) !!}
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Table Widget 4-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
@endsection
