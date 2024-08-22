<div>
    <style>

.current-balance .balance-label {
    display: block;
    max-width: max-content;
    font-size: 20px;
    font-weight: 700;
}
.current-balance .balance-amount{color:#409992;font-size: 30px;font-weight:700}
    </style>
    <form method="post" id="deposit-transaction-form">
        @csrf
        <input type="hidden" name="type" id="transaction_type" value="IN">
        <div class="modal-body">
            <div class="current-balance">
                <span class="balance-label">Balance</span>
                <span class="balance-amount" data-till="{{ number_format($tillBalances , 2) }}">{{ currencyCode() }} {{ number_format($tillBalances , 2) }}</span>
            </div>
            <div class="row fv-row py-2">

                <div class="col-6 py-3" id="allNetwork">
                    <x-label class="" label="Select Till" for="till_code"/>

                    <x-select2
                        name="network_code"
                        placeholder="{{ __('Select a Till') }}"
                        id="network_code"
                    >
                        <option value="">  </option>

                        @foreach($networks as $name =>  $network)
                                <option title={{ $network['logo'] }}
                                value="{{ $network['code'] }}" {!! $network['balance'] < 1 ? 'disabled' : '' !!} data-type="{{ $network['type'] }}" data-rate="{{ isset($network['exchange_rate']) ? $network['exchange_rate'] : '' }}"
                                >{{ str($name)->title()->value()  }} - {{ number_format($network['balance'],2) }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __("Till you want to transact from") }}</x-helpertext>
                    <x-helpertext>{{ __('Deposit') }}: {{ __('Increases Cash Balance and Reduces Till Balance') }}</x-helpertext>
                    @error('network_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="col-6">
                    <x-label class="" label="{{ __('Amount') }}" for="amount"/>
                    <x-input
                        type="number"
                        name="amount"
                        class="form-control-solid   @error('amount') form-control-feedback @enderror"
                        placeholder="{{ __('amount') }}"
                        id="amount"/>

                    <x-helpertext>{{ __("Amount you want to Transact") }}</x-helpertext>

                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-3">
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

            <div class="row fv-row">

                <div class="col-6 crypto-data">
                    <x-label class="" label="{{ __('Fee') }}" for="fee"/>
                    <x-input
                        type="number"
                        class="form-control-solid   @error('fee') form-control-feedback @enderror"
                        name="fee"
                        placeholder="{{ __('fee') }}"
                        id="fee"
                    />
                    @error('fee')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

            </div>

            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="Description" class="" for="description"/>
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


        <div class="modal-footer my-4 py-2">
            <x-submit-button  id="deposit-transaction-button" label="Record Transaction"/>

        </div>

    </form>

    @push('js')

        <script>

             $(document).ready(() => {

                jQuery(".crypto-data").hide();

                jQuery(document).on("change","#deposit-transaction-form #network_code", function(){
                    var selectedOption = $(this).find(":selected");
                    if(selectedOption.data('type') == "Crypto"){
                        jQuery(".crypto-data").show();
                        jQuery("#deposit-transaction-form #exchange_rate").val(selectedOption.data('rate'));

                    } else {
                        jQuery(".crypto-data").hide();
                    }
                });

                jQuery("#deposit-transaction-form #amount, #deposit-transaction-form #crypto, #deposit-transaction-form #exchange_rate").on("change",function(){
                    var amount = jQuery("#deposit-transaction-form #amount").val();
                    var crypto = jQuery("#deposit-transaction-form #crypto").val();
                    var exchange_rate = jQuery("#deposit-transaction-form #exchange_rate").val();
                    var balance_amount = jQuery("#deposit-transaction-form .balance-amount").data('till');
                    var balance_amount = Number(balance_amount.replace(/[^0-9.-]+/g,""));           

                    if(crypto > 0){
                        jQuery("#deposit-transaction-form #amount").val(crypto * exchange_rate)
                    }else if(amount > 0){
                        jQuery("#deposit-transaction-form #crypto").val(amount / exchange_rate)
                    }

                    jQuery("#deposit-transaction-form .balance-amount").text(format(parseFloat(balance_amount,2) - parseFloat(amount,2)));
                });


                jQuery(document).on("click","#deposit-transaction-button", function(){

                    if(jQuery("#deposit-transaction-form #network_code").find(":selected").data('type') == "Crypto"){
                        var validations = [
                            {
                                "name": "amount",
                                "error": "Amount is Required",
                                "validators" : {}
                            }, {
                                "name": "network_code",
                                "error": "Till/Network is Required",
                                "validators" : {}
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
                                "name": "fee",
                                "error": "Fee is Required",
                                "validators" : {}
                            },
                            {
                                "name": "description",
                                "error": "Description Type is Required",
                                "validators" : {}
                            },
                        ];
                    } else {
                        var validations = [
                            {
                                "name": "amount",
                                "error": "Amount is Required",
                                "validators" : {}
                            }, {
                                "name": "network_code",
                                "error": "Till/Network is Required",
                                "validators" : {}
                            },
                            {
                                "name": "description",
                                "error": "Description Type is Required",
                                "validators" : {}
                            },

                        ];
                    }


                    const form = document.getElementById('deposit-transaction-form');
                    const submitTransactionButton = document.getElementById('deposit-transaction-button');
                    lakoriValidation(validations, form, submitTransactionButton, 'post', '{{  route('agency.transactions.add.transaction', $shift) }}',"",true);
                });

                $('#deposit-transaction-form #network_code').select2({
                    templateResult: formatOption,
                    templateSelection: formatOption,
                    minimumResultsForSearch: Infinity
                });
             })



        </script>
    @endpush
</div>
