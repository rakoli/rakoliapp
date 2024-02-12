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

            @include('agent.agency.shift._short_form')

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

            @include('agent.agency.shift._short_form')


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
