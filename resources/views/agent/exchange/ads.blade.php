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
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar my-1">
                    <select id="exchange_filter" name="exchange_filter" class="w-125px form-select form-select-solid" onchange="filterChanged(this.value)">
                        <option value="feedback" @if($orderByFilter == 'feedback') selected @endif>{{__("Feedback Rating")}}</option>
                        <option value="last_seen" @if($orderByFilter == 'last_seen') selected @endif>{{__("Last Seen")}}</option>
                        <option value="completion" @if($orderByFilter == 'completion') selected @endif>{{__("Completion")}}</option>
                        <option value="trades" @if($orderByFilter == 'trades') selected @endif>{{__("No of Trades")}}</option>
                        <option value="recent" @if($orderByFilter == 'recent') selected @endif>{{__("Recent")}}</option>
                        <option value="min_amount_asc" @if($orderByFilter == 'min_amount_asc') selected @endif>{{__("Min Amount - Ascending")}}</option>
                        <option value="min_amount_desc" @if($orderByFilter == 'min_amount_desc') selected @endif>{{__("Min Amount - Descending")}}</option>
                        <option value="max_amount_asc" @if($orderByFilter == 'max_amount_asc') selected @endif>{{__("Max Amount - Ascending")}}</option>
                        <option value="max_amount_desc" @if($orderByFilter == 'max_amount_desc') selected @endif>{{__("Max Amount - Descending")}}</option>
                    </select>
                    <a href="#" class="btn btn-primary m-5" onclick="filterAction()"><i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span class="path2"></span></i>{{__('Filter')}}</a>
                </div>
                <!--begin::Card toolbar-->
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

    <script>
        var filterValue = getSelectValue('exchange_filter');

        function filterChanged(selectedFilter){
            filterValue = selectedFilter;
        }

        function filterAction(){
            console.log(filterValue);
            location.href = "{{route('exchange.ads')}}"+"?order_by="+filterValue;

        }

        function getSelectValue(selectorId) {
            var selectedIndex = document.getElementById(selectorId).selectedIndex;
            var selectedValue = document.getElementById(selectorId).options[selectedIndex].value;
            return selectedValue;
        }

    </script>

    {!! $dataTableHtml->scripts(attributes: ['type' => 'module']) !!}

    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>

@endsection
