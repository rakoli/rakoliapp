<div>
    <form method="post" id="close-shift" action="{{ route('agency.shift.close.store') }}">
        @csrf

        <div class="modal-body">

            <div class="row fv-row py-2">
                <div class="col-6">
                    <x-label class="" label="{{ __('Closing Balance') }}" for="closing_balance"/>
                    <x-input
                        type="number"
                        class="form-control-solid
                         @error('closing_balance') form-control-feedback @enderror"

                        name="closing_balance"
                        value="{{ $shift->cash_end }}"
                        placeholder="{{ __('Closing Balance') }}" id="closing_balance"/>
                    @error('closing_balance')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6">
                    <x-label class="" label="{{ __('location') }}" for="location"/>
                    <x-select2
                        name="location_code"
                        placeholder="{{ __('Select a location') }}"
                        id="location">
                        <option value="">{{ __('Select location ') }}</option>

                        @foreach($locations as $location)
                            <option value="{{ $location->code }}"
                                    @selected($shift->location_code == $location->code)

                            >{{ $location->name }}</option>
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



                @foreach($tills as $till)
                    <div class="col-6 py-3">
                        <x-label class="" label="{{ __($till->network?->agency?->name) }}" :for="$till->id"/>
                        <x-input class="form-control-solid"
                                 name="tills[{{ $till->network_code }}]"
                                 value="{{ $till->balance_new }}"
                                 placeholder="{{ __($till->balance_new) }}"
                                 id="{{ $till->id }}
                                                         "/>
                    </div>

                @endforeach

            </div>

            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="description" class="" for="description"/>
                    <textarea name="description" class="form-control form-control form-control-solid" rows="3"  data-kt-autosize="false"></textarea>
                    @error('description')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="notes" required="" for="notes"/>
                    <textarea name="notes" class="form-control form-control form-control-solid" rows="3"  data-kt-autosize="false"></textarea>
                    @error('notes')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>


        <div class="modal-footer my-4">
            <x-submit-button type="button" id="close-shift-button" class="btn btn-primary" label="Close Shift"/>
        </div>

    </form>


    @push('js')
        <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

        <script>

            const validations = [
                { "name": "description", "error"  :  "Description Field is Required", "validators" : {} },
                { "name": "location_code", "error"  :  "Location Field is Required", "validators" : {}  },
                { "name": "description", "error"  :  "Description Field is Required" ,"validators" : {}  },
            ];

            const form = document.getElementById('close-shift');


            const submitButton = document.getElementById('close-shift-button');


            lakoriValidation(validations, form, submitButton, 'post', '{{  route('agency.shift.close.store', $shift) }}');


        </script>

    @endpush

</div>
