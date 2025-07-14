@extends('layouts.users.agent')

@section('title', "Shift Analytics")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Analytics > Shifts</small>
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
                                       value="{{ Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="date_to" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                       value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="user_filter" class="form-label">User</label>
                                <select class="form-select" id="user_filter" name="user_code">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->code }}">{{ $user->name() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="location_filter" class="form-label">Location</label>
                                <select class="form-select" id="location_filter" name="location_code">
                                    <option value="">All Locations</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->code }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status_filter" class="form-label">Status</label>
                                <select class="form-select" id="status_filter" name="status">
                                    <option value="">All Status</option>
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" id="applyFilters" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shifts Table -->
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
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="shiftsTable">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Shift #</th>
                                        <th>User</th>
                                        <th>Location</th>
                                        <th>Start Time</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Transactions</th>
                                        <th>Total Amount</th>
                                        <th>Cash Start</th>
                                        <th>Cash End</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
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
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#shiftsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('analytics.shifts') }}',
                    data: function(d) {
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                        d.user_code = $('#user_filter').val();
                        d.location_code = $('#location_filter').val();
                        d.status = $('#status_filter').val();
                    }
                },
                columns: [
                    {
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        render: function(data, type, row) {
                            return `<div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-3">
                                            <span class="symbol-label bg-light-primary text-primary fw-semibold">
                                                ${data.charAt(0).toUpperCase()}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <span class="text-dark fw-bold text-hover-primary fs-7">${data}</span>
                                            <span class="text-muted fw-semibold text-muted d-block fs-8">${row.user_email}</span>
                                        </div>
                                    </div>`;
                        }
                    },
                    {
                        data: 'location_name',
                        name: 'location_name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return new Date(data).toLocaleString();
                        }
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'transactions_count',
                        name: 'transactions_count'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        render: function(data) {
                            return '{{ auth()->user()->business->country->currency }} ' + data;
                        }
                    },
                    {
                        data: 'cash_start',
                        name: 'cash_start',
                        render: function(data) {
                            return '{{ auth()->user()->business->country->currency }} ' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'cash_end',
                        name: 'cash_end',
                        render: function(data) {
                            return '{{ auth()->user()->business->country->currency }} ' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[3, 'desc']],
                pageLength: 25,
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Apply filters
            $('#applyFilters').on('click', function() {
                table.draw();
            });

            // Auto-refresh every 30 seconds for open shifts
            setInterval(function() {
                table.ajax.reload(null, false);
            }, 30000);
        });
    </script>
@endsection
