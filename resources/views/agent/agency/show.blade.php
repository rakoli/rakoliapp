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

    <div id="kt_app_content_container" class="app-container  container-xxl ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">

                @include('agent.agency.shift._user_card')

            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">


                @if($shift->status == \App\Utils\Enums\ShiftStatusEnum::OPEN)
                    <div class="d-flex gap-4 py-md-6">
                        <x-back :route="route('agency.shift')" class="py-md-4"/>

                        <x-modal_with_button
                            targetId="add-transaction"
                            label="Add Cash Transaction"
                            modalTitle="Fill the form below record a transaction"
                            btnClass="btn btn-facebook"
                        >

                            @include('agent.agency.transaction.add-transaction')


                        </x-modal_with_button>

                        <x-modal_with_button
                            targetId="add-expenses"
                            label="Add Expenses"
                            modalTitle="Fill the form below record a Expenses"
                            btnClass="btn btn-youtube"
                        >

                            @include('agent.agency.transaction.add-expense')


                        </x-modal_with_button>

                        <x-modal_with_button
                            targetId="add-income"
                            label="Add Income"
                            modalTitle="Fill the form below record a income"
                        >

                            @include('agent.agency.transaction.add-income')


                        </x-modal_with_button>

                        <x-modal_with_button
                            btnClass="btn btn-instagram"
                            targetId="add-loan"
                            label="Add Loan"
                            modalTitle="Fill the form below record a Loan"

                        >

                            @include('agent.agency.loans.add-loan')


                        </x-modal_with_button>

                        <x-a-button class="btn btn-outline-danger btn-google text-white" route="{{ route('agency.shift.close', $shift) }}">Close Shift</x-a-button>

                    </div>
                @endif


                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Transaction History</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                        <!--begin::Table-->
                        <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">


                                {!! $dataTableHtml->table(['class' => 'table align-middle table-row-dashed gy-5 dataTable no-footer' , 'id' => 'transaction-table'],true) !!}

                            </div>

                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

                <!--begin::Loans-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Shift Loans</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                        <!--begin::Table-->
                        <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">


                                <table class="table align-middle table-row-dashed gy-5 dataTable no-footer"
                                       id="shift-loan-table">
                                    <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Agency</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($loans as $loan)
                                        <tr>
                                            <td>{{ $loan->user->full_name }}</td>
                                            <td>{{ $loan->network?->agency?->name }}</td>
                                            <td>
                                                <span class="{{ str($loan->status->color())->toHtmlString()  }}">
                                                {{ str($loan->status->label())->toHtmlString() }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="{{ str($loan->type->color())->toHtmlString()  }}">
                                                {{ str($loan->type->label())->toHtmlString() }}
                                                </span>
                                            </td>

                                            <td>{{ money(amount: $loan->amount, convert: true, currency: currencyCode()) }}</td>
                                            <td>{{ money(amount: $loan->paid ?? 0, convert: true, currency: currencyCode()) }}</td>
                                            <td>{{ money(amount: $loan->balance, convert: true, currency: currencyCode()) }}</td>


                                            <td class="pe-0 text-end">
                                                <a href="#" class="btn btn-sm btn-light image.png btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                                </a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3" id="loan-{{ $loan->id }}">
                                                        <x-modal_with_button
                                                            btnClass="menu-link px-3"
                                                            targetId="view-description-{{ $loan->id }}"
                                                            label="view Description"
                                                            modalTitle=" Description and Notes"
                                                        >

                                                            <div class="pb-5 fs-6">
                                                                <!--begin::Details item-->
                                                                <div
                                                                    class="d-flex flex-row gap-14 mt-5 justify-content-lg-between">
                                                                    <span>Description</span>
                                                                    <span> {{ str($loan->description)->toHtmlString() }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="pb-5 fs-6">
                                                                <!--begin::Details item-->
                                                                <div
                                                                    class="d-flex flex-row gap-14 mt-5 justify-content-lg-between">
                                                                    <span>Notes</span>
                                                                    <span> {{ str($loan->note)->toHtmlString() }}</span>
                                                                </div>
                                                            </div>

                                                        </x-modal_with_button>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">

                                                        <a
                                                            href="{{ route('agency.loans.show', ['shift' => $shift , 'loan' => $loan]), }}"
                                                            class="menu-link px-3"
                                                        >Statement</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            </td>


                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

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





    @push('js')
        <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

        <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
                type="text/javascript"></script>
        {{ $dataTableHtml->scripts()  }}



        <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

        <script>
            $(document).ready(function () {


                window.LaravelDataTables['transaction-table'].on('draw', function () {
                    KTMenu.createInstances();
                })


                $("table#shift-loan-table").DataTable({
                    sort: false,
                    perPage: 2
                })
            })
        </script>

    @endpush
@endsection
