@php use App\Utils\Enums\LoanTypeEnum;
     use App\Utils\Enums\NetworkTypeEnum;
@endphp
<div>


    <form method="post" id="add-loan-form">

        <div class="modal-body">

            <div class="row fv-row py-2">

                <div class="col-6 mt-md-4">
                    <x-label class="" label="{{ __('Amount') }}" for="amount"/>

                    <x-input
                        type="number"
                        class="form-control-solid   @error('amount') form-control-feedback @enderror"
                        name="amount"
                        placeholder="{{ __('amount') }}"
                        id="amount"
                    />

                    <x-helpertext>{{ __("Amount for this Loan") }}</x-helpertext>
                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                
                <div class="col-6 mt-md-4">
                    <x-label class="" label="{{ __('Fund Source') }}" for="source"/>
                    <x-select2
                        modalId="add-loan"
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


                <div class="col-6 mt-md-4 till-source">
                    <x-label class="" label="Transaction Type" for="type"/>

                    <x-select2
                        modalId="add-loan"
                        class=" @error('type') @enderror"
                        name="type"
                        placeholder="{{ __('Select a Transaction Type') }}"
                        id="type">
                        <option value="">{{ __('Select a Transaction Type') }}</option>

                        @foreach(LoanTypeEnum::cases() as $transactionType)
                            <option value="{{ $transactionType->value }}">{{ $transactionType->label() }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __("Type of Transaction, either deposit or withdraw") }}</x-helpertext>

                    @error('type')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-6 mt-md-4 till-source">
                    <x-label class="" label="Select Till" for="till_code"/>

                    <x-select2
                        class=" @error('network_code') form-control-error @enderror"
                        name="network_code"
                        modalId="add-loan"
                        id="network_code_loan"
                        placeholder="{{ __('Select a Till') }}"
                    >
                        <option value=""></option>

                        @foreach($networks as $name =>  $network)
                            @if($network['type'] != NetworkTypeEnum::CRYPTO->value)
                                <option title={{ $network['logo'] }} value="{{ $network['code'] }}" class="{!! $network['balance'] > 0 ? 'balance' : 'nobalance' !!}">{{ $name }} - {{ number_format($network['balance'],2) }}</option>
                            @endif
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __("Select Till for this Loan") }}</x-helpertext>
                    @error('network_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="col-6 mt-md-4 till-source">

                    <x-helpertext>

                        <ul class="list-style-none">
                            <li class="py-md-1 text-primary">{{ __("Transaction Effects") }}</li>
                            <li>{{ __('Deposit') }}: {{ __('Reduces Till Balance, Cash Balance will increase upon Loan payments') }}</li>
                            <li  class="pt-md-3">{{ __('Withdraw') }}: {{ __('Reduce the Cash Balance, Till Balance will increase upon Loan payments') }}</li>

                        </ul>
                    </x-helpertext>

                </div>
            </div>


            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="description" class="" for="notes"/>
                    <textarea
                        name="description"
                        class="form-control form-control form-control-solid"
                        rows="3"
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
                    <x-label label="Notes" required="" class="" for="notes"/>
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

            <x-submit-button id="add-loan-button" label="Save Loan"/>
        </div>
    </form>


    @push('js')

        <script>


            $(document).ready(() => {
                
                $("select#type").on("change", function () {
                    var selectedOption = $(this).find(":selected").val();
                    console.log(selectedOption);
                    if(selectedOption == "money_in"){
                        $("#network_code_loan .nobalance").attr("disabled", true);
                    } else  {
                        $("#network_code_loan .nobalance").attr("disabled", false);
                    }

                });

                $("div.till-source").hide()

                $("select#source").on("change", function () {

                    var selectedOption = $(this).find(":selected");


                    var source = selectedOption.data("source");


                    if ("TILL" === source) {
                        $("div.till-source").show()
                    } else {
                        $("div.till-source").hide()
                    }


                });

                jQuery(document).on("click","#add-loan-button", function(){

                    if(jQuery("#add-loan-form #source").val() == "TILL"){
                        var loanValidations = [
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
                                "name": "type",
                                "error": "Transaction Type is Required",
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
                    } else {
                        var loanValidations = [
                            {
                                "name": "amount",
                                "error": "Amount is Required",
                                "validators" : {}
                            },
                            {
                                "name": "source",
                                "error": "Fund Source is Required",
                                "validators" : {}
                            },
                            {
                                "name": "description",
                                "error": "Description Type is Required",
                                "validators" : {}
                            },
                        ];
                    }

                    const loanForm = document.getElementById('add-loan-form');
                    const submitLoanButton = document.getElementById('add-loan-button');
                    lakoriValidation(loanValidations, loanForm, submitLoanButton, 'post', '{{  route('agency.loans.store', $shift) }}',"",true);
                });

                $('#network_code_loan').select2({
                    templateResult: formatOption,
                    templateSelection: formatOption,
                    minimumResultsForSearch: Infinity
                });
            })

        </script>
    @endpush
</div>
