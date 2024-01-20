<div>
    <form method="post" id="add-expense-form" class="uk-form-horizontal">

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

           <x-submit-button id="add-expense-button" label="Save Expenses"/>
        </div>

    </form>

    @push('js')
        <script>


            $(document).ready(() => {
                const expenseValidations = [
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
