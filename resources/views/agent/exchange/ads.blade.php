@extends('layouts.users.agent')

@section('title', __("Ads"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.exchange._submenu_exchange')

        <!--begin::Table-->
        <div class="card card-flush mt-6 mt-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-5">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1">{{__("Exchange Advertisements")}}</h3>
                </div>
{{--                <!--begin::Card title-->--}}
{{--                <!--begin::Card toolbar-->--}}
{{--                <div class="card-toolbar my-1">--}}
{{--                    <!--begin::Select-->--}}
{{--                    <div class="me-6 my-1">--}}
{{--                        <select id="kt_filter_year" name="year" data-control="select2" data-hide-search="true" class="w-125px form-select form-select-solid form-select-sm">--}}
{{--                            <option value="All" selected="selected">Region</option>--}}
{{--                            <option value="thisyear">Dar es salaam</option>--}}
{{--                            <option value="thismonth">Arusha</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <!--end::Select-->--}}
{{--                    <!--begin::Select-->--}}
{{--                    <div class="me-4 my-1">--}}
{{--                        <select id="kt_filter_orders" name="orders" data-control="select2" data-hide-search="true" class="w-125px form-select form-select-solid form-select-sm">--}}
{{--                            <option value="All" selected="selected">Sub Region</option>--}}
{{--                            <option value="Approved">Kinondoni</option>--}}
{{--                            <option value="Declined">Orkesumet</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <!--end::Select-->--}}
{{--                    <!--begin::Search-->--}}
{{--                    <div class="d-flex align-items-center position-relative my-1">--}}
{{--                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-3"></i>--}}
{{--                        <input type="text" id="kt_filter_search" class="form-control form-control-solid form-select-sm w-200px ps-9" placeholder="Search Advertisements" />--}}
{{--                    </div>--}}
{{--                    <!--end::Search-->--}}

{{--                </div>--}}
{{--                <!--begin::Card toolbar-->--}}
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table container-->
                <div class="table-responsive">

                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4 align-middle fw-bold'],true) !!}

                </div>
                <!--end::Table container-->
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
