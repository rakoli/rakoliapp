@extends('layouts.users.agent')

@section('title', "Shift")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Agency</small>
    <!--end::Description-->
@endsection

@section('content')

    <div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
        <!--begin::Container-->
        <div class="container d-flex flex-column flex-lg-row" id="kt_docs_content_container">
            <!--begin::Card-->
            <div class="card card-docs flex-row-fluid mb-2" id="kt_docs_content_card">
                <!--begin::Card Body-->
                <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
                    <div>

                        <x-back
                            :route="route('agency.shift') "
                            />

                        <form method="post" id="openShift" action="{{ route('agency.shift.open.store') }}">
                            @csrf
                            <div class="row fv-row py-2">

                                <div class="col-6">
                                    <x-label class="" label="{{ __('Location') }}" for="location"/>
                                    <x-select2
                                        class="@error('location_code') form-control-error @enderror"
                                        name="location_code"
                                        placeholder="{{ __('Select a location') }}"
                                        id="location_code">
                                        <option value="">{{ __('Select location ') }}</option>

                                        @foreach($locations as $location)
                                            <option
                                                value="{{ $location['code'] }}"
                                                data-balance="{{  $location['balance'] }}"
                                                data-networks="{{ json_encode($location['networks'] , true) }}"
                                            >{{ $location['name'] }}</option>
                                        @endforeach
                                    </x-select2>
                                    <x-helpertext> {{ __("Location for this Shift") }}</x-helpertext>
                                    @error('location_code')
                                    <div class="help-block text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                                <div class="col-6">
                                    <x-label class="" label="{{ __('Cash At Hand') }}" for="amount"/>
                                    <x-input
                                        type="number"
                                        class="form-control-solid   @error('cash_at_hand') form-control-feedback @enderror"
                                        name="cash_at_hand"
                                        placeholder="{{ __('cash at hand') }}"
                                        readonly="readonly"
                                        id="amount"/>
                                    <x-helpertext> {{ __("Current cash you have in this Location") }}</x-helpertext>
                                    @error('cash_at_hand')
                                    <div class="help-block text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                            </div>
                            <div class="row fv-row py-3 bg-gray-100 px-4 py-4">


                                <div class="col-12 py-3">

                                    <fieldset class="table-responsive">
                                        <legend>
                                            {{ __("Tills") }}
                                        </legend>
                                        <table class="table table-striped">


                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Balance</th>
                                            </tr>
                                            </thead>
                                            <tbody id="shift-table-body">
                                            {{-- @foreach($tills as $till)
                                                 <tr>
                                                     <td>{{ $till->agency?->name }}</td>
                                                     <td>{{ number_format($till->balance , 2) }}</td>
                                                 </tr>
                                             @endforeach--}}
                                            </tbody>
                                        </table>
                                    </fieldset>

                                </div>

                            </div>

                            <div class="row fv-row py-3">
                                <div class="col-12">
                                    <x-label label="Description" class="" for="description"/>
                                    <textarea
                                        name="description"
                                        class="form-control form-control form-control-solid"
                                        rows="3"
                                        data-kt-autosize="false"></textarea>
                                    <x-helpertext> {{ __("What would like to note about this shift, max length: 255 characters") }}</x-helpertext>
                                    @error('description')
                                    <div class="help-block text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <x-label required="" label="Notes" class="" for="notes"/>
                                    <textarea
                                        name="notes"
                                        class="form-control form-control form-control-solid" rows="3"
                                        data-kt-autosize="false"></textarea>
                                    <x-helpertext> {{ __("Do you have extra note?, max length: 255 characters ") }}</x-helpertext>
                                    @error('notes')
                                    <div class="help-block text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <x-submit-button
                                    type="button"
                                    class="btn btn-primary"
                                    label="Open Shift"
                                    id="open-shift-button"

                                />
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

        <script>


            $("select#location_code").on("change", function () {

                let selectedOption = $(this).find(":selected");
                let balance = selectedOption.data("balance");

                let networks = selectedOption.data('networks');

                let tableBody = "";

                $("#shift-table-body").empty();

                $.each(networks, (index, network) => {
                    tableBody += "<tr>" +
                        " <td>" + network.name + "</td> " +
                        "<td>" + network.balance.toLocaleString('en-US', {maximumFractionDigits: 2}) + "</td>" +
                        " </tr>"

                });


                $("table>tbody#shift-table-body").append(tableBody);


                $("input#amount").val(balance);
            });

            const validations = [
                {"name": "description", "error": "Description Field is Required", "validators": {}},
                {"name": "location_code", "error": "Location Field is Required", "validators": {}},
                {"name": "cash_at_hand", "error": "Cash Field is Required", "validators": {}},
            ];

            const form = document.getElementById('openShift');


            const submitButton = document.getElementById('open-shift-button');


            lakoriValidation(validations, form, submitButton, 'post', '{{  route('agency.shift.open.store') }}');


        </script>

    @endpush

@endsection
