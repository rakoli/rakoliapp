@extends('layouts.users.agent')

@section('title', "Networks")

@push('styles')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Agency</small>

    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>

    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Manage</small>
    <!--end::Description-->
@endsection

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
                    <x-modal_with_button
                        targetId="add-network"
                        label="Add Network"
                        modalTitle="Fill the form below record a network"
                        isStacked="true"
                    >

                        @include('agent.agency.network.add-network')


                    </x-modal_with_button>
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

                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4' , 'id' => 'network-table'],true) !!}

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

    <script>
        $(document).ready(function (){

            window.LaravelDataTables['network-table'].on('draw', function () {
                KTMenu.createInstances();
            })
        })
    </script>
@endsection
