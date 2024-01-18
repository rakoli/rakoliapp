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

                        <x-a-button
                            class="btn-google text-gray-100"
                            route="{{ route('agency.shift') }}"
                        >
                            <i class="bi bi-arrow-left"></i>

                            {{ __('Back ') }}
                        </x-a-button>

                            <form method="post" id="openShift" action="{{ route('agency.shift.open.store') }}">
                                @csrf
                                <div class="row fv-row py-2">

                                    <div class="col-6">
                                        <x-label class="" label="{{ __('location') }}" for="location"/>
                                        <x-select2
                                            class="@error('location_code') form-control-error @enderror"
                                            name="location_code"
                                            placeholder="{{ __('Select a location') }}"
                                            id="location">
                                            <option value="">{{ __('Select location ') }}</option>

                                            @foreach($locations as $location)
                                                <option
                                                    value="{{ $location->code }}"
                                                    data-balance="{{  $location->balance }}"
                                                >{{ $location->name }}</option>
                                            @endforeach
                                        </x-select2>
                                        @error('location_code')
                                        <div class="help-block text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>


                                    <div class="col-6">
                                        <x-label class="" label="{{ __('Cash at hand') }}" for="amount"/>
                                        <x-input
                                            type="number"
                                            class="form-control-solid   @error('cash_at_hand') form-control-feedback @enderror"
                                            name="cash_at_hand"
                                            placeholder="{{ __('cash at hand') }}"
                                            readonly="readonly"
                                            id="amount"/>
                                        @error('cash_at_hand')
                                        <div class="help-block text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="row fv-row py-3 bg-gray-100 px-4 py-4">


                                        <div class="col-12 py-3">

                                            <fieldset>
                                                <legend>
                                                    {{ __("Tills") }}
                                                </legend>
                                                <table class="table table-striped wrapper">


                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Balance</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($tills as $till)
                                                        <tr>
                                                            <td>{{ $till->agency?->name }}</td>
                                                            <td>{{ number_format($till->balance , 2) }}</td>
                                                        </tr>
                                                    @endforeach
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
                                        @error('description')
                                        <div class="help-block text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <x-label required="" label="notes" class="" for="notes"/>
                                        <textarea
                                            wire:model="notes"
                                            name="notes"
                                            class="form-control form-control form-control-solid" rows="3"
                                            data-kt-autosize="false"></textarea>
                                        @error('notes')
                                        <div class="help-block text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="modal-footer">

                                    <button type="button" onclick="submitOpenShiftForm()" class="btn btn-primary">

                                        {{ __('Open Shift') }}
                                    </button>
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


            $("select#location").on("change", function (){

                var selectedOption = $(this).find(":selected");


                var balance = selectedOption.data("balance");


                $("input#amount").val(balance);
            });



            function submitOpenShiftForm() {

                submitForm(
                    $("form#openShift"),
                    "{{ route('agency.shift.open.store') }}"
                );

            }

        </script>

    @endpush

@endsection
