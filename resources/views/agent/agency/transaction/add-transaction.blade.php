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
                <div class="col-6">
                    <x-label class="" label="Select Location" for="location_code"/>
                    <x-select2
                        class="form-control-solid  form-control @error('location_code') form-control-error @enderror"
                        name="location_code"

                        placeholder="{{ __('Select a location') }}"
                        id="location">
                        <option value="">{{ __('Select location ') }}</option>

                        @foreach($locations as $location)
                            <option value="{{ $location->code }}">{{ $location->name }}</option>
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
                        <x-label class="" label="Select till" for="till_code"/>

                        <x-select2
                            class="form-control-solid  form-control @error('till_code') form-control-error @enderror"
                            name="till_code"
                            placeholder="{{ __('Select a till') }}"
                            id="till_code">
                            <option value="">{{ __('Select till ') }}</option>

                            @foreach($tills as $till)
                                <option value="{{ $till->code }}">{{ $till->agency->name }}</option>
                            @endforeach
                        </x-select2>
                        @error('till_code')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    <div class="col-6 py-3">
                        <x-label class="" label="Transaction Type" for="type"/>

                        <x-select2

                            class="form-control-solid select2  form-control @error('transaction_type') form-control-error @enderror"
                            name="type"
                            placeholder="{{ __('Select a Transaction Type') }}"
                            id="type">
                            <option value="">{{ __('Select a Transaction Type') }}</option>

                            @foreach(\App\Utils\Enums\TransactionTypeEnum::cases() as $transactionType)
                                <option value="{{ $transactionType->value }}">{{ $transactionType->value }}</option>
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
                    <x-label label="notes" class="" for="notes"/>
                    <textarea name="notes" class="form-control form-control form-control-solid" rows="3"  data-kt-autosize="false"></textarea>
                    @error('notes')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>


        <div class="modal-footer my-4 py-2">

            <button type="button"  id="add-transaction" class="btn btn-primary">Save changes</button>
        </div>

    </form>

    @push('js')

        <script>
            $("button#add-transaction").click(function (event){
                event.preventDefault();

                submitForm(
                    $("form#add-transaction-form"),
                    "{{ route('agency.transactions.add.transaction') }}"
                );

            });
        </script>
    @endpush
</div>
