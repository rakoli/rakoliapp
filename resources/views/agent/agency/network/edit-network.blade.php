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
                        id="type">

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
            </div>
            <div class="row fv-row py-2">
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
            </div>
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

            const validations = [
                {"name" : "name", "errors" : "Network name is required", "validators" : {}},
                {"name" : "location_code", "errors" : "Location Code is required", "validators" : {}},
                {"name" : "agent_no", "errors" : "Agent No is required", "validators" : {}},
                {"name" : "balance", "errors" : "Balance is required", "validators" : {}},
            ];

            const form = document.getElementById('update-network-form');


            const submitButton = document.getElementById('update-network-button');


            lakoriValidation(validations, form, submitButton, 'post', '{{  route('agency.networks.update', $network) }}');

        </script>
    @endpush


</div>
