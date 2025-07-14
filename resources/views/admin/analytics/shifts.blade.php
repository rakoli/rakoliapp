@extends('layouts.users.admin')

@section('title', "Shift Analytics")

@section('header_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Analytics > Shift Analytics</small>
    <!--end::Description-->
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">

        <!-- Filters -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Shift Analytics Filters</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="filtersForm" class="row g-3">
                            <div class="col-md-2">
                                <label for="date_from" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                       value="{{ request('date_from', Carbon\Carbon::now()->subDays(30)->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="date_to" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                       value="{{ request('date_to', Carbon\Carbon::now()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="business_filter" class="form-label">Business</label>
                                <select class="form-select" id="business_filter" name="business_code">
                                    <option value="">All Businesses</option>
                                    @foreach($businesses as $business)
                                        <option value="{{ $business->code }}" {{ request('business_code') == $business->code ? 'selected' : '' }}>
                                            {{ $business->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status_filter" class="form-label">Status</label>
                                <select class="form-select" id="status_filter" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="inreview" {{ request('status') == 'inreview' ? 'selected' : '' }}>In Review</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="location_filter" class="form-label">Location</label>
                                <select class="form-select" id="location_filter" name="location_id">
                                    <option value="">All Locations</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" id="applyFilters" class="btn btn-primary me-2">Apply Filters</button>
                                <button type="button" id="resetFilters" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted fw-semibold fs-6">Total Shifts</span>
                                <h3 class="text-primary fw-bold mb-0">{{ $summaryData['total_shifts'] }}</h3>
                            </div>
                            <div class="symbol symbol-50px">
                                <i class="fas fa-clock text-primary fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted fw-semibold fs-6">Open Shifts</span>
                                <h3 class="text-success fw-bold mb-0">{{ $summaryData['open_shifts'] }}</h3>
                            </div>
                            <div class="symbol symbol-50px">
                                <i class="fas fa-play-circle text-success fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light-secondary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted fw-semibold fs-6">Closed Shifts</span>
                                <h3 class="text-secondary fw-bold mb-0">{{ $summaryData['closed_shifts'] }}</h3>
                            </div>
                            <div class="symbol symbol-50px">
                                <i class="fas fa-stop-circle text-secondary fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted fw-semibold fs-6">Total Transactions</span>
                                <h3 class="text-info fw-bold mb-0">{{ $summaryData['total_transactions'] }}</h3>
                            </div>
                            <div class="symbol symbol-50px">
                                <i class="fas fa-exchange-alt text-info fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Shift Status Distribution</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="shiftStatusChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Shifts by Business</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="shiftsByBusinessChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Shift Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="shiftsTable" class="table table-rounded table-striped border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Business</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Opening Balance</th>
                                        <th>Closing Balance</th>
                                        <th>Start Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('footer_js')
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // Initialize charts
        const statusChart = new Chart(document.getElementById('shiftStatusChart'), {
            type: 'doughnut',
            data: {
                labels: @json($chartData['statusChart']['labels']),
                datasets: [{
                    data: @json($chartData['statusChart']['data']),
                    backgroundColor: [
                        '#28a745',
                        '#6c757d',
                        '#ffc107',
                        '#dc3545'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const businessChart = new Chart(document.getElementById('shiftsByBusinessChart'), {
            type: 'bar',
            data: {
                labels: @json($chartData['businessChart']['labels']),
                datasets: [{
                    label: 'Shifts',
                    data: @json($chartData['businessChart']['data']),
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Initialize DataTables
        let shiftsTable;

        $(document).ready(function() {
            initializeDataTable();

            // Filter event handlers
            $('#applyFilters').on('click', function() {
                shiftsTable.ajax.reload();
            });

            $('#resetFilters').on('click', function() {
                $('#filtersForm')[0].reset();
                // Set default date values
                $('#date_from').val('{{ Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}');
                $('#date_to').val('{{ Carbon\Carbon::now()->format('Y-m-d') }}');
                shiftsTable.ajax.reload();
            });

            // Real-time search on form fields
            $('#filtersForm input, #filtersForm select').on('change', function() {
                shiftsTable.ajax.reload();
            });
        });

        function initializeDataTable() {
            shiftsTable = $('#shiftsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.analytics.shifts.data') }}',
                    type: 'GET',
                    data: function(d) {
                        // Add form filters to AJAX request
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                        d.business_code = $('#business_filter').val();
                        d.status = $('#status_filter').val();
                        d.location_id = $('#location_filter').val();

                        // Add custom search parameter
                        d.custom_search = d.search.value;
                    },
                    error: function(xhr, status, error) {
                        console.error('DataTables AJAX Error:', error);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [
                    { data: 'id', name: 'id', searchable: true },
                    { data: 'user_name', name: 'user_name', searchable: true },
                    { data: 'business_name', name: 'business_name', searchable: true },
                    { data: 'location_name', name: 'location_name', searchable: true },
                    { data: 'status', name: 'status', searchable: false, orderable: false },
                    { data: 'opening_balance', name: 'opening_balance', searchable: false },
                    { data: 'closing_balance', name: 'closing_balance', searchable: false },
                    { data: 'created_at', name: 'created_at', searchable: false },
                    { data: 'actions', name: 'actions', searchable: false, orderable: false }
                ],
                order: [[7, 'desc']], // Default sort by created_at desc
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    emptyTable: "No shifts found",
                    zeroRecords: "No matching shifts found",
                    info: "Showing _START_ to _END_ of _TOTAL_ shifts",
                    infoEmpty: "Showing 0 to 0 of 0 shifts",
                    infoFiltered: "(filtered from _MAX_ total shifts)"
                },
                responsive: true,
                autoWidth: false,
                initComplete: function() {
                    console.log('Shifts DataTable initialized successfully');
                }
            });
        }
    </script>
@endsection
