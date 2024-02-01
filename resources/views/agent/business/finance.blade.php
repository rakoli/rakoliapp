@extends('layouts.users.agent')

@section('title', __('Finance'))

@section('header_js')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.business._submenu_business')

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">

                    <div class="card-body pt-5 pb-5">
                        <div class="fw-bold text-center">{{__("Balance")}}</div>
                        <div class="text-gray-600 text-center fw-bold">
                            {{ number_format($balance[0]->balance) }}
                        </div>
                    </div>

                    <!--end::Details toggle-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <div class="card-body pt-5 pb-5">

                        <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#update_method_modal">
                            {{ __('Update Method') }}
                        </button>

                        <button type="button" class="btn btn-primary m-1" id="withdrawButton">
                            {{ __('Withdraw') }}
                        </button>

                    </div>

                    <!--end::Details toggle-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">

                            <div class="py-5 fs-6">
                                <div class="fw-bold mt-5">{{ __('Method Name') }}</div>
                                <div class="text-gray-600">
                                    {{ old('method_name', $existingData[0]->method_name ?? 'Not mention') }}
                                </div>

                                <div class="fw-bold mt-5">{{ __('Method AC Name') }}</div>
                                <div class="text-gray-600">
                                    {{ old('method_ac_name', $existingData[0]->method_ac_name ?? 'Not mention') }}
                                </div>

                                <div class="fw-bold mt-5">{{ __('Method AC Number') }}</div>
                                <div class="text-gray-600">
                                    {{ old('method_ac_number', $existingData[0]->method_ac_number ?? 'Not mention') }}
                                </div>

                                <div class="fw-bold mt-5">{{ __('Amount Currency') }}</div>
                                <div class="text-gray-600">
                                    {{ old('amount_currency', $existingData[0]->amount_currency ?? 'Not mention') }}
                                </div>

                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>

                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!--begin::Table-->
                <div class="card card-flush">

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table container-->
                        <div class="table-responsive">

                            {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4'], true) !!}

                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            </div>
            <!--end::Content-->

        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->
    <!--begin::Modal group-->
    <div class="modal fade" tabindex="-1" id="update_method_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Update Withdraw Details') }}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form class="my-auto pb-5" action="{{ route('business.finance.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{ __('Name') }}</span>
                                <input name="method_name" type="text" class="form-control"
                                    value="{{ old('method_name', $existingData[0]->method_name ?? '') }}" value=""
                                    placeholder="{{ __('enter method name') }}" />
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{ __('AC Name') }}</span>
                                <input name="method_ac_name" type="text" class="form-control"
                                    value="{{ old('method_ac_name', $existingData[0]->method_ac_name ?? '') }}"
                                    value="" placeholder="{{ __('enter method ac name') }}" />
                                {{-- <textarea name="description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"></textarea> --}}
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{ __('AC Number') }}</span>
                                <input name="method_ac_number" type="text" class="form-control"
                                    value="{{ old('method_ac_number', $existingData[0]->method_ac_number ?? '') }}"
                                    value="" placeholder="{{ __('enter method ac number') }}" />
                                {{-- <textarea name="description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"></textarea> --}}
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal group-->


    <!--begin::Modal group-->
    <div class="modal fade" tabindex="-1" id="withdraw_method_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Add Withdraw Fund Details') }}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="withdrawForm" class="my-auto pb-5" action="{{ route('business.finance.withdraw') }}"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{ __('Amount') }}</span>
                                <input name="amount" type="number" class="form-control"
                                    placeholder="{{ __('enter amount') }}" />
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{ __('Description') }}</span>
                                <textarea name="description" type="text" class="form-control" placeholder="{{ __('enter description') }}"></textarea>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary"
                            id="openConfirmationModal">{{ __('Update') }}</button>
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal group-->
    <!-- Confirmation Modal -->
    <div class="modal fade" tabindex="-1" id="confirmation_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure for processing withdraw request?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmWithdraw">Yes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="Messages">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="modalMessage">   </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ok</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {!! $dataTableHtml->scripts() !!}

    <script>
        // Message modal //
        $(document).ready(function() {
            $('#withdrawButton').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('business.finance.check_method') }}',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.message === 'Withdrawal method exists') {
                            $('#withdraw_method_modal').modal('show');
                        } else {
                            $('#Messages').modal('show');
                            $('#modalMessage').text('Please update the withdraw method on left side before submitting withdraw request.').css('color', 'red');
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });

        document.getElementById('openConfirmationModal').addEventListener('click', function() {
            // Hide the first modal
            $('#withdraw_method_modal').modal('hide');
            // Show the confirmation modal
            $('#confirmation_modal').modal('show');
        });

        document.getElementById('confirmWithdraw').addEventListener('click', function() {
            // Submit the form when "Yes" is clicked
            document.getElementById('withdrawForm').submit();
        });

        // // Event handler for the "No" button in the confirmation modal
        // document.getElementById('confirmation_modal').addEventListener('hidden.bs.modal', function () {
        //     // Show the first modal when the confirmation modal is hidden
        //     $('#withdraw_method_modal').modal('show');
        // });

    </script>

@endsection
