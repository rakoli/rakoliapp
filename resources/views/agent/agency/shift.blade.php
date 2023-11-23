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

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack mb-5">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span
                                    class="path1"></span><span class="path2"></span></i>
                            <x-input type="text" data-kt-docs-table-filter="search"
                                     class="fform-control-solid w-250px ps-15" placeholder="Search Shits"/>
                        </div>
                        <!--end::Search-->

                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="tooltip"
                                    title="Coming Soon">
                                <i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span
                                        class="path2"></span></i>
                                Filter
                            </button>
                            <!--end::Filter-->

                            <!--begin::Add customer-->
                            <x-modal
                                targetId="openShift"
                                label="Open Shift"
                                modalTitle="Fill the form below to open a new shift"
                                isStacked="true"
                            >

                            <livewire:shift.open-shift lazy />


                            </x-modal>

                           <div class="mx-6">
                               <x-modal
                                   targetId="closeShift"
                                   label="Close Shift"
                                   modalTitle="Fill the form below to open a new shift"
                               >

                                 <livewire:shift.close-shift/>


                               </x-modal>
                           </div>
                            <!--end::Add customer-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                             data-kt-docs-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
                            </div>

                            <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" title="Coming Soon">
                                Selection Action
                            </button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Wrapper-->


                    <table class="table" id="shift-table">
                        <thead class="tw-bg-gray-50">
                        <tr>
                            <th>Opened At</th>
                            <th>No</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Status</th>
                            <th>Start Cash</th>
                            <th>EndCash</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')


        <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
                type="text/javascript"></script>
        <script>

            // Class definition
            var KTDatatablesServerSide = function () {
                // Shared variables
                var table;
                var dt;
                var filterPayment;

                // Private functions
                var initDatatable = function () {
                    dt = $("table#shift-table").DataTable({
                        sort: false,
                        "processing": true,
                        "serverSide": true,
                        ajax: {
                            url: "{{ route('agency.shift') }}",
                        },
                        columns: [

                            {"data": "created_at", name: "created_at", sortable: true},
                            {"data": "no", name: "no", sortable: true},
                            {"data": "user_name", name: "user_name", sortable: true},
                            {"data": "status", name: "status"},
                            {"data": "cash_start", name: "cash_start", sortable: true},
                            {"data": "cash_end", name: "cash_end"},

                        ],

                    });

                    table = dt.$;

                    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                    dt.on('draw', function () {
                        KTMenu.createInstances();
                    });
                }

                // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                var handleSearchDatatable = function () {
                    const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                    filterSearch.addEventListener('keyup', function (e) {
                        dt.search(e.target.value).draw();
                    });
                }

                // Filter Datatable
                var handleFilterDatatable = () => {
                    // Select filter options
                    filterPayment = document.querySelectorAll('[data-kt-docs-table-filter="payment_type"] [name="payment_type"]');
                    const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');

                    // Filter datatable on submit
                    filterButton.addEventListener('click', function () {
                        // Get filter values
                        let paymentValue = '';

                        // Get payment value
                        filterPayment.forEach(r => {
                            if (r.checked) {
                                paymentValue = r.value;
                            }

                            // Reset payment value if "All" is selected
                            if (paymentValue === 'all') {
                                paymentValue = '';
                            }
                        });

                        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search(paymentValue).draw();
                    });
                }




                // Public methods
                return {
                    init: function () {
                        initDatatable();
                        handleSearchDatatable();



                    }
                }
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function () {
                KTDatatablesServerSide.init();
            });




        </script>


    @endpush

@endsection



