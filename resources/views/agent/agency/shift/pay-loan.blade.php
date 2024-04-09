@php use App\Utils\Enums\LoanTypeEnum; @endphp
<div>


        <form method="post" id="pay-loan-form">

            @csrf

            <div class="modal-body">

                <div class="row fv-row py-2">

                    <div class="col-6">
                        <x-label class="" label="{{ __('Amount') }}" for="amount"/>

                        <x-input
                            type="number"
                            name="amount"
                            class="form-control-solid"
                            value="{{ $loan->balance }}"
                            placeholder="{{ __('amount') }}"
                            id="amount"
                        />
                        <x-helpertext>
                            {{ __("Total Amount Received") }}
                        </x-helpertext>

                    </div>

                    <div class="col-6">
                        <x-label class="" label="{{ __('Date') }}" for="date"/>

                        <x-datepicker-input
                            class="form-control-solid"
                            name="deposited_at"
                            type="text"
                            id="date"
                        />

                        <x-helpertext>
                            {{ __("Date Payment was Deposited or Received at the Store") }}
                        </x-helpertext>
                    </div>
                </div>
                
                <div class="row fv-row py-3">
                    <div class="col-6">
                        <x-label class="" label="{{ __('Fund Source') }}" for="source"/>
                        <x-select2
                            modalId="receive-loan-payment"
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
                            {{ __("How did you get paid? e,g Cash, Till:M-Pesa") }}
                        </x-helpertext>
                        
                        @error('source')
                            <div class="help-block text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row fv-row py-3">
                    <div class="col-6 till-source">
                        <x-label class="" label="Transaction Type" for="type"/>

                        <x-select2
                            modalId="receive-loan-payment"
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

                    <div class="col-6 till-source">
                        <x-label class="" label="Select Till" for="till_code"/>

                        <x-select2
                            class=" @error('network_code') form-control-error @enderror"
                            name="network_code"
                            modalId="receive-loan-payment"
                            id="network_code"
                            placeholder="{{ __('Select a Till') }}"
                        >
                            <option value=""></option>

                            @foreach($networks as $name =>  $network)
                                <option value="{{ $network['code'] }}" class="{!! $network['balance'] > 0 ? 'balance' : 'nobalance' !!}">{{ $name }} - {{ number_format($network['balance'],2) }}</option>
                            @endforeach
                        </x-select2>
                        <x-helpertext>{{ __("Select Till for this Loan") }}</x-helpertext>
                        @error('network_code')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>
                <div class="row fv-row py-3">
                    <div class="col-12">
                        <x-label
                            label="Description"
                            class=""
                            for="description"
                        />
                        <textarea
                            name="description"
                            class="form-control form-control form-control-solid"
                            rows="3"
                            data-kt-autosize="false"></textarea>

                        <x-helpertext>{{ __("Anything you want to note about this Transaction, Max length: 255 characters") }}</x-helpertext>

                    </div>
                </div>


                <div class="row fv-row py-3">
                    <div class="col-12">
                        <x-label
                            label="Notes"
                            required=""
                            for="notes"/>
                        <textarea
                            name="notes"
                            class="form-control form-control form-control-solid"
                            rows="3"
                            data-kt-autosize="false"></textarea>

                        <x-helpertext>{{ __("Any Additional note, Max length: 255 characters") }}</x-helpertext>

                    </div>
                </div>
            </div>

            <div class="modal-footer">

                <x-submit-button type="button" id="pay-loan-button" class="btn btn-primary">Save changes</x-submit-button>
            </div>
        </form>


        @push('js')
            <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

            <script>




                $(document).ready(() => {



                    const loanValidations = [
                        {
                            "name": "amount",
                            "error": "Amount is Required",
                            "validators" : {}
                        }, 

                        {
                            "name": "deposited_at",
                            "error": "Date is Required",
                            "validators" : {}
                        },

                        {
                            "name": "source",
                            "error": "Fund Source is Required",
                            "validators": {}
                        },

                        {
                            "name": "description",
                            "error": "Description is Required",
                            "validators" : {}
                        },

                    ];


                    const loanForm = document.getElementById('pay-loan-form');


                    const submitLoanButton = document.getElementById('pay-loan-button');


                    lakoriValidation(loanValidations, loanForm, submitLoanButton, 'post', '{{  route('agency.loans.pay', ["shift" => $shift , "loan" => $loan]) }}');
                })



            </script>
        @endpush


</div>
