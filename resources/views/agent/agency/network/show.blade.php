@extends('layouts.users.agent')

@section('title', "Show Nwtwork")



@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Network</small>
    <!--end::Description-->
@endsection


@section('content')

    <div class="d-flex flex-column flex-column-fluid">


        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">


            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">

                        <div class="card pt-4 mb-6 mb-xl-9">
                            <div class="card-body px-4 py-15">
                                @include('agent.agency.network.edit-network')
                            </div>
                        </div>

                    </div>
                    <!--end::Sidebar-->

                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">


                        <!--begin:::Tab content-->
                        <div class="tab-content" id="myTabContent">
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Network Details</h2>
                                        </div>
                                        <!--end::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar d-flex flex-row g-6">

                                            <div class="d-flex justify-content-end gap-2"
                                                 data-kt-docs-table-toolbar="base">
                                                <x-modal_with_button
                                                    targetId="delete-network"
                                                    label="Delete Network"
                                                    modalTitle="{{ __('ARE YOU SURE YOU WANT TO DELETE NETWORK') }}"
                                                    btnClass="btn btn-danger"
                                                    size="modal-md"
                                                >

                                                    <form id="delete-network-form" method="post">
                                                        @method('delete')
                                                        @csrf

                                                        {{--<div class="row fv-row py-2">

                                                            <div class="col-12">
                                                                <x-label class="" label="{{ __("Type the word 'DELETE' to continue") }}" for="name"/>
                                                                <x-input
                                                                    class="form-control   @error('name') form-control-feedback @enderror"
                                                                    name="name"
                                                                    placeholder="{{ __('DELETE') }}"
                                                                    id="name"/>
                                                                @error('name')
                                                                <div class="help-block text-danger">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>--}}

                                                        <!--end::Description-->
                                                        <div class="modal-footer">
                                                            <button type="button" data-bs-dismiss="modal"
                                                                    class="btn btn-primary">Cancel
                                                            </button>
                                                            <button type="button" id="delete-network-button"
                                                                    class="btn btn-danger">Yes
                                                            </button>
                                                        </div>
                                                    </form>


                                                </x-modal_with_button>

                                            </div>

                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->

                                </div>
                                <!--end::Card-->


                            </div>
                            <!--end:::Tab pane-->


                            <div class="card pt-2 mb-6 mb-xl-9">

                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Tab Content-->
                                    <div id="" class="tab-content">
                                        <!--begin::Tab panel-->
                                        <div id="kt_customer_details_invoices_1" class="py-0 tab-pane fade show active"
                                             role="tabpanel" aria-labelledby="kt_referrals_year_tab">
                                            <!--begin::Table-->
                                            <div id="kt_customer_details_invoices_table_1_wrapper"
                                                 class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <div class="table-responsive">
                                                    <table id="kt_customer_details_invoices_table_1"
                                                           class="table align-middle table-row-dashed fs-6 fw-bold gy-5 dataTable no-footer">
                                                        <thead
                                                            class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                        <tr class="text-start text-muted gs-0">
                                                            <th class="min-w-100px sorting" tabindex="0"
                                                                aria-controls="kt_customer_details_invoices_table_1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Order ID: activate to sort column ascending"
                                                                style="width: 119.35px;">Network
                                                            </th>
                                                            <th class="min-w-100px sorting" tabindex="0"
                                                                aria-controls="kt_customer_details_invoices_table_1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Order ID: activate to sort column ascending"
                                                                style="width: 119.35px;">Agent No
                                                            </th>
                                                            <th class="min-w-100px sorting" tabindex="0"
                                                                aria-controls="kt_customer_details_invoices_table_1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Order ID: activate to sort column ascending"
                                                                style="width: 119.35px;">Name
                                                            </th>
                                                            <th class="min-w-100px sorting" tabindex="0"
                                                                aria-controls="kt_customer_details_invoices_table_1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Order ID: activate to sort column ascending"
                                                                style="width: 119.35px;">Location
                                                            </th>
                                                            <th class="min-w-100px sorting" tabindex="0"
                                                                aria-controls="kt_customer_details_invoices_table_1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Amount: activate to sort column ascending"
                                                                style="width: 121.238px;">{{ __('Balance old') }}
                                                            </th>


                                                        </tr>
                                                        </thead>
                                                        <tbody class="fs-6 fw-semibold text-gray-600">


                                                        <tr class="odd">
                                                            <td data-order="Invalid date">{{ $network->agency->name }}</td>
                                                            <td data-order="Invalid date">{{ $network->agent_no }}</td>
                                                            <td data-order="Invalid date">{{ $network->name }}</td>
                                                            <td data-order="Invalid date">{{ $network->location->name }}</td>
                                                            <td class="text-success">{{{ money(amount: $network->balance, currency: currencyCode(),convert: true) }}}</td>


                                                        </tr>


                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Tab panel-->
                                        <!--end::Tab panel-->
                                    </div>
                                    <!--end::Tab Content-->
                                </div>
                                <!--end::Card body-->
                            </div>

                        </div>
                        <!--end:::Tab content-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->

                <!--end::Content container-->
            </div>
            <!--end::Content-->

        </div>

        @push('js')
            <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>

            <script>
                $("button#delete-network-button").click(function (event) {
                    event.preventDefault();

                    submitForm(
                        $("form#delete-network-form"),
                        "{{ route('agency.networks.delete', $network) }}",
                        "delete"
                    );

                });
            </script>
        @endpush

    </div>

@endsection
