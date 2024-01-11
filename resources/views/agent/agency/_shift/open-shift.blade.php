<div>

    @if($hasOpenShift)
        <x-empty
            heading="There is an opened Shift, Close it to open a new shift">
            <x-button
                wire:click="closeShift"
                class="btn-danger">
                Close Shift
            </x-button>
        </x-empty>
    @else

        <form method="post" id="openShift" action="{{ route('agency.shift.store') }}">
            @csrf
            <div class="row fv-row py-2">
                <div class="col-6">
                    <x-label class="" label="{{ __('Cash at hand') }}" for="amount"/>
                    <x-input
                        class="form-control-solid   @error('cash_at_hand') form-control-feedback @enderror"
                        wire:model.blur="cash_at_hand"
                        name="cash_at_hand"
                        placeholder="{{ __('cash at hand') }}" id="amount"/>
                    @error('cash_at_hand')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6">
                    <x-label class="" label="{{ __('location') }}" for="location"/>
                    <select
                        class="form-control-solid  form-control @error('location_code') form-control-error @enderror"
                        wire:model.blur="location_code"
                        name="location_code"
                        placeholder="{{ __('Select a location') }}"
                        id="location">
                        <option value="">{{ __('Select location ') }}</option>

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

                @foreach($tills as $till)
                    <div class="col-6 py-3">
                        <x-label class="" label="{{ __($till->agency->name) }}" :for="$till->id"/>
                        <x-input class="form-control-solid"
                                 readonly="readonly"
                                 disabled="disabled"
                                 value="{{ $till->balance }}"
                                 placeholder="{{ __($till->balance) }}"
                                 id="{{ $till->id }}
                                                         "/>
                    </div>

                @endforeach

            </div>

            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="notes" class="" for="notes"/>
                    <textarea
                        wire:model="notes"
                        name="notes"
                        class="form-control form-control form-control-solid" rows="3"  data-kt-autosize="false"></textarea>
                    @error('notes')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="submitForm()" class="btn btn-primary">Save changes</button>
            </div>


        </form>

    @endif

    @push('js')

        <script>
            function submitForm() {

                var formData = new FormData($("form#openShift")[0])


                console.log(formData);


                fetch("{{ route('agency.shift.store') }}", {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {

                        console.log(response)
                        if(! response.ok)
                        {
                            SwalAlert(
                                "warning",
                                "Failed to Open Shift"
                            );

                        }
                        return response.json();
                    }) // Assuming server responds with JSON
                    .then(data => {
                        SwalAlert(
                            "success",
                            data.message
                        );

                        setTimeout(function() {
                            window.location.reload();
                        }, 500);



                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        console.error('Error:', error.data);
                        SwalAlert(
                            "warning",
                            error.message
                        );
                    });
            }
        </script>

    @endpush



</div>
