<div>
    <form method="post" id="add-income-form" class="uk-form-horizontal">

        @csrf
        <div class="modal-body">

            <div class="row fv-row py-2">
                <div class="col-6">
                    <x-label class="" label="{{ __('Amount') }}" for="amount"/>
                    <x-input
                        class="form-control-solid   @error('amount') form-control-feedback @enderror"
                        name="amount"
                        placeholder="{{ __('amount') }}" id="amount"/>
                    @error('amount')
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

            <x-submit-button id="add-income-button" label="Save incomes"/>
        </div>

    </form>

    @push('js')
        <script>


            $(document).ready(() => {
                const incomeValidations = [
                    {
                        "name": "amount",
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
