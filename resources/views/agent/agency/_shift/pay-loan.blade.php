@php use App\Utils\Enums\LoanTypeEnum; @endphp
<div>


        <form wire:submit.prevent="payLoan">

            <div class="modal-body">

                <div class="row fv-row py-2">

                    <div class="col-6">
                        <x-label class="" label="{{ __('Amount') }}" for="amount"/>

                        <x-input
                            class="form-control-solid   @error('amount') form-control-feedback @enderror"
                            wire:model.blur="amount"
                            placeholder="{{ __('amount') }}"
                            id="amount"/>


                        @error('amount')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <x-label class="" label="{{ __('Date') }}" for="date"/>

                        <x-input
                            type="date"
                            class="form-control-solid   @error('deposited_at') form-control-feedback @enderror"
                            wire:model.blur="deposited_at"
                            placeholder="{{ __('date') }}"
                            id="date"/>


                        @error('deposited_at')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row fv-row py-3">
                    <div class="col-6">

                        <x-label class="" label="Payment Method" for="payment_method"/>


                        <x-input
                            type="text"
                            class="form-control-solid   @error('payment_method') form-control-feedback @enderror"
                            wire:model.blur="payment_method"
                            placeholder="{{ __('payment_method') }}"
                            id="payment_method"/>

                    </div>
                </div>

                <div class="row fv-row py-3">
                    <div class="col-12">
                        <x-label label="notes" class="" for="notes"/>
                        <textarea wire:model="notes" class="form-control form-control form-control-solid" rows="3"
                                  data-kt-autosize="false"></textarea>
                        @error('notes')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>

    @push('js')
        <script>
            $("input#date").datepicker()
        </script>
    @endpush

</div>
