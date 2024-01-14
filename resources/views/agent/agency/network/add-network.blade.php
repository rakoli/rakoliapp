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
                        placeholder="{{ __('name') }}" id="name"/>
                    @error('name')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-6">

                    <x-label class="" label="Select Agent" for="fsp_code"/>
                    <select
                        data-control="select2"
                        data-dropdown-parent="#add-network"
                        class="form-control-solid w-100 form-control @error('fsp_code') form-control-error @enderror"
                        name="fsp_code"
                        placeholder="{{ __('Select a Agency') }}"
                        id="fsp_code">

                        @foreach($agencies as $agency)
                            <option value="{{ $agency->code }}">{{ $agency->name }}</option>
                        @endforeach
                    </select>
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
                        name="agent_no"
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
                        name="balance"
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
                    <select
                        class="form-select"
                        data-control="select2"
                        data-dropdown-parent="#add-network"
                        modalId="#add-network"
                        name="location_code"
                        placeholder="{{ __('Select a location') }}"
                        id="location">

                        @foreach($locations as $location)
                            <option value="{{ $location->code }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
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
                    <textarea name="notes" class="form-control form-control form-control-solid" rows="3"
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

            <button type="button" id="add-network-button" class="btn btn-primary">Add Network</button>
        </div>
    </form>



    @push('js')
        <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

        <script>
            $("button#add-network-button").click(function (event){
                event.preventDefault();

                submitForm(
                    $("form#add-network-form"),
                    "{{ route('agency.networks.store') }}"
                );

            });
        </script>
    @endpush


</div>
