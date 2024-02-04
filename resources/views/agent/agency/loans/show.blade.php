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


    <div id="kt_app_content_container" class="app-container  container-xxl ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-50 w-xl-300px">

                @include('agent.agency.shift._user_card')

            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid px-lg-4">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>{{ __('Loans') }}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->


                    <div class="px-lg-4">

                        @if($shift->status == \App\Utils\Enums\ShiftStatusEnum::OPEN)
                            <div class="d-flex flex-lg-row gap-4 py-md-6">


                                <x-modal_with_button
                                    btnClass="btn btn-instagram"
                                    targetId="add-loan"
                                    label="{{ __('Add Loans') }}"
                                    modalTitle="{{ __('Fill the form below record a Loan') }}"

                                >

                                    @include('agent.agency.loans.add-loan')


                                </x-modal_with_button>

                                <x-a-button class="btn btn-outline-danger btn-google text-white" route="{{ route('agency.shift.close', $shift) }}">Close Shift</x-a-button>

                            </div>
                        @endif


                    </div>


                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                        <!--begin::Table-->
                        <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">


                                {!! $datatableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4 align-middle fw-bold' , 'id' => 'loans-payment-table']) !!}


                            </div>

                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>



    <div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">

        <!--begin::Container-->
        <div class="container d-flex flex-column flex-lg-row" id="kt_docs_content_container">


            <!--begin::Card-->
            <div class="card card-docs flex-row-fluid mb-2" id="kt_docs_content_card">
                <!--begin::Card Body-->
                <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-8 text-gray-700">
                    <div class="d-flex flex-lg-row gap-lg-4 pb-md-8 pb-sm-6">
                        <div class=" d-flex flex-column flex-lg-row gap-lg-3" >
                            <x-a-button
                                    route="#"
                                    class="btn-light-success btn-active-color-dark"
                                    label="Loan Amount: {{ money($loan->amount , currencyCode(), true)  }}">

                            </x-a-button>
                            <x-a-button
                                    route="#"
                                    class="btn-light-primary btn-active-color-dark"
                                    label="Loan Balance: {{ money($loan->balance , currencyCode(), true)  }}">

                            </x-a-button>
                        </div>

                        <x-modal_with_button
                            btnClass="btn btn-light-facebook"
                                targetId="receive-loan-payment"
                                label="Receive Payment"
                                modalTitle="Fill the form below record Loan payment"
                                isStacked="true"
                        >

                            @include('agent.agency.shift.pay-loan')


                        </x-modal_with_button>

                    </div>


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


            $(document).ready(function () {

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
