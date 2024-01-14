@extends('layouts.users.agent')

@section('title', "Show Shift")

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

    <div class="d-flex flex-column flex-column-fluid">


        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">


            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">

                        <!--begin::Card-->
                        <div class="card mb-5 mb-xl-8">

                            <h3 class="card-title align-items-start flex-column px-6 py-6">
                                <!--begin::Statistics-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Currency-->
                                    <span
                                        class="fs-3 fw-semibold text-gray-500 align-self-start me-1">{{ currencyCode() }}</span>
                                    <!--end::Currency-->

                                    <!--begin::Value-->
                                    <span
                                        class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format($shift->cash_end, 2) }}</span>
                                    <!--end::Value-->


                                    <!--end::Label-->
                                </div>
                                <!--end::Statistics-->

                                <!--begin::Description-->
                                <span class="fs-6 fw-semibold text-gray-500">Cash Balance</span>
                                <!--end::Description-->
                            </h3>
                            <!--begin::Card body-->
                            <div class="card-body pt-15">


                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                         href="#kt_customer_view_details" role="button" aria-expanded="false"
                                         aria-controls="kt_customer_view_details">
                                        Details
                                        <span class="ms-2 rotate-180">

                                            <i class="ki-duotone ki-down fs-3"></i>
                                        </span>
                                    </div>
                                </div>
                                <!--end::Details toggle-->

                                <div class="separator separator-dashed my-3"></div>

                                <!--begin::Details content-->
                                <div id="kt_customer_view_details" class="collapse show">
                                    <div class="py-5 fs-6">

                                        @foreach($tills as  $network)
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5 border-bottom-2 border-primary">Network</div>
                                            <div class="text-gray-600">{{ $network->network->agency->name }}</div>
                                            <!--begin::Details item-->

                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Balance</div>
                                            <div
                                                class="text-gray-600">{{ money(amount: $network->balance_new ,currency: currencyCode(), convert: true)  }}

                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                                <!--end::Details content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->

                    </div>
                    <!--end::Sidebar-->

                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">


                        <!--begin:::Tab content-->
                        <div class="tab-content" id="myTabContent">
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Transaction Records</h2>
                                        </div>
                                        <!--end::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar d-flex flex-row g-6">

                                            <div class="d-flex justify-content-end gap-2"
                                                 data-kt-docs-table-toolbar="base">
                                                <x-modal_with_button
                                                    targetId="add-transaction"
                                                    label="Add Transaction"
                                                    modalTitle="Fill the form below record a transaction"
                                                    isStacked="true"
                                                >

                                                    @include('agent.agency.transaction.add-transaction')


                                                </x-modal_with_button>

                                                <x-modal_with_button
                                                    targetId="add-expenses"
                                                    label="Add Expenses"
                                                    modalTitle="Fill the form below record a Expenses"
                                                    isStacked="true"
                                                >

                                                    @include('agent.agency.transaction.add-expense')


                                                </x-modal_with_button>
                                                <x-modal_with_button
                                                    targetId="add-income"
                                                    label="Add Income"
                                                    modalTitle="Fill the form below record a income"
                                                    isStacked="true"
                                                >

                                                    @include('agent.agency.transaction.add-income')


                                                </x-modal_with_button>
                                            </div>

                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-0 pb-5">
                                        <!--begin::Table-->
                                        <div id="kt_table_customers_payment_wrapper"
                                             class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="table-responsive">
                                                {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4 align-middle fw-bold table align-middle gs-0 gy-4' , 'id' => 'transaction-table'],true) !!}

                                            </div>

                                        </div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->


                            </div>
                            <!--end:::Tab pane-->

                        </div>
                        <!--end:::Tab content-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->

                <!--end::Content container-->
            </div>
            <!--end::Content-->

        </div>


        @push('js')

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

    @endpush
@endsection
