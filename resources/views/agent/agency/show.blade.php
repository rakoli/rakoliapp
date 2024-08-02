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


        <!--begin::Row-->
        <div class="row gy-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-xl-12">
                <!--begin::Row-->
                <div class="row g-lg-5 g-xl-10">

                    <!--begin::Col-->
                    <div class="col-md-3 col-xl-3 mb-md-5 mb-xl-5">
                        <!--begin::Card widget-->
                        <div class="card bg-primary">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" data-kt-countup="true"
                                          data-kt-countup-value="{{ number_format($cashAtHand , 2) }}"
                                          data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">{{ number_format($cashAtHand , 2) }}</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-white pt-1 fw-semibold fs-6">{{ __('Cash at Hand') }} in {{currencyCode()}}</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                        <!--end::Card widget-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-md-3 col-xl-3 mb-md-5 mb-xl-5">
                        <!--begin::Card widget-->
                        <div class="card bg-primary">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" data-kt-countup="true"
                                          data-kt-countup-value="{{ number_format($tillBalances , 2) }}"
                                          data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">{{ number_format($tillBalances , 2) }}</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-white pt-1 fw-semibold fs-6">{{ __('Total Till Balances') }} in {{currencyCode()}}</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                        <!--end::Card widget-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-md-3 col-xl-3 mb-md-5 mb-xl-5">
                        <!--begin::Card widget-->
                        <div class="card bg-primary">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"  data-kt-countup="true"
                                          data-kt-countup-value="{{ number_format($income , 2) }}"
                                          data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">{{number_format($income , 2)}}</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-white pt-1 fw-semibold fs-6">{{ __('Cash IN') }} in {{currencyCode()}}</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                        <!--end::Card widget-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-md-3 col-xl-3 mb-md-5 mb-xl-5">
                        <!--begin::Card widget-->
                        <div class="card bg-primary">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"  data-kt-countup="true"
                                          data-kt-countup-value="{{ number_format($expenses , 2) }}"
                                          data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">-{{number_format($expenses , 2)}}</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-white pt-1 fw-semibold fs-6">{{ __('Cash OUT') }} in {{currencyCode()}}</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                        <!--end::Card widget-->
                    </div>
                    <!--end::Col-->

                </div>
                <!--end::Row-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->


        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">

                @include('agent.agency.shift._user_card')

            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Till Transaction History</h2>
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


                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Crypto Transaction History</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                        <!--begin::Table-->
                        <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <table id="crypto-transaction-table" class="table align-middle table-row-dashed gy-5 dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Old Balance {{ strtoupper(session('currency')) }}</th>
                                            <th>Amount Transacted {{ strtoupper(session('currency')) }}</th>
                                            <th>New Balance</th>
                                            <th>Network</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Cash Transaction History</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                        <!--begin::Table-->
                        <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <table id="cash-transaction-table" class="table align-middle table-row-dashed gy-5 dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Old Balance {{ strtoupper(session('currency')) }}</th>
                                            <th>Amount Transacted {{ strtoupper(session('currency')) }}</th>
                                            <th>New Balance</th>
                                            <th>Network</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                </table>
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
                                            <td>{{ $loan->network?->agency?->name ?? 'Cash' }}</td>
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

        <script>
            $(document).ready(function () {

                datatable = $('#cash-transaction-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    lengthMenu: [[10, 50, 100, -1], [10, 50, 100,  'All']],
                    pageLength: 10,
                    aaSorting: [6, 'DESC'],
                    ajax: {
                        url: "{{ route('agency.shift.show',$shift->id) }}",
                        type: "POST",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: function(data) {
                            data.isCash = true;
                        },
                    },
                    columnDefs: [
                        {
                            targets: [0], // first column & numbering column
                            orderable: false, // set not orderable
                        },
                        {
                            targets: [6], // column index
                            visible: false,
                        }
                    ],
                    columns: [
                        {
                            data: 'user_name',
                            name: 'user_name'
                        },
                        {
                            data: 'balance_old',
                            name: 'balance_old'
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            data: 'balance_new',
                            name: 'balance_new'
                        },
                        {
                            data: 'network_name',
                            name: 'network_name'
                        },
                        {
                            data: 'transaction_type',
                            name: 'transaction_type'
                        },
                        {
                            data: 'id',
                            name: 'id'
                        }
                    ],
                });

                datatable1 = $('#crypto-transaction-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    lengthMenu: [[10, 50, 100, -1], [10, 50, 100,  'All']],
                    pageLength: 10,
                    aaSorting: [6, 'DESC'],
                    ajax: {
                        url: "{{ route('agency.shift.show',$shift->id) }}",
                        type: "POST",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: function(data) {
                            data.isCrypto = true;
                        },
                    },
                    columnDefs: [
                        {
                            targets: [0], // first column & numbering column
                            orderable: false, // set not orderable
                        },
                        {
                            targets: [6], // column index
                            visible: false,
                        }
                    ],
                    columns: [
                        {
                            data: 'user_name',
                            name: 'user_name'
                        },
                        {
                            data: 'balance_old',
                            name: 'balance_old'
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            data: 'balance_new',
                            name: 'balance_new'
                        },
                        {
                            data: 'network_name',
                            name: 'network_name'
                        },
                        {
                            data: 'transaction_type',
                            name: 'transaction_type'
                        },
                        {
                            data: 'id',
                            name: 'id'
                        }
                    ],
                });


                $("table#shift-loan-table").DataTable({
                    sort: false,
                    responsive: true,
                    perPage: 2
                })

                $('.modal').on('hidden.bs.modal', function () {
                    $(this).find('form').trigger('reset');
                });
            })
        </script>

    @endpush
@endsection
