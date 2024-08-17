<div>
    <form method="post" id="transfer-balance-form">
        @csrf

        <div class="modal-body">

            <div class="row fv-row py-2">

                <div class="col-6 py-3">
                    <x-label class="" label="Source Till" for="network_code"/>

                    <x-select2

                        class=" @error('network_code') form-control-error @enderror"
                        name="network_code"
                        modalId="transfer-balance"
                        placeholder="{{ __('Select Source Till') }}"
                        id="network_code">
                        <option value="">  </option>

                        @foreach($networks as $name =>  $network)
                            @if($network['type'] == App\Utils\Enums\NetworkTypeEnum::FINANCE)
                                <option
                                value="{{ $network['code'] }}" class="{!! $network['balance'] > 0 ? 'balance' : 'nobalance' !!}" data-type="{{ $network['type'] }}"
                                >{{ str($name)->title()->value()  }} - {{ number_format($network['balance'],2) }}</option>
                            @endif
                        @endforeach
                    </x-select2>
                    @error('network_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="col-6 py-3" id="allNetwork">
                    <x-label class="" label="Destination Till" for="destination_till"/>

                    <x-select2
                        class=" @error('destination_till') form-control-error @enderror"
                        name="destination_till"
                        modalId="transfer-balance"
                        placeholder="{{ __('Select Destination Till') }}"
                        id="destination_till"
                    >
                        <option value="">  </option>

                        @foreach($networks as $name =>  $network)
                            @if($network['type'] == App\Utils\Enums\NetworkTypeEnum::FINANCE)
                                <option
                                value="{{ $network['code'] }}" class="{!! $network['balance'] > 0 ? 'balance' : 'nobalance' !!}" data-type="{{ $network['type'] }}"
                                >{{ str($name)->title()->value()  }} - {{ number_format($network['balance'],2) }}</option>
                            @endif
                        @endforeach
                    </x-select2>
                    @error('destination_till')
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

                    <x-helpertext>{{ __("Amount you want to Transfer") }}</x-helpertext>

                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="Description" class="" for="description"/>
                    <textarea name="description" class="form-control form-control form-control-solid" rows="3"
                              data-kt-autosize="false"></textarea>
                    <x-helpertext>{{ __("Anything you want to note about this Transfer Balance, Max length: 255 characters") }}</x-helpertext>
                    @error('description')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>


        <div class="modal-footer my-4 py-2">
            <x-submit-button  id="transfer-balance-button" label="Transfer"/>

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
                         "error": "Source Till/Network is Required",
                         "validators" : {}
                     },
                     {
                         "name": "destination_till",
                         "error": "Destination Till/Network is Required",
                         "validators" : {}
                     },

                     {
                         "name": "description",
                         "error": "Description Type is Required",
                         "validators" : {}
                     },

                 ];


                 const form = document.getElementById('transfer-balance-form');


                 const submitTransactionButton = document.getElementById('transfer-balance-button');


                 console.log("form =>", form)
                 console.log("button =>", submitTransactionButton)


                 lakoriValidation(validations, form, submitTransactionButton, 'post', '{{  route('agency.shift.transfer.balance', $shift) }}');
             })



        </script>
    @endpush
</div>
