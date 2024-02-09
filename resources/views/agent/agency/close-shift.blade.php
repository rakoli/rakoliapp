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

        <form method="post" id="close-shift" action="{{ route('agency.shift.close.store') }}">
            @csrf

            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-80 w-xl-700px mb-10">
                    <div class="card mb-5">

                        <div class="card-body">
                            <h4 id="starting-capital" class="py-sm-4 py-md-12 px-md-4 bg-light-success"
                                data-starting-capital="{{ $startCapital }}">{{ __('Total Starting Capital') }}
                                : {{ Number::currency($startCapital, currencyCode()) }}</h4>
                            <h4 class="py-sm-4 py-md-13 px-md-4 bg-light-primary">{{ __('Total Ending Capital') }}
                                : {{ Number::currency($endCapital , currencyCode()) }}</h4>


                            <table class="table table-borderless table-responsive" id="shift-loans-summary">
                                <thead>
                                <tr>
                                    <th class="fw-bolder">Till</th>
                                    <th class="fw-bolder">{{ __('End Balance') }}</th>
                                    <th class="fw-bolder">{{ __('Confirm Closing Balances') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{  __("Cash at Hand") }}</td>

                                    <td>{{  Number::currency($cashAtHand,  currencyCode())}}</td>
                                    <td>
                                        <x-input
                                            type="number"
                                            class="form-control-solid fa-money-bill-transfer
                                            @error('closing_balance') form-control-feedback @enderror"
                                            name="closing_balance"
                                            value="{{ $cashAtHand }}"
                                            placeholder="{{ __('Closing Balance') }}" id="closing_balance"/>
                                    </td>
                                </tr>

                                @foreach($networks as  $name  => $network)
                                    <tr>
                                        <td class="fs-sm">{{  __($name) }}</td>
                                        <td class="fs-sm">
                                            {{  Number::currency($network['balance'],  currencyCode())}}</td>
                                        <td class="fs-sm">
                                            <x-input
                                                type="number"
                                                class="form-control-solid network-balance"
                                                name="tills[{{ $network['code'] }}]"
                                                value="{{ $network['balance'] }}"
                                                placeholder="{{ $network['balance'] }}"
                                                id="{{ $network['code'] }}
                                            "/>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td>{{  __("Expenses") }}</td>

                                    <td>: {{  Number::currency($expenses,  currencyCode())}}</td>
                                    <td class="fs-sm">
                                        <x-input
                                            type="number"
                                            class="form-control-solid network-balance"
                                            name="expenses"
                                            value="{{ $expenses }}"
                                            placeholder="expenses"
                                            id="expenses"
                                        />
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{  __("Income") }}</td>

                                    <td>: {{  Number::currency($income,  currencyCode())}}</td>
                                    <td class="fs-sm">
                                        <x-input
                                            type="number"
                                            class="form-control-solid network-balance"
                                            name="income"
                                            value="{{ $income }}"
                                            placeholder="income"
                                            id="income"
                                        />
                                    </td>
                                </tr>


                                </tbody>
                                <tfoot>
                                <tr>
                                    <td>{{  __("Subtotal") }}</td>

                                    <td class="fw-bolder">
                                        {{  Number::currency(  $totalBalance - $income,  currencyCode())}}</td>
                                </tr>
                                <tr>
                                    <td>{{  __("Total") }}</td>

                                    <td class="fw-bolder">
                                        <span
                                            id="total_balance">  {{  Number::currency(  $totalBalance - $income,  currencyCode())}} </span>

                                    </td>
                                </tr>
                                <tr>
                                    <td>{{  __("Shorts") }}</td>

                                    <td class="fw-bolder">

                                        <span id="total_shorts">
                                            {{  Number::currency(  $shorts,  currencyCode()) }}
                                        </span>
                                        <x-input
                                            type="hidden"
                                            readonly="readonly"
                                            class="total_shorts_input"
                                            name="total_shorts"
                                        />

                                </tr>

                                <tr>
                                    <td class="fw-bolder">{{  __("Total Income") }}</td>

                                    <td class="fw-bolder"> {{  Number::currency($income,  currencyCode())}}</td>
                                </tr>
                                </tfoot>
                            </table>


                            <div class="row fv-row py-3" id="has_short">
                                <div class="">
                                    <x-label
                                        label="Short Description"
                                        for="short_description"/>

                                    <textarea
                                        name="short_description"
                                        class="form-control form-control form-control-solid"
                                        rows="3"
                                        data-kt-autosize="false"></textarea>
                                    @error('short_description')
                                    <div class="help-block text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>


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
                            <div id="kt_table_customers_payment_wrapper"
                                 class="dataTables_wrapper dt-bootstrap4 no-footer">
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
                            <div id="kt_table_customers_payment_wrapper"
                                 class="dataTables_wrapper dt-bootstrap4 no-footer">
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
                            <div id="kt_table_customers_payment_wrapper"
                                 class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="table-responsive">


                                    <table class="table align-middle table-row-dashed gy-5 dataTable no-footer"
                                           id="shift-shorts-table">

                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Till</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($shift->shorts as $short)
                                            <tr>
                                                <td>{{ $short->type }}</td>
                                                <td>{{ $short->network?->agency?->name }}</td>
                                                <td>{{ $short->amount }}</td>
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
        </form>
    </div>



    @push('js')
        <script>

            $(document).ready(() => {
                $("div#has_short").hide();
                $("div#shift_network_code").hide();

                function calculateTotal() {
                    var total = parseFloat(document.getElementById('closing_balance').value);

                    // Loop through each network balance input field
                    var networkInputs = document.querySelectorAll('.network-balance');
                    networkInputs.forEach(function (input) {
                        total += parseFloat(input.value);
                    });

                    // Display the total in some element (you can adjust this based on your needs)
                    document.getElementById('total_balance').innerText = total.toLocaleString('en-US', {maximumFractionDigits: 2});

                    let startingCapital = $("h4#starting-capital").data('starting-capital')

                    let totalShort = (parseFloat(startingCapital) - total);


                    document.getElementById('total_shorts').innerText = totalShort.toLocaleString('en-US', {maximumFractionDigits: 2});

                    $("input.total_shorts_input").val(totalShort)

                    if (totalShort > 0) {
                        $("div#has_short").show();
                        $("div.shift-has-shorts").show();
                    } else {
                        $("div#has_short").hide();
                        $("div.shift-has-shorts").hide();
                    }

                }


                // Attach event listeners to input fields
                document.getElementById('closing_balance').addEventListener('change', calculateTotal);

                var networkInputs = document.querySelectorAll('.network-balance');
                networkInputs.forEach(function (input) {
                    input.addEventListener('change', calculateTotal);
                });

                // Initial calculation on page load
                calculateTotal();



                $("select#select_shift_type").on('change', () => {

                    var selectElement = document.getElementById("select_shift_type");

                    // Get the selected option
                    var selectedOption = selectElement.options[selectElement.selectedIndex];

                    // Get the value of the selected option
                    var selectedValue = selectedOption.value;

                    if(selectedValue == "TILL")
                    {
                        $("div#shift_network_code").show();
                    }
                    else{
                        $("div#shift_network_code").hide();
                    }


                })

            })
        </script>

    @endpush

@endsection



