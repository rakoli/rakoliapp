@extends('layouts.users.agent')

@section('title', "Loans Payment")


@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Loans</small>
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


                    <x-modal_with_button
                        targetId="receive-loan-payment"
                        label="Receive Payment"
                        modalTitle="Fill the form below record Loan payment"
                        isStacked="true"
                    >

                        <livewire:shift.pay-loan :loan="$loan" lazy/>


                    </x-modal_with_button>



                    {!! $datatableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4 align-middle fw-bold' , 'id' => 'loans-payment-table']) !!}






                </div>
            </div>
        </div>
    </div>


    @push('js')


        <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
                type="text/javascript"></script>
        {{ $datatableHtml->scripts()  }}

        <script>


            $(document).ready(function (){

                window.LaravelDataTables['loans-payment-table'].on('draw', function () {
                    KTMenu.createInstances();
                })
            })



            // // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            // dt.on('draw', function () {
            //     KTMenu.createInstances();
            // });
        </script>

    @endpush

@endsection
