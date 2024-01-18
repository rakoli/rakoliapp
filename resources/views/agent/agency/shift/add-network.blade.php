<div>
    <form wire:submit.prevent="addNetwork">

        <div class="modal-body">

            <div class="row fv-row py-2">

                <div class="col-6">
                    <x-label class="" label="{{ __('Name') }}" for="name"/>
                    <x-input
                        class="form-control-solid   @error('name') form-control-feedback @enderror"
                        wire:model.blur="name"
                        placeholder="{{ __('name') }}" id="name"/>
                    @error('name')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-6">

                        <x-label class="" label="Select Agent" for="fsp_code"/>
                        <x-select2
                            class="form-control-solid w-100 form-control @error('fsp_code') form-control-error @enderror"
                            wire:model.blur="fsp_code"
                            placeholder="{{ __('Select a Agency') }}"
                            id="fsp_code">
                            <option value="">{{ __('Select Agency ') }}</option>

                            @foreach($agencies as $agency)
                                <option value="{{ $agency->code }}">{{ $agency->name }}</option>
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
                <div class="col-6">
                        <x-label class="" label="{{ __('Agent No') }}" for="agent_no"/>
                        <x-input
                            class="form-control-solid   @error('agent_no') form-control-feedback @enderror"
                            wire:model.blur="agent_no"
                            placeholder="{{ __('agent_no') }}" id="agent_no"/>
                        @error('agent_no')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                <div class="col-6">
                        <x-label class="" label="{{ __('Balance') }}" for="balance"/>
                        <x-input
                            class="form-control-solid   @error('balance') form-control-feedback @enderror"
                            wire:model.blur="balance"
                            placeholder="{{ __('balance') }}" id="balance"/>
                        @error('balance')
                        <div class="help-block text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
            </div>
            <div class="row fv-row py-2">
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
</div>
