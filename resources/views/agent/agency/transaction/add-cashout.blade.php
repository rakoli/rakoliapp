<div>
    <form method="post" id="add-cashout-form" class="uk-form-horizontal">
        <input type="hidden" name="category" value="CashOut">
        @csrf
        <div class="modal-body">
            <div class="current-balance">
                <span class="balance-label">Balance</span>
                <span class="balance-amount" data-till="{{ number_format($tillBalances , 2) }}" data-cash="{{ number_format($cashAtHand , 2) }}">{{ currencyCode() }} {{ number_format($cashAtHand , 2) }}</span>
            </div>
            <div class="row fv-row py-2">

                <div class="col-6">
                    <x-label class="" label="{{ __('Amount') }}" for="amount"/>
                    <x-input
                        type="number"
                        class="form-control-solid
                         @error('amount') form-control-feedback @enderror"
                        name="amount"
                        data-placeholder="{{ __('amount') }}"
                        id="amount"/>
                    <x-helpertext>{{ __("Amount you want to Cash Out") }}</x-helpertext>
                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-6">
                    <x-label class="" label="{{ __('Fund Source') }}" for="source"/>
                    <x-select2
                        modalId="add-cashouts"
                        name="source"
                        placeholder="{{ __('source: e.g Cash ') }}"
                        id="source"
                    >
                        @foreach(\App\Utils\Enums\FundSourceEnums::cases() as $source)
                            <option
                                value="{{ $source->value }}"
                                data-source="{{ $source->value }}"
                            >{{ str($source->name)->title()->value()  }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>

                        <ul class="list-style-none">
                            <li class="py-md-1 text-primary">{{ __("Select the source of funds for this transaction") }}</li>
                            <li>{{ __('Cash Source') }}: {{ __('Transaction will reduce cash balances') }}</li>
                            <li>{{ __('Till Source') }}: {{ __('Transaction will reduce Till balances') }}</li>

                        </ul>
                    </x-helpertext>

                    @error('source')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

            </div>


            <div class="row fv-row py-3 hidden" id="till-source">
                <div class="col-6">
                    <x-label class="" label="{{ __('Till') }}" for="till_source_code"/>
                    <x-select2
                        name="network_code"
                        placeholder="{{ __('source: e.g Till ') }}"
                        id="till_source_code"
                        >
                        <option value="">  </option>

                        @foreach($networks as $name =>  $network)
                            <option title="{{ $network['logo'] }}"value="{{ $network['code'] }}" {!! $network['balance'] < 1 ? 'disabled' : '' !!} data-type="{{ $network['type'] }}" data-rate="{{ isset($network['exchange_rate']) ? $network['exchange_rate'] : '' }}"
                                >{{ str($name)->title()->value()  }} - {{ number_format($network['balance'],2) }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __('Select till used for this Expenses') }}</x-helpertext>
                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


            </div>
            <div class="row fv-row py-3 hidden">
                <div class="col-6 crypto-data">
                    <x-label class="" label="{{ __('Crypto Amount') }}" for="crypto"/>
                    <x-input
                        type="number"
                        class="form-control-solid   @error('crypto') form-control-feedback @enderror"
                        name="crypto"
                        placeholder="{{ __('crypto') }}"
                        id="crypto"
                    />
                    @error('crypto')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6 crypto-data">
                    <x-label class="" label="{{ __('Exchange Rate') }}" for="exchange_rate"/>
                    <x-input
                        type="number"
                        class="form-control-solid   @error('exchange_rate') form-control-feedback @enderror"
                        name="exchange_rate"
                        placeholder="{{ __('exchange_rate') }}"
                        id="exchange_rate"
                    />
                    @error('exchange_rate')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="description" class="" for="description"/>
                    <textarea name="description" class="form-control form-control form-control-solid" rows="3"
                              data-kt-autosize="false"></textarea>

                    <x-helpertext>{{ __("Anything you want to note about this Transaction, Max length: 255 characters") }}</x-helpertext>

                    @error('description')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror

                </div>
            </div>


            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="notes" required="" class="" for="notes"/>
                    <textarea name="notes" class="form-control form-control form-control-solid" rows="3"
                              data-kt-autosize="false"></textarea>
                    <x-helpertext>{{ __("Any Additional note, Max length: 255 characters") }}</x-helpertext>
                    @error('notes')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>


        <div class="modal-footer my-4">

            <x-submit-button id="add-expense-button" label="Save Cash Out"/> 
        </div>

    </form>

    @push('js')
        <script>


            $(document).ready(() => {

                $("div#till-source").hide()
                jQuery(".crypto-data").hide();

                $("select#source").on("change", function () {
                    var selectedOption = $(this).find(":selected");
                    var source = selectedOption.data("source");

                    if ("TILL" === source) {
                        $("div#till-source").show();
                        jQuery('select#till_source_code').change();
                        var balance_amount = jQuery("#add-cashout-form .balance-amount").data('till');
                    } else {
                        $("div#till-source").hide();
                        jQuery(".crypto-data").hide();
                        var balance_amount = jQuery("#add-cashout-form .balance-amount").data('cash');
                    }
                    var balance_amount = Number(balance_amount.replace(/[^0-9.-]+/g,""));
                    jQuery("#add-cashout-form .balance-amount").text(format(balance_amount));

                });

                jQuery('select#till_source_code').on("change", function(){
                    var selectedOption = $(this).find(":selected");
                    if(selectedOption.data('type') == "Crypto"){
                        jQuery(".crypto-data").show();
                        jQuery("#add-cashout-form #exchange_rate").val(selectedOption.data('rate'));

                    } else {
                        jQuery(".crypto-data").hide();
                    }
                });

                jQuery("#add-cashout-form #amount, #add-cashout-form #crypto, #add-cashout-form #exchange_rate").on("change",function(){
                    var amount = jQuery("#add-cashout-form #amount").val();
                    var crypto = jQuery("#add-cashout-form #crypto").val();
                    var exchange_rate = jQuery("#add-cashout-form #exchange_rate").val();
                    if(jQuery('select#source').val() == "TILL"){
                        var balance_amount = jQuery("#add-cashout-form .balance-amount").data('till');
                    } else {
                        var balance_amount = jQuery("#add-cashout-form .balance-amount").data('cash');
                    }
                    var balance_amount = Number(balance_amount.replace(/[^0-9.-]+/g,""));

                    if(crypto > 0){
                        jQuery("#add-cashout-form #amount").val(crypto * exchange_rate)
                    }else if(amount > 0){
                        jQuery("#add-cashout-form #crypto").val(amount / exchange_rate)
                    }
                    jQuery("#add-cashout-form .balance-amount").text(format(parseFloat(balance_amount,2) - parseFloat(amount,2)));
                });

                jQuery(document).on("click","#add-expense-button", function(){

                    if(jQuery("#source").val() == "TILL"){

                        if(jQuery("#till_source_code").find(":selected").data('type') == "Crypto"){
                            var expenseValidations = [
                                {
                                    "name": "amount",
                                    "error": "Amount is Required",
                                    "validators": {}
                                },
                                {
                                    "name": "source",
                                    "error": "Fund Source is Required",
                                    "validators": {}
                                },
                                {
                                    "name": "network_code",
                                    "error": "Till is Required",
                                    "validators": {}
                                },
                                {
                                    "name": "crypto",
                                    "error": "Crypto is Required",
                                    "validators" : {}
                                },
                                {
                                    "name": "exchange_rate",
                                    "error": "Exchange Rate is Required",
                                    "validators" : {}
                                },
                                {
                                    "name": "description",
                                    "error": "Description Type is Required",
                                    "validators": {}
                                },
                            ];
                        } else {
                            var expenseValidations = [
                                {
                                    "name": "amount",
                                    "error": "Amount is Required",
                                    "validators": {}
                                },
                                {
                                    "name": "source",
                                    "error": "Fund Source is Required",
                                    "validators": {}
                                },
                                {
                                    "name": "network_code",
                                    "error": "Till is Required",
                                    "validators": {}
                                },
                                {
                                    "name": "description",
                                    "error": "Description Type is Required",
                                    "validators": {}
                                },
                            ];
                        }
                    } else {
                        var expenseValidations = [
                            {
                                "name": "amount",
                                "error": "Amount is Required",
                                "validators": {}
                            },
                            {
                                "name": "source",
                                "error": "Fund Source is Required",
                                "validators": {}
                            },
                            {
                                "name": "description",
                                "error": "Description Type is Required",
                                "validators": {}
                            },

                        ];
                    }

                    const expenseForm = document.getElementById('add-cashout-form');
                    const submitIncomeButton = document.getElementById('add-expense-button');
                    lakoriValidation(expenseValidations, expenseForm, submitIncomeButton, 'post', '{{  route('agency.transactions.add.expense', $shift) }}',"",true);
                });
                
                $('#till_source_code').select2({
                    templateResult: formatOption,
                    templateSelection: formatOption,
                    minimumResultsForSearch: Infinity
                });
            })


        </script>
    @endpush
</div>
