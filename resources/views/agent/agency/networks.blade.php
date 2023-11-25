@extends('layouts.users.agent')

@section('title', "Networks")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
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

                        </div>
                        <!--end::Search-->

                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end gap-2" data-kt-docs-table-toolbar="base">
                            <!--begin::Filter-->

                            <!--end::Filter-->

                            <!--begin::Add customer-->
                            <x-modal
                                targetId="add-network"
                                label="Add Network"
                                modalTitle="Fill the form below record a network"
                                isStacked="true"
                            >

                                <livewire:transaction.add-transaction lazy />


                            </x-modal>


                        </div>
                        <!--end::Toolbar-->

                    </div>
                    <!--end::Wrapper-->


                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4 align-middle fw-bold' , 'id' => 'network-table'],true) !!}



                </div>
            </div>
        </div>
    </div>

    @push('js')


        <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
                type="text/javascript"></script>
        {{ $dataTableHtml->scripts()  }}


    @endpush
@endsection
