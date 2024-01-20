<div>
    <form method="post" id="add-transaction-form">
        @csrf

        <div class="modal-body">

            <div class="row fv-row py-2">
                <div class="col-6">
                    <x-label class="" label="{{ __('Amount') }}" for="amount"/>
                    <x-input
                        type="number"
                        name="amount"
                        class="form-control-solid   @error('amount') form-control-feedback @enderror"
                        placeholder="{{ __('amount') }}" id="amount"/>
                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="col-6 py-3">
                    <x-label class="" label="Select till" for="till_code"/>

                    <x-select2
                        class=" @error('network_code') form-control-error @enderror"
                        name="network_code"
                        modalId="add-transaction"
                        placeholder="{{ __('Select a Transaction Type') }}"
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


            </div>
            <div class="row fv-row py-3">




                <div class="col-6 py-3">
                    <x-label class="" label="Transaction Type" for="transaction_type"/>

                    <x-select2

                        class=" @error('transaction_type') form-control-error @enderror"
                        name="type"
                        modalId="add-transaction"
                        placeholder="{{ __('Select a Transaction Type') }}"
                        id="transaction_type">
                        <option value="">  </option>

                        @foreach(\App\Utils\Enums\TransactionTypeEnum::cases() as $transactionType)
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
                    <x-label label="description" class="" for="description"/>
                    <textarea name="description" class="form-control form-control form-control-solid" rows="3"
                              data-kt-autosize="false"></textarea>
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
                    @error('notes')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>


        <div class="modal-footer my-4 py-2">
            <x-submit-button  id="add-transaction-button" label="Record Transaction"/>

        </div>

    </form>

    @push('js')

        <script>


             $(document).ready(() => {
                 const validations = [
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
                         "name": "type",
                         "error": "Transaction Type is Required",
                         "validators" : {}
                     },

                     {
                         "name": "description",
                         "error": "Description Type is Required",
                         "validators" : {}
                     },

                 ];


                 const form = document.getElementById('add-transaction-form');


                 const submitTransactionButton = document.getElementById('add-transaction-button');


                 console.log("form =>", form)
                 console.log("button =>", submitTransactionButton)


                 lakoriValidation(validations, form, submitTransactionButton, 'post', '{{  route('agency.transactions.add.transaction', $shift) }}');
             })



        </script>
    @endpush
</div>
