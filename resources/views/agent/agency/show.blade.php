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

                        @include('agent.agency._shift._user_card', ['user' => $shift->user])

                        <!--begin::Card-->

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
                                                {!! $dataTableHtml->table(['class' => 'table align-middle table-row-dashed fs-6 fw-bold gy-5 dataTable no-footer' , 'id' => 'transaction-table'],true) !!}

                                            </div>

                                        </div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->


                            </div>
                            <!--end:::Tab pane-->


                            <div class="card pt-2 mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Networks</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Tab Content-->
                                    <div id="" class="tab-content">
                                        <!--begin::Tab panel-->
                                        <div id="kt_customer_details_invoices_1" class="py-0 tab-pane fade show active"
                                             role="tabpanel" aria-labelledby="kt_referrals_year_tab">
                                            <!--begin::Table-->
                                            <div id="kt_customer_details_invoices_table_1_wrapper"
                                                 class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <div class="table-responsive">
                                                    <table id="kt_customer_details_invoices_table_1"
                                                           class="table align-middle table-row-dashed fs-6 fw-bold gy-5 dataTable no-footer">
                                                        <thead
                                                            class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                        <tr class="text-start text-muted gs-0">
                                                            <th class="min-w-100px sorting" tabindex="0"
                                                                aria-controls="kt_customer_details_invoices_table_1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Order ID: activate to sort column ascending"
                                                                style="width: 119.35px;">Network
                                                            </th>
                                                            <th class="min-w-100px sorting" tabindex="0"
                                                                aria-controls="kt_customer_details_invoices_table_1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Amount: activate to sort column ascending"
                                                                style="width: 121.238px;">{{ __('Balance old') }}
                                                            </th>
                                                            <th class="min-w-100px sorting" tabindex="0"
                                                                aria-controls="kt_customer_details_invoices_table_1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Status: activate to sort column ascending"
                                                                style="width: 121.238px;">{{ __('Balance New') }}
                                                            </th>

                                                        </tr>
                                                        </thead>
                                                        <tbody class="fs-6 fw-semibold text-gray-600">

                                                        @foreach($tills as $network)
                                                            <tr class="odd">
                                                                <td data-order="Invalid date">{{ $network->network->agency->name }}</td>
                                                                <td class="text-success">{{{ money(amount: $network->balance_old, currency: currencyCode(),convert: true) }}}</td>
                                                                <td class="text-primary">{{{ money(amount: $network->balance_new, currency: currencyCode(),convert: true) }}}</td>


                                                            </tr>
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Tab panel-->
                                        <!--end::Tab panel-->
                                    </div>
                                    <!--end::Tab Content-->
                                </div>
                                <!--end::Card body-->
                            </div>

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
