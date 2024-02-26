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

        <form method="post" id="close-shift">
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
                            <div id="loans-balances" data-loans-balance="{{ $loanBalances }}"></div>


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
                                            class="form-control-solid fa-money-bill-transfer closing-cash"
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
                                                data-name="tills-{{ $network['code'] }}"
                                                class="form-control-solid network-balance tills-{{ $network['code'] }}"
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
                                            class="form-control-solid expenses"
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
                                            class="form-control-solid"
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
                                        <x-helpertext>
                                            <ul class="list-style-none">
                                                <li>  {{ __('- ve value means you have excess closing capital') }}</li>
                                                <li>  {{ __(' +ve value means you have short in your closing capital') }}</li>
                                            </ul>
                                        </x-helpertext>

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

                    <!--begin::Tills Summary Card -->
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
                                    @php $transacted = abs($shift->cash_start - $cashAtHand);  $totals = 0; @endphp

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
                                            <td  class="fw-bolder">
                                                <span id="cash"  class="ending-balance">
                                                    {{  Number::currency($cashAtHand,  currencyCode())}}
                                                </span>
                                            </td>
                                            <td>{{  Number::currency(  abs($shift->cash_start - $cashAtHand),  currencyCode())}}</td>
                                        </tr>

                                        @foreach($networks as  $name  => $network)
                                            @php  $transacted += abs($network['balance_old'] - $network['balance']);

                                            @endphp
                                            <tr>
                                                <td>{{  __($name) }}</td>

                                                <td>{{  Number::currency($network['balance_old'],  currencyCode())}}</td>
                                                <td class="fw-bolder">
                                                    <span
                                                        class="tills-{{ $network['code']}} ending-balance">
                                                          {{  Number::currency($network['balance'],  currencyCode())}}
                                                    </span>

                                                </td>
                                                <td>{{   Number::currency(abs(($network['balance_old'] - $network['balance'])),  currencyCode())   }}</td>
                                            </tr>
                                        @endforeach

                                        <tr class="fw-bold" style="border-top: 1px  dotted; border-bottom: 1px  dotted">
                                            <td class=""> {{ __('Subtotal') }}</td>
                                            <td class="border-dashed">{{ \Illuminate\Support\Number::currency($shift->cash_start + collect($networks)->sum('balance_old'), currencyCode()) }}</td>
                                            <td class="fw-bold border-dashed">
                                                <span id="total-subtotal">
                                                     {{ \Illuminate\Support\Number::currency( $totals += $cashAtHand + collect($networks)->sum('balance'), currencyCode()) }}
                                                </span>
                                            </td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency($transacted, currencyCode()) }}</td>

                                        </tr>

                                        <tr class="border-1">
                                            <td class=""> {{ __('Total loans') }}</td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency(0, currencyCode()) }}</td>
                                            <td class="fw-bolder border-dashed">
                                                <span class="ending-balance">
                                                {{ \Illuminate\Support\Number::currency($loanBalances, currencyCode()) }}
                                                </span>
                                            </td>
                                            <td class="border-dashed">{{ \Illuminate\Support\Number::currency($shift->loans->sum('amount'), currencyCode()) }}</td>

                                        </tr>
                                        <tr class="border-1">
                                            <td class="border-top-1"> {{ __('Total Incomes') }}</td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency(0, currencyCode()) }}</td>
                                            <td class="fw-bolder border-dashed">
                                                <span class="ending-balance income">
                                                    {{ \Illuminate\Support\Number::currency($income, currencyCode()) }}
                                                </span>
                                            </td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency($income, currencyCode()) }}</td>

                                        </tr>

                                        <tr class="border-1">
                                            <td class="border-top-1"> {{ __('Total Expenses') }}</td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency(0, currencyCode()) }}</td>
                                            <td class="fw-bolder border-dashed">
                                                <span class="ending-balance expenses">
                                                    {{ \Illuminate\Support\Number::currency($expenses, currencyCode()) }}
                                                </span>
                                            </td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency($expenses, currencyCode()) }}</td>

                                        </tr>



                                        <tr class="border-1">
                                            <td class="border-top-1"> {{ __('Total Shorts') }}</td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency(0, currencyCode()) }}</td>
                                            <td class="fw-bolder border-dashed">
                                                <span class="ending-balance" id="total_shorts">
                                                    {{ \Illuminate\Support\Number::currency($shorts, currencyCode()) }}
                                                </span>
                                            </td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency($shorts, currencyCode()) }}</td>

                                        </tr>


                                        <tr class="fw-bolder text-primary" style="border-top: 2px  dotted; border-bottom: 2px  dotted">
                                            <td>{{ __('Totals') }}</td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency($shift->cash_start + collect($networks)->sum('balance_old'), currencyCode()) }}</td>
                                            <td class="fw-bolder border-dashed">
                                                <span class="total-ending-balance" id="total-ending-balance">
                                                {{ \Illuminate\Support\Number::currency($totals + $loanBalances + $shorts, currencyCode()) }}
                                            </td>
                                            <td class=" border-dashed">{{ \Illuminate\Support\Number::currency($transacted + $income + $expenses + $shorts + $shift->loans->sum('amount')  , currencyCode()) }}</td>

                                        </tr>

                                        <tr class="border-1">
                                            <td colspan="4">
                                                <x-helpertext class="text-sm" >
                                                   <span style=""> {{ __( "Total Cash + Total Tills + Expenses + Shorts + Loans balance - Income ") }}</span>
                                                </x-helpertext>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Tills and Summamry Card-->


                    <!--begin::Income and Expenses Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>{{ __('Income and Expenses') }}</h2>
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

                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>{{ __('Income') }}</td>
                                            <td>{{ Number::currency($income, currencyCode()) }}</td>

                                        </tr>

                                        <tr>
                                            <td>{{ __('Expenses') }}</td>
                                            <td>{{ Number::currency($expenses, currencyCode()) }}</td>

                                        </tr>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--begin::END Income and Expenses Card-->

                    <!--begin::Loans Card-->
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
                    <!--end::Loan sCard-->

                    <!--begin::Shorts-->
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
                    <!--end::Shorts-->

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

                    var expenses = parseFloat(document.getElementById('expenses').value);


                    $("span.expenses").text(expenses)

                    var cash =   parseFloat(document.getElementById('closing_balance').value)  ;
                    $("span#cash").text(cash)

                    var income = parseFloat(document.getElementById('income').value);

                    $("span.income").text(income)

                    var loanBalances = parseFloat(document.getElementById('loans-balances').getAttribute('data-loans-balance'));

                    var total = parseFloat(document.getElementById('closing_balance').value) + expenses + loanBalances - income;


                    // Loop through each network balance input field
                    var networkInputs = document.querySelectorAll('.network-balance');

                    networkInputs.forEach(function (input) {

                        total += parseFloat(input.value);

                        $("span."+ input.dataset.name).text(input.value)

                    });
                    var endingBalance = document.querySelectorAll('.ending-balance');

                    let  totalEndingBalance = 0;

                    endingBalance.forEach(function (span) {
                        totalEndingBalance += parseFloat(parseFloat(span.textContent.trim().replace(/[^\d.]/g, '')));
                    });

                    $("span#total-subtotal").text(total.toLocaleString('en-US', {maximumFractionDigits: 2}))
                    $("span#total-ending-balance").text(totalEndingBalance.toLocaleString('en-US', {maximumFractionDigits: 2}))


                    let startingCapital = $("h4#starting-capital").data('starting-capital')

                    let totalShort = (parseFloat(startingCapital) - total);
                    // Display the total in some element (you can adjust this based on your needs)
                    document.getElementById('total_balance').innerText =  (total + totalShort ).toLocaleString('en-US', {maximumFractionDigits: 2});


                    document.getElementById('total_shorts').innerText = totalShort.toLocaleString('en-US', {maximumFractionDigits: 2});

                    $("input.total_shorts_input").val(totalShort)

                    $("span#total_shorts").text(totalShort)
                    $("span#total_shorts").text(totalShort)

                    $("span#total-balance").text(total + totalShort + income)

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
                document.getElementById('expenses').addEventListener('change', calculateTotal);
                document.getElementById('income').addEventListener('change', calculateTotal);

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

                    if (selectedValue == "TILL") {
                        $("div#shift_network_code").show();
                    } else {
                        $("div#shift_network_code").hide();
                    }


                })

            })
        </script>

    @endpush

@endsection



