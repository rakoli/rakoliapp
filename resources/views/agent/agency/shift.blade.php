@extends('layouts.users.agent')

@section('title', "Shift")

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
    <div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
        <!--begin::Container-->
        <div class="container d-flex flex-column flex-lg-row" id="kt_docs_content_container">
            <!--begin::Card-->
            <div class="card card-docs flex-row-fluid mb-2" id="kt_docs_content_card">
                <!--begin::Card Body-->
                <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack mb-5">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            {{--<i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span
                                    class="path1"></span><span class="path2"></span></i>
                            <x-input type="text" data-kt-docs-table-filter="search"
                                     class="fform-control-solid w-250px ps-15" placeholder="Search Shits"/>--}}
                        </div>
                        <!--end::Search-->



                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">


                            <!--begin::Add customer-->
                            <x-modal_with_button
                                targetId="openShift"
                                label="Open Shift"
                                modalTitle="Fill the form below to open a new shift"
                                isStacked="true"
                            >

                                @include('agent.agency._shift.open-shift')


                            </x-modal_with_button>

                           <div class="mx-6">
                               <x-modal_with_button
                                   targetId="closeShift"
                                   label="Close Shift"
                                   modalTitle="Fill the form below to close shift"
                               >

                                 <livewire:shift.close-shift/>


                               </x-modal_with_button>
                           </div>
                        </div>
                        <!--end::Toolbar-->

                    </div>
                    <!--end::Wrapper-->



                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4 align-middle fw-bold' , 'id' => 'shift-table'],true) !!}


                </div>
            </div>
        </div>
    </div>

    @push('js')

        <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
                type="text/javascript"></script>
        {{ $dataTableHtml->scripts()  }}

        <script>
            $(document).ready(function () {
                window.LaravelDataTables['shift-table'].on('draw', function () {
                    KTMenu.createInstances();
                });
            });
        </script>

    @endpush

@endsection



