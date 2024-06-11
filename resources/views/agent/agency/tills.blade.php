@extends('layouts.users.agent')

@section('title', "Tills")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Agency</small>
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Shift</small>
    <!--end::Description-->
@endsection

@section('content')


    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        @include('agent.agency._submenu_agency')



    </div>
    <!--end::Container-->

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

                        <!--begin::Add customer-->
                        <a href="{{ route('agency.shift') }}" class="btn btn-warning btn-outline-warning">
                            {{ __('Back') }}
                        </a>

                    </div>
                    <!--end::Wrapper-->


                    <table class="table" id="shift-till-table">
                        <thead class="tw-bg-gray-50">
                        <tr>
                            <th>Till</th>
                            <th>Start Balance</th>
                            <th>End Balance</th>
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


                // Private functions
                var initDatatable = function () {
                    dt = $("table#shift-till-table").DataTable({
                        sort: false,
                        "processing": true,
                        "serverSide": true,
                        ajax: {
                            url: "{{ route('agency.shift.till', $shift) }}",
                        },
                        columns: [

                            {"data": "till_name", name: "till_name", sortable: true},
                            {"data": "balance_old", name: "balance_old", sortable: true},
                            {"data": "balance_new", name: "balance_new"},

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
