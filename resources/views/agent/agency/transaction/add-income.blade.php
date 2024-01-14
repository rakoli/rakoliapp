<div>
    <form method="post" id="add-income-form">

        @csrf
        <div class="modal-body">

            <div class="row fv-row py-2">
                <div class="col-6">
                    <x-label class="" label="{{ __('Amount') }}" for="amount"/>
                    <x-input
                        class="form-control-solid   @error('amount') form-control-feedback @enderror"
                           name="amount"
                        placeholder="{{ __('amount') }}" id="amount"/>
                    @error('amount')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6">
                    <x-label class="" label="Select Location" for="location_code"/>
                    <select
                        data-control="select2"
                        data-dropdown-parent="#add-income"
                        class="form-control-solid  form-control @error('location_code') form-control-error @enderror"
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

                <div class="col-6">
                    <x-label class="" label="Select Network" for="till_code"/>
                    <x-select2
                        class="form-control-solid  form-control @error('till_code') form-control-error @enderror"
                        name="till_code"
                        modalId="add-income"
                        placeholder="{{ __('Select a location') }}"
                        id="till_code">


                        @foreach($tills as $till)
                            <option value="{{ $till->network_code }}">{{ $till->network?->agency?->name }}</option>
                        @endforeach
                    </x-select2>
                    @error('till_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label label="notes" class="" for="notes"/>
                    <textarea    name="notes" class="form-control form-control form-control-solid" rows="3"  data-kt-autosize="false"></textarea>
                    @error('notes')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>


        <div class="modal-footer my-2">

            <button type="button" id="add-income-button" class="btn btn-primary">Save changes</button>
        </div>

    </form>

    @push('js')

        <script>
            $("button#add-income-button").click(function (event){
                event.preventDefault();

                submitForm(
                    $("form#add-income-form"),
                    "{{ route('agency.transactions.add.income', $shift) }}"
                );

            });
        </script>
    @endpush
</div>
