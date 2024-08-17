@php use App\Utils\Enums\NetworkTypeEnum; @endphp
<div>
    <h2 class="text-md-center">Edit Network Details</h2>
    <form method="post" id="update-network-form" class="uk-form-horizontal ">
        @method('PATCH')
        @csrf


            <div class="row fv-row py-2">

                <div class="col-12">

                    <x-label class="" label="Select Type" for="type"/>
                    <x-select2
                        name="type"
                        placeholder="{{ __('Select a Network Type') }}"
                        id="type" disabled>

                        @foreach(NetworkTypeEnum::cases() as $networkType)
                            <option value="{{ $networkType->value }}" @selected($networkType->value == $network->type)>{{ $networkType->label() }}</option>
                        @endforeach
                    </x-select2>
                    @error('type')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-12">
                    <x-label class="" label="{{ __('Name') }}" for="name"/>
                    <x-input
                        class="form-control-solid   @error('name') form-control-feedback @enderror"
                        name="name"
                        value="{{ $network->name }}"
                        placeholder="{{ __('name') }}" id="name"/>
                    @error('name')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-2">
                @if($network->type == "Finance")
                <div class="col-12">

                    <x-label class="" label="Select Agent" for="fsp_code"/>
                    <x-select2
                        name="fsp_code"
                        placeholder="{{ __('Select a Agency') }}"
                        id="fsp_code">

                        @foreach($agencies as $agency)
                            <option
                                @selected($agency->code == $network->fsp_code)
                                value="{{ $agency->code }}">{{ $agency->name }}</option>
                        @endforeach
                    </x-select2>
                    @error('fsp_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @else
                <div class="col-12">
                    <x-label
                        class=""
                        label="Select Crypto Provider"
                        for="crypto_code"
                    />
                    <x-select2
                        name="crypto_code"
                        placeholder="{{ __('Select a Crypto Provider') }}"
                        id="crypto_code" disabled
                    >
                        @foreach($cryptos as $crypto)
                            <option @selected($crypto->code == $network->crypto_code)
                                value="{{ $crypto->code }}" data-rate="{{ $crypto->usd_rate }}">{{ $crypto->name }}</option>
                        @endforeach
                    </x-select2>
                </div>
                @endif
            </div>
            <div class="row fv-row py-2">
                @if($network->type == "Finance")
                    <div class="col-12">
                        <x-label class="" label="{{ __('Agent No') }}" for="agent_no"/>
                        <x-input
                            class="form-control-solid   @error('agent_no') form-control-feedback @enderror"
                            name="agent_no"
                            value="{{ $network->agent_no }}"
                            placeholder="{{ __('agent_no') }}" id="agent_no"/>
                        @error('agent_no')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <x-label class="" label="{{ __('Balance') }}" for="balance"/>
                        <x-input
                            class="form-control-solid   @error('balance') form-control-feedback @enderror"
                            name="balance"
                            value="{{ $network->balance }}"
                            placeholder="{{ __('balance') }}" id="balance"/>
                        @error('balance')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endif
            </div>
            @if($network->type == "Crypto")
            <div class="row fv-row py-2">
                <div class="col-12">
                    <x-label class="" label="{{ __('Crypto Balance') }}" for="crypto_balance"/>
                    <x-input
                        class="form-control-solid   @error('crypto_balance') form-control-feedback @enderror"
                        name="crypto_balance"
                        value="{{ $network->crypto_balance }}"
                        placeholder="{{ __('crypto_balance') }}" id="crypto_balance"/>
                    @error('crypto_balance')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-12">
                    <x-label class="" label="{{ __('Exchange Rate') }}" for="exchange_rate"/>
                    <x-input
                        class="form-control-solid   @error('exchange_rate') form-control-feedback @enderror"
                        name="exchange_rate"
                        value="{{ $network->exchange_rate }}"
                        placeholder="{{ __('exchange_rate') }}" id="exchange_rate"/>
                    @error('exchange_rate')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            @endif
            <div class="row fv-row py-2">
                <div class="col-12">
                    <x-label class="" label="Select Location" for="location_code"/>
                    <x-select2
                        name="location_code"
                        placeholder="{{ __('Select a location') }}"
                        id="location">

                        @foreach($locations as $location)
                            <option
                                @selected($location->code == $network->location_code)
                                value="{{ $location->code }}">{{ $location->name }}</option>
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
                <div class="col-12">
                    <x-label label="description" required="" for="description"/>
                    <textarea name="description" class="form-control form-control form-control-solid" rows="3"
                              data-kt-autosize="false">{{ $network->description }}</textarea>
                    @error('description')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        <div class="modal-footer">

            <x-submit-button type="button" id="update-network-button" class="btn btn-primary" label="Update Network" />
        </div>
    </form>



    @push('js')
        <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

        <script>

            if(jQuery("#type").val() == "Crypto"){
                var validations = [
                    {"name" : "name", "validators" : {}},
                    {"name" : "location_code", "validators" : {}},
                    {"name" : "crypto_balance", "validators" : {}},
                    {"name" : "exchange_rate", "validators" : {}},
                ];
            } else {
                var validations = [
                    {"name" : "name", "validators" : {}},
                    {"name" : "location_code", "validators" : {}},
                    {"name" : "agent_no", "validators" : {}},
                    {"name" : "balance", "validators" : {}},
                ];
            }
            const form = document.getElementById('update-network-form');


            const submitButton = document.getElementById('update-network-button');


            lakoriValidation(validations, form, submitButton, 'post', '{{  route('agency.networks.update', $network) }}');

        </script>
    @endpush


</div>
