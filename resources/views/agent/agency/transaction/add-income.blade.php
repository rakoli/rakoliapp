<div>
    <form method="post" id="add-income-form" class="uk-form-horizontal">

        @csrf
        <div class="modal-body">

            <div class="row fv-row py-2">
                <div class="col-6">
                    <x-label class="" label="{{ __('Amount') }}" for="amount"/>
                    <x-input
                        type="number"
                        class="form-control-solid   @error('amount') form-control-feedback @enderror"
                        name="amount"
                        placeholder="{{ __('amount') }}"
                        id="amount"
                    />
                    <x-helpertext>
                        {{ __("Total Cash In Received") }}
                    </x-helpertext>
                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-6">
                    <x-label class="" label="{{ __('Cash In Type') }}" for="income_type"/>
                    <x-select2
                        name="income_type"
                        placeholder="{{ __('source: e.g Cash ') }}"
                        id="income_type">
                        @foreach(\App\Utils\Enums\FundSourceEnums::cases() as $source)
                            <option
                                value="{{ $source->value }}"
                                data-income="{{ $source->value }}"
                            >{{ str($source->name)->title()->value()  }}</option>
                        @endforeach
                    </x-select2>

                    <x-helpertext>

                        <ul class="list-style-none">
                            <li class="py-md-1 text-primary">{{ __("Select the Income type either: to Cash or Till Balance") }}</li>
                            <li>{{ __('Cash In') }}: {{ __('Transaction will Increase Cash balances') }}</li>
                            <li>{{ __('Till Cash In') }}: {{ __('Transaction will Increase Till balances') }}</li>

                        </ul>
                    </x-helpertext>
                    @error('income_type')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

            </div>
            <div class="row fv-row py-3 hidden" id="till-income-type">
                <div class="col-6">
                    <x-label class="" label="{{ __('Till') }}" for="till_code"/>
                    <x-select2
                        name="network_code"
                        placeholder="{{ __('source: e.g Mpesa ') }}"
                        id="network_code_income">
                        @foreach($networks as $name =>  $network)
                                <option
                                    value="{{ $network['code'] }}" data-type="{{ $network['type'] }}" data-rate="{{ isset($network['exchange_rate']) ? $network['exchange_rate'] : '' }}"
                                >{{ str($name)->title()->value()  }} - {{ number_format($network['balance'],2) }}</option>
                        @endforeach
                    </x-select2>
                    @error('network_code')
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
                    <x-label label="Description" class="" for="description"/>
                    <textarea
                        name="description"
                        class="form-control form-control form-control-solid"
                        rows="3"
                        data-kt-autosize="false"
                    ></textarea>
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
                    <textarea
                        name="notes"
                        class="form-control form-control form-control-solid"
                        rows="3"
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

            <x-submit-button id="add-income-button" label="Save Cash In"/>
        </div>

    </form>

    @push('js')
        <script>


            jQuery(document).ready(() => {
                jQuery("div#till-income-type").hide()
                jQuery(".crypto-data").hide();

                jQuery("select#income_type").on("change", function () {

                    var selectedOption = jQuery(this).find(":selected");

                    var incomeType = selectedOption.data('income');

                    if ("TILL" === incomeType)
                    {
                        jQuery("div#till-income-type").show()
                        jQuery('select#network_code_income').change();
                    } else {

                        jQuery("div#till-income-type").hide()
                    }
                });

                jQuery('select#network_code_income').on("change", function(){
                    var selectedOption = $(this).find(":selected");
                    if(selectedOption.data('type') == "Crypto"){
                        jQuery(".crypto-data").show();
                        jQuery("#exchange_rate").val(selectedOption.data('rate'));

                    } else {
                        jQuery(".crypto-data").hide();
                    }
                });

                jQuery("#add-income-form #amount, #add-income-form #crypto, #add-income-form #exchange_rate").on("change",function(){
                    var amount = jQuery("#add-income-form #amount").val();
                    var crypto = jQuery("#add-income-form #crypto").val();
                    var exchange_rate = jQuery("#add-income-form #exchange_rate").val();

                    if(crypto > 0){
                        jQuery("#add-income-form #amount").val(crypto * exchange_rate)
                    }else if(amount > 0){
                        jQuery("#add-income-form #crypto").val(amount / exchange_rate)
                    }
                });


                const incomeValidations = [
                    {
                        "name": "amount",
                        "error": "Amount is Required",
                        "validators" : {}
                    },
                    {
                        "name": "income_type",
                        "error": "Amount is Required",
                        "validators" : {}
                    },

                    {
                        "name": "description",
                        "error": "Description Type is Required",
                        "validators" : {}
                    },

                    {
                        "name": "network_code",
                        "error": "Network Type is Required",
                        "validators" : {}
                    },

                ];


                const incomeForm = document.getElementById('add-income-form');


                const submitIncomeButton = document.getElementById('add-income-button');


                console.log("form =>", incomeForm)
                console.log("button =>", submitIncomeButton)


                lakoriValidation(incomeValidations, incomeForm, submitIncomeButton, 'post', '{{  route('agency.transactions.add.income', $shift) }}');
            })



        </script>
    @endpush
</div>
