@extends('layouts.users.agent')

@section('title', "Transactions")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Agency</small>
    <!--end::Description-->
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.agency._submenu_agency')


        <!--begin::Table-->
        <div class="card card-flush mt-6 mt-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-5">
                <!--begin::Card toolbar-->
                <div class="card-toolbar my-1">

                </div>
                <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table container-->
                <div class="table-responsive">

                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4' , 'id' => 'transaction-table'],true) !!}

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
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
            type="text/javascript"></script>
    {{ $dataTableHtml->scripts()  }}

    <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

    <script>
        $(document).ready(function () {


            window.LaravelDataTables['transaction-table'].on('draw', function () {
                KTMenu.createInstances();
            })
        })
    </script>
@endsection
