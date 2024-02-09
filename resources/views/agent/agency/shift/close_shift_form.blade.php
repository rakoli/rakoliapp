<div class="d-flex flex-column gap-10">

    <div class="row fv-row py-3">
        <div class="">
            <x-label label="description" class="" for="description"/>
            <textarea
                name="description"
                class="form-control form-control form-control-solid"
                rows="3"
                data-kt-autosize="false">{{ $shift->description }}</textarea>
            @error('description')
            <div class="help-block text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row fv-row py-3">
        <div class="">
            <x-label label="notes" required="" for="notes"/>
            <textarea
                name="notes" class="form-control form-control form-control-solid"
                rows="3"
                data-kt-autosize="false">{{ $shift->note }}</textarea>
            @error('notes')
            <div class="help-block text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="d-flex gap-3 flex-row align-content-between">

        <x-modal_with_button
            modalTitle="Shift Transfer details"
            targetId="transfer_shift"
            label="Transfer Shift"
            size="modal-lg"
            btnClass="btn  btn-light-primary mt-sm-4 mt-md-6"
        >

            <div class="shift-has-shorts">
                <div class="row fv-row py-3">
                    <div class="col-6">
                        <x-label label="Short Amount" required="" for="short value"/>
                        <x-input
                            readonly="readonly"
                            class="total_shorts_input"
                        />
                    </div>
                    <div class="col-6">
                        <x-label label="Shift Type" required="" for="shift_type"/>
                        <x-select2
                            modalId="transfer_shift"
                            id="select_shift_type"
                            readonly="readonly"
                            class="total_shorts_input"
                            name="short_type"                       >

                            @foreach(\App\Utils\Enums\ShortTypeEnum::cases() as $typeEnum)
                                <option value="{{ $typeEnum->value }}">{{ $typeEnum->value }}</option>
                            @endforeach


                        </x-select2>
                    </div>

                    <div class="col-6 mt-4" id="shift_network_code">
                        <x-label label="Shift Type" required="" for="shift_network_code"/>
                        <x-select2
                            modalId="transfer_shift"
                            id="shift_network_code"
                            readonly="readonly"
                            class="total_shorts_input"
                            name="short_network_code"
                        >
                            @foreach($networks as  $name  => $network)
                                <option value="{{ $network['code'] }}">{{ $name }}</option>
                            @endforeach

                        </x-select2>
                    </div>
                </div>
            </div>

            <x-submit-button type="button" id="transfer-shift-button" class="btn btn-primary mt-sm-4 mt-md-6"
                             label="Confirm Transfer Shift"/>

        </x-modal_with_button>

        <x-modal_with_button
            modalTitle="Shift Summary"
            targetId="summary"
            label="Close shift"
            size="modal-lg"
            btnClass="btn  btn-danger mt-sm-4 mt-md-6"
        >


            <x-submit-button type="button" id="close-shift-button" class="btn btn-primary mt-sm-4 mt-md-6"
                             label="Close Shift"/>

        </x-modal_with_button>

    </div>


    @push('js')
        <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

        <script>

            const validations = [
                {"name": "description", "error": "Description Field is Required", "validators": {}},
                {"name": "location_code", "error": "Location Field is Required", "validators": {}},
                {"name": "description", "error": "Description Field is Required", "validators": {}},
            ];

            const form = document.getElementById('close-shift');


            const closeShiftButton = document.getElementById('close-shift-button');

            lakoriValidation(validations, form, closeShiftButton, 'post', '{{  route('agency.shift.close.store', $shift) }}');


            const transferShiftButton = document.getElementById('transfer-shift-button');
            lakoriValidation(validations, form, transferShiftButton, 'post', '{{  route('agency.shift.transfer', $shift) }}');
        </script>

    @endpush

</div>
