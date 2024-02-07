@extends('layouts.users.agent')

@section('title', "Close Shift")

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">
        <a href="{{ route('agency.shift.show', $shift) }}">Shift</a>
    </small>

    <!--end::Description-->
@endsection

@section('content')

    <div id="kt_app_content_container" class="app-container  container-xxl ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <div class="card mb-5 mb-xl-8">

                    <div class="card-body">
                        @include('agent.agency.shift.close_shift_form')
                    </div>
                </div>

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
                            <h2>{{ __('Tills Transaction Summary') }}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">

                        <!--begin::Table-->
                        <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">

                                <table class="table table-borderless" id="shift-loans-summary">
                                    <thead>
                                    <tr>
                                        <th class="fw-bolder">Till</th>
                                        <th class="fw-bolder">{{ __('Starting Balance') }}</th>
                                        <th class="fw-bolder">{{ __('End Balance') }}</th>
                                        <th class="fw-bolder">{{ __('Transacted Amount') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{  __("Starting Cash") }}</td>

                                        <td>{{  Number::currency($shift->cash_start,  currencyCode())}}</td>
                                        <td>{{  Number::currency($cashAtHand,  currencyCode())}}</td>
                                        <td>{{  Number::currency( abs($shift->cash_start - $cashAtHand),  currencyCode())}}</td>
                                    </tr>

                                    @foreach($networks as  $name  => $network)
                                        <tr>
                                            <td>{{  __($name) }}</td>

                                            <td>{{  Number::currency($network['balance_old'],  currencyCode())}}</td>
                                            <td>{{  Number::currency($network['balance'],  currencyCode())}}</td>
                                            <td>{{  Number::currency(abs($network['balance_old'] - $network['balance']),  currencyCode())}}</td>
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

                <!--begin::Loans-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Shift Loans Summary</h2>
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

                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($loans as $type => $loan)
                                        <tr>
                                            <td>{{ $type }}</td>
                                            <td>{{ Number::currency($loan->sum('amount'), currencyCode()) }}</td>
                                            <td>{{ Number::currency($loan->sum('paid'), currencyCode()) }}</td>
                                            <td>{{ Number::currency($loan->sum('balance'), currencyCode()) }}</td>

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
                <!--begin::Loans-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Shorts Summary</h2>
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
                                       id="shift-shorts-table">

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


    @endpush

@endsection



