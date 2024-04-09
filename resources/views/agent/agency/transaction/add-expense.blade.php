<div>
    <form method="post" id="add-expense-form" class="uk-form-horizontal">

        @csrf
        <div class="modal-body">

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
                    <x-helpertext>{{ __("Amount you want to Expense") }}</x-helpertext>
                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-6">
                    <x-label class="" label="{{ __('Fund Source') }}" for="source"/>
                    <x-select2
                        modalId="add-expenses"
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
                        @foreach($networks as $name =>  $network)
                                <option
                                    value="{{ $network['code'] }}"  {{ $network['balance'] <= 0 ? 'disabled' : '' }}


                                >{{ str($name)->title()->value()  }}</option>
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

            <x-submit-button id="add-expense-button" label="Save Expenses"/>
        </div>

    </form>

    @push('js')
        <script>


            $(document).ready(() => {

                $("div#till-source").hide()

                $("select#source").on("change", function () {

                    var selectedOption = $(this).find(":selected");


                    var source = selectedOption.data("source");


                    if ("TILL" === source) {
                        $("div#till-source").show()

                    } else {
                        $("div#till-source").hide()
                    }


                });

                const expenseValidations = [
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

                    // {
                    //     "name": "network_code",
                    //     "error": "Till is Required",
                    //     "validators": {}
                    // },

                    {
                        "name": "description",
                        "error": "Description Type is Required",
                        "validators": {}
                    },

                ];


                const expenseForm = document.getElementById('add-expense-form');


                const submitIncomeButton = document.getElementById('add-expense-button');


                console.log("form =>", expenseForm)
                console.log("button =>", submitIncomeButton)


                lakoriValidation(expenseValidations, expenseForm, submitIncomeButton, 'post', '{{  route('agency.transactions.add.expense', $shift) }}');
            })


        </script>
    @endpush
</div>
