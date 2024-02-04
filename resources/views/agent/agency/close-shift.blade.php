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
                        @include('agent.agency.shift.close-shift')
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

                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap">

                                    <!--begin::Stat-->
                                    <div class="border border-gray-300 border-dashed rounded min-w-325px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">

                                            <div class="fs-4qx fw-normal counted text-success" data-kt-countup="true"
                                                 data-kt-countup-value="{{ number_format($totalBalance ?? 0 , 2) }}"
                                                 data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">
                                                <span class="">   {{ Illuminate\Support\Number::abbreviate($totalBalance ?? 0 ,3) }}</span>
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6  text-success-emphasis">{{ __('Total Balances') }}</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">

                                            <div class="fs-2 fw-bolder counted fs-3qx " data-kt-countup="true"
                                                 data-kt-countup-value="{{ number_format($shift->cash_end , 2) }}"
                                                 data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">
                                                {{ Illuminate\Support\Number::abbreviate($shift->cash_end , 3) }}
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div class="fw-semibold fw-bolder  fs-6 text-gray-500">{{ __('Cash at Hand') }}</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->


                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Stats-->

                        <!--begin::Table-->
                        <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">

                                <table class="table table-borderless" id="shift-loans-summary">
                                    <thead>
                                    <tr>
                                        <th>Till</th>
                                        <th>{{ __('Start Balance') }}</th>
                                        <th>{{ __('End Balance') }}</th>
                                        <th>{{ __('') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tills as $till)
                                        <tr>
                                            <td>{{  __($till->network?->agency?->name) }}</td>
                                            <td>{{  Number::currency($till->balance_old,  currencyCode())}}</td>
                                            <td>{{  Number::currency($till->balance_new,  currencyCode())}}</td>
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



