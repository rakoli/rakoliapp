<div class="d-flex flex-column gap-10">

    <div class="row fv-row py-3">
        <div class="">
            <x-label label="description" class="" for="description"/>
            <textarea
                name="description"
                id="closing_description"
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
        @if($shift->status == App\Utils\Enums\ShiftStatusEnum::OPEN)
        <x-modal_with_button
            modalTitle="Shift Transfer details"
            targetId="transfer_shift"
            label="Transfer Shift"
            size="modal-lg"
            btnClass="btn  btn-light-primary mt-sm-4 mt-md-6"
        >

            @include('agent.agency.shift._short_form')
            <div class="col-6 mt-4" id="transfer_shift_user_code">
                <x-label label="User" required="" for="transfer_shift_user_code"/>
                <x-select2
                    modalId="transfer_shift"
                    id="transfer_shift_user_code"
                    class="total_shorts_input"
                    name="transfer_user_code"
                >
                    @foreach($colleague as $col)
                        <option value="{{ $col->code }}">{{ $col->name() }}</option>
                    @endforeach

                </x-select2>
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

            @include('agent.agency.shift._short_form')
            <div class="col-6 mt-4" id="close_shift_info">
                <p class="shift_info">The total loans on this shift is {total loan amount}</p>
                <strong>Closing Remarks</strong>
                <p class="close_info">description entered on closing page</p>
            </div>

            <x-submit-button type="button" id="close-shift-button" class="btn btn-primary mt-sm-4 mt-md-6"
                             label="Close Shift"/>

        </x-modal_with_button>
        @endif
    </div>


    @push('js')
        <script>
            const validations = [
                {"name": "description", "error": "Description Field is Required", "validators": {}},
                {"name": "location_code", "error": "Location Field is Required", "validators": {}},
                {"name": "description", "error": "Description Field is Required", "validators": {}},
            ];

            const form = document.getElementById('close-shift');


            const closeShiftButton = document.getElementById('close-shift-button');

            lakoriValidation(validations, form, closeShiftButton, 'post', '{{  route('agency.shift.close.store', $shift) }}', '{{ route('agency.shift') }}');


            const transferShiftButton = document.getElementById('transfer-shift-button');
            lakoriValidation(validations, form, transferShiftButton, 'post', '{{  route('agency.shift.transfer', $shift) }}', '{{ route('agency.shift') }}');
        </script>

    @endpush

</div>
