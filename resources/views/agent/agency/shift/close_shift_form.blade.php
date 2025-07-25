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
            modalTitle="{{ __('general.LBL_SHIFT_TRANSFER') }}"
            targetId="transfer_shift"
            label="{{ __('general.LBL_TRANSFER_SHIFT') }}"
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
                             label="{{ __('general.LBL_CONFIRM_SHIFT_TRANSFER') }}"/>

        </x-modal_with_button>

        <x-modal_with_button
            modalTitle="{{ __('general.LBL_SHIFT_SUMMARY') }}"
            targetId="summary"
            label="{{ __('general.LBL_CLOSE_SHIFT') }}"
            size="modal-lg"
            btnClass="btn  btn-danger mt-sm-4 mt-md-6"
        >

            @include('agent.agency.shift._short_form')
            <div class="col-6 mt-4" id="close_shift_info">
                <p class="shift_info">The total loans on this shift is {total loan amount}</p>
                <strong>{{ __('general.LBL_CLOSING_REMARKS') }}</strong>
                <p class="close_info">description entered on closing page</p>
            </div>

            <x-submit-button type="button" id="close-shift-button" class="btn btn-primary mt-sm-4 mt-md-6"
                             label="{{ __('general.LBL_CLOSE_SHIFT') }}"/>

        </x-modal_with_button>
        @endif
    </div>


    @push('js')
        <script>
            jQuery(document).on("click","#close-shift-button", function(){

                if(jQuery("body").hasClass('has_short')){
                    var validations = [
                        {"name": "description", "error": "Description Field is Required", "validators": {}},
                        {"name": "location_code", "error": "Location Field is Required", "validators": {}},
                        {"name": "short_description", "error": "Short Description Field is Required", "validators": {}},
                    ];
                } else {
                    var validations = [
                        {"name": "description", "error": "Description Field is Required", "validators": {}},
                        {"name": "location_code", "error": "Location Field is Required", "validators": {}},
                    ];

                }

                const closeShiftForm = document.getElementById('close-shift');
                const closeShiftButton = document.getElementById('close-shift-button');
                lakoriValidation(validations, closeShiftForm, closeShiftButton, 'post', '{{  route('agency.shift.close.store', $shift) }}', '{{ route('agency.shift') }}',true);
            });
            jQuery(document).on("click","#transfer-shift-button", function(){
                if(jQuery("body").hasClass('has_short')){
                    var validations = [
                        {"name": "description", "error": "Description Field is Required", "validators": {}},
                        {"name": "location_code", "error": "Location Field is Required", "validators": {}},
                        {"name": "short_description", "error": "Short Description Field is Required", "validators": {}},
                    ];
                } else {
                    var validations = [
                        {"name": "description", "error": "Description Field is Required", "validators": {}},
                        {"name": "location_code", "error": "Location Field is Required", "validators": {}},
                    ];

                }
                const transferShiftForm = document.getElementById('close-shift');
                const transferShiftButton = document.getElementById('transfer-shift-button');
                lakoriValidation(validations, transferShiftForm, transferShiftButton, 'post', '{{  route('agency.shift.transfer', $shift) }}', '{{ route('agency.shift') }}',true);
            });
        </script>

    @endpush

</div>
