@php use App\Utils\Enums\LoanTypeEnum; @endphp
<div>


    <form method="post" id="add-loan-form">

        <div class="modal-body">

            <div class="row fv-row py-2">

                <div class="col-6 mt-md-4">
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

                <div class="col-6 mt-md-4">
                    <x-label class="" label="Select Till" for="till_code"/>

                    <x-select2
                        class=" @error('network_code') form-control-error @enderror"
                        name="network_code"
                        modalId="add-loan"
                        placeholder="{{ __('Select a Till') }}"
                    >
                        <option value=""></option>

                        @foreach($tills as $till)
                            <option value="{{ $till->network_code }}">{{ $till->network?->agency?->name }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __("Select Till for this Loan") }}</x-helpertext>
                    @error('location_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


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
                const loanValidations = [
                    {
                        "name": "network_code",
                        "error": "Network is Required",
                        "validators": {}
                    },
                    {
                        "name": "amount",
                        "error": "Amount is Required",
                        "validators": {}
                    },

                    {
                        "name": "description",
                        "error": "Description  is Required",
                        "validators": {}
                    },

                    {
                        "name": "type",
                        "error": "Loan Type is Required",
                        "validators": {}
                    },

                    {
                        "name": "network_code",
                        "error": "Network is Required",
                        "validators": {}
                    },

                ];


                const loanForm = document.getElementById('add-loan-form');


                const submitLoanButton = document.getElementById('add-loan-button');


                console.log("form =>", loanForm)
                console.log("button =>", submitLoanButton)


                lakoriValidation(loanValidations, loanForm, submitLoanButton, 'post', '{{  route('agency.loans.store', $shift) }}');
            })

        </script>
    @endpush
</div>
