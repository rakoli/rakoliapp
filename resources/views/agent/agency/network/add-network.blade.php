<div>
    <form method="post" id="add-network-form">
        @csrf
        <div class="modal-body">

            <div class="row fv-row py-2">

                <div class="col-6">
                    <x-label class="" label="{{ __('Name') }}" for="name"/>
                    <x-input
                        class="form-control-solid   @error('name') form-control-feedback @enderror"
                        name="name"
                        placeholder="{{ __('name') }}"
                        id="name"
                    />
                    <x-helpertext>{{ __('Till Name E.G: M-Pesa') }}</x-helpertext>
                    @error('name')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-6">

                    <x-label
                        class=""
                        label="Select Network Provider"
                        for="fsp_code"
                    />
                    <x-select2
                        modalId="add-network"
                        name="fsp_code"
                        placeholder="{{ __('Select a Network Provider') }}"
                        id="fsp_code"
                    >
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->code }}">{{ $agency->name }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __('Till Provider E.G: Equity Bank') }}</x-helpertext>
                    @error('fsp_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-2">
                <div class="col-6">
                    <x-label
                        class=""
                        label="{{ __('Agent No') }}"
                        for="agent_no"
                    />
                    <x-input
                        class="form-control-solid   @error('agent_no') form-control-feedback @enderror"
                        name="agent_no"
                        placeholder="{{ __('agent_no') }}"
                        id="agent_no"
                    />
                    <x-helpertext>{{ __('Till Agency No:') }}</x-helpertext>
                    @error('agent_no')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6">
                    <x-label
                        class=""
                        label="{{ __('Balance') }}"
                        for="balance"
                    />
                    <x-input
                        class="form-control-solid   @error('balance') form-control-feedback @enderror"
                        name="balance"
                        placeholder="{{ __('balance') }}"
                        id="balance"
                    />
                    <x-helpertext>{{ __('Till Current Balance: Note this cannot be updated after you start transcating') }}</x-helpertext>
                    @error('balance')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-2">
                <div class="col-6">
                    <x-label
                        class=""
                        label="Select Location"
                        for="location_code"
                    />
                    <x-select2
                        modalId="add-network"
                        name="location_code"
                        placeholder="{{ __('Select a Location') }}"
                        id="location_code"
                    >

                        @foreach($locations as $location)
                            <option value="{{ $location->code }}">{{ $location->name }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __('This Till belongs to which Branch?') }}</x-helpertext>
                    @error('location_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label
                        label="description"
                        required=""
                        for="description"
                    />
                    <textarea name="description" class="form-control form-control form-control-solid" rows="3"
                              data-kt-autosize="false"></textarea>
                    <x-helpertext>{{ __('Anything to note about this Till? Max length: 255') }}</x-helpertext>
                    @error('description')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">

            <x-submit-button type="button" id="add-network-button" class="btn btn-primary" label="Add Network"/>
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

          const form = document.getElementById('add-network-form');


          const submitButton = document.getElementById('add-network-button');


          lakoriValidation(validations, form, submitButton, 'post', '{{  route('agency.networks.store') }}');
        </script>
    @endpush


</div>
