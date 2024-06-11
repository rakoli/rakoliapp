@extends('layouts.users.agent')

@section('title', "Loans")

@push('styles')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')


    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.agency._submenu_agency')


        <!--begin::Table-->
        <div class="card card-flush mt-6 mt-xl-9">

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Wrapper-->
                <div class="d-flex flex-stack">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        {{--<i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span
                                class="path1"></span><span class="path2"></span></i>
                        <x-input type="text" data-kt-docs-table-filter="search"
                                 class="fform-control-solid w-250px ps-15" placeholder="Search Shits"/>--}}
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Table container-->
                <div class="table-responsive">

                    {!! $datatableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4' , 'id' => 'loans-table']) !!}

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
    <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
            type="text/javascript"></script>
    {{ $datatableHtml->scripts()  }}

    <script>


        $(document).ready(function () {

            window.LaravelDataTables['loans-table'].on('draw', function () {
                KTMenu.createInstances();
            })
        })


        // // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        // dt.on('draw', function () {
        //     KTMenu.createInstances();
        // });
    </script>
@endsection
