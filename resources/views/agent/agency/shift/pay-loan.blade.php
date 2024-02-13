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
                    <div class="col-8">

                        <x-label
                            class=""
                            label="Payment Method"
                            for="payment_method"
                        />
                        <x-input
                            type="text"
                            class="form-control-solid"
                            name="payment_method"
                            placeholder="{{ __('payment_method') }}"
                            id="payment_method"
                        />
                        <x-helpertext>{{ __("How did you get paid? e,g Cash, Bank, Cheque, Till:M-Pesa") }}</x-helpertext>
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
                        }, {
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
                            "name": "payment_method",
                            "error": "Payment method is Required",
                            "validators" : {}
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
