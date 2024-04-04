<div>
    <form method="post" id="add-transaction-form">
        @csrf

        <div class="modal-body">

            <div class="row fv-row py-2">

                <div class="col-6 py-3">
                    <x-label class="" label="Client Action(Transaction Type)" for="transaction_type"/>

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

                    <x-helpertext>{{ __("Type of Transaction, either deposit or withdraw") }}</x-helpertext>
                    @error('type')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="col-6 py-3" id="allNetwork">
                    <x-label class="" label="Select Till" for="till_code"/>

                    <x-select2
                        class=" @error('network_code') form-control-error @enderror"
                        name="network_code"
                        modalId="add-transaction"
                        placeholder="{{ __('Select a Transaction Type') }}"
                    >
                        <option value="">  </option>

                        @foreach($networks as $name =>  $network)
                            <option value="{{ $network['code'] }}" class="{!! $network['balance'] > 0 ? 'balance' : 'nobalance' !!}">{{ $name }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __("Till you want to transact from") }}</x-helpertext>

                    @error('location_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror

                </div>
            </div>
            <div class="row fv-row">

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

                <div class="col-6">
                    <x-helpertext>
                        <ul class="list-style-none">
                            <li>{{ __('Deposit') }}: {{ __('Increases Cash Balance and Reduces Till Balance') }}</li>
                            <li>{{ __('Withdraw') }}: {{ __('Increases Till Balance and Reduces Cash Balance') }}</li>
                        </ul>
                    </x-helpertext>
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
            <x-submit-button  id="add-transaction-button" label="Record Transaction"/>

        </div>

    </form>

    @push('js')

        <script>


             $(document).ready(() => {

                $("select#transaction_type").on("change", function () {
                    var selectedOption = $(this).find(":selected").val();

                    if(selectedOption == "IN"){
                        $(".nobalance").attr("disabled", true);
                    } else  {
                        $(".nobalance").attr("disabled", false);
                    }

                });

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
