@php use App\Utils\Enums\LoanTypeEnum; @endphp
<div>

    @if($hasOpenShift)
        <x-empty
            heading="You must open shift to record a loan">
        </x-empty>
    @else

        <form wire:submit.prevent="addLoan">

            <div class="modal-body">

                <div class="row fv-row py-2">

                    <div class="col-6">

                        <x-label class="" label="Select Till" for="network_code"/>
                        <x-select2
                            class="form-control-solid w-100 form-control @error('network_code') form-control-error @enderror"
                            wire:model.blur="network_code"
                            placeholder="{{ __('Select a Till') }}"
                            id="network_code">
                            <option value="">{{ __('Select Till ') }}</option>

                            @foreach($networks as $network)
                                <option value="{{ $network->code }}">{{ $network->agency->name }}</option>
                            @endforeach
                        </x-select2>
                        @error('network_code')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <x-label class="" label="Select Location" for="location_code"/>
                        <x-select2
                            class="form-control-solid  form-control @error('location_code') form-control-error @enderror"
                            wire:model.blur="location_code"
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
                        <x-label class="" label="Transaction Type" for="type"/>

                        <x-select2

                            class="form-control-solid select2  form-control @error('type') form-control-error border-danger @enderror"
                            wire:model="type"
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

    @endif
</div>
