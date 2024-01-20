@php use App\Utils\Enums\LoanTypeEnum; @endphp
<div>



        <form method="post" id="add-loan-form">

            <div class="modal-body">

                <div class="row fv-row py-2">

                    <div class="col-6">
                        <x-label class="" label="Select Till" for="till_code"/>

                        <x-select2
                            class=" @error('network_code') form-control-error @enderror"
                            name="network_code"
                            modalId="add-loan"
                            placeholder="{{ __('Select a Network') }}"
                        >
                            <option value="">  </option>

                            @foreach($tills as $till)
                                <option value="{{ $till->network_code }}">{{ $till->network?->agency?->name }}</option>
                            @endforeach
                        </x-select2>
                        @error('location_code')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>



                    <div class="col-6">
                        <x-label class="" label="{{ __('Amount') }}" for="amount"/>

                        <x-input
                            class="form-control-solid   @error('amount') form-control-feedback @enderror"
                               name="amount"
                            placeholder="{{ __('amount') }}"
                            id="amount"/>


                        @error('amount')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class="row fv-row py-2 mt-5">
                    <div class="col-6">
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
                        @error('type')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                </div>


                <div class="row fv-row py-3">
                    <div class="col-12">
                        <x-label label="description" class="" for="notes"/>
                        <textarea    name="description" class="form-control form-control form-control-solid" rows="3"  data-kt-autosize="false"></textarea>
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
                        <textarea  name="notes" class="form-control form-control form-control-solid" rows="3"  data-kt-autosize="false"></textarea>
                        @error('notes')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer my-4">

                <x-submit-button  id="add-loan-button" label="Save Loan" />
            </div>
        </form>



        @push('js')


            <script>


                $(document).ready(() => {
                    const loanValidations = [
                        {
                            "name": "network_code",
                            "error": "Network is Required",
                            "validators" : {}
                        },
                        {
                            "name": "amount",
                            "error": "Amount is Required",
                            "validators" : {}
                        },

                        {
                            "name": "description",
                            "error": "Description  is Required",
                            "validators" : {}
                        },

                        {
                            "name": "type",
                            "error": "Loan Type is Required",
                            "validators" : {}
                        },

                        {
                            "name": "network_code",
                            "error": "Network is Required",
                            "validators" : {}
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
