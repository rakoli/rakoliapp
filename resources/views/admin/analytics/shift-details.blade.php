@extends('layouts.users.admin')

@section('title', "Shift Details - #" . $shift->id)

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
/* Custom DataTables styling */
.dataTables_wrapper .dataTables_filter {
    display: none; /* Hide default search since we use custom */
}

.dataTables_wrapper .dataTables_length select {
    min-width: 60px;
}

.dataTables_wrapper .dataTables_info {
    padding-top: 0.85rem;
}

.dataTables_wrapper .dataTables_paginate {
    padding-top: 0.5rem;
}

/* Custom search styling */
#custom-search {
    border-radius: 0.475rem;
}

#type-filter {
    min-width: 120px;
}

/* Table styling improvements */
#transactions-table {
    border-radius: 0.475rem;
}

#transactions-table thead th {
    background-color: #f8f9fa;
    border-top: 1px solid #e4e6ea;
    vertical-align: middle;
}

.table-responsive {
    border-radius: 0.475rem;
    box-shadow: 0 0.1rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Loading spinner styling */
.dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    width: auto;
    height: auto;
    margin-left: -50px;
    margin-top: -25px;
    padding: 10px;
    border: 0;
    background: rgba(255, 255, 255, 0.9);
    color: #6c757d;
}
</style>
@endpush

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">
        <a href="{{ route('admin.analytics.shifts') }}" class="text-muted text-decoration-none">Analytics</a> >
        <a href="{{ route('admin.analytics.shifts') }}" class="text-muted text-decoration-none">Shifts</a> >
        Shift Details
    </small>
    <!--end::Description-->
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">

        <!-- Header -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Shift Details #{{ $shift->id }}
                    </h1>
                    <a href="{{ route('admin.analytics.shifts') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left"></i> Back to Shifts
                    </a>
                </div>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Basic Information</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-row-bordered">
                            <tr>
                                <td class="fw-bold text-gray-800">Shift ID:</td>
                                <td>{{ $shift->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Business:</td>
                                <td>{{ $shift->business ? $shift->business->business_name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Location:</td>
                                <td>{{ $shift->location ? $shift->location->name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">User:</td>
                                <td>{{ $shift->user ? $shift->user->name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Status:</td>
                                <td>
                                    @if($shift->status == \App\Utils\Enums\ShiftStatusEnum::OPEN)
                                        <span class="badge badge-success">{{ $shift->status->label() }}</span>
                                    @elseif($shift->status == \App\Utils\Enums\ShiftStatusEnum::CLOSED)
                                        <span class="badge badge-secondary">{{ $shift->status->label() }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $shift->status->label() }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Start Time:</td>
                                <td>{{ $shift->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">End Time:</td>
                                <td>
                                    @if($shift->status == \App\Utils\Enums\ShiftStatusEnum::CLOSED)
                                        {{ $shift->updated_at->format('Y-m-d H:i:s') }}
                                    @else
                                        <span class="text-success">Still Open</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Duration:</td>
                                <td>
                                    @if($shift->status == \App\Utils\Enums\ShiftStatusEnum::OPEN)
                                        {{ $shift->created_at->diffForHumans() }}
                                    @else
                                        {{ $shift->created_at->diffInHours($shift->updated_at) }} hours
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Balances & Statistics</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-row-bordered">
                            <tr>
                                <td class="fw-bold text-gray-800">Opening Balance:</td>
                                <td>{{ number_format($shift->opening_balance ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Closing Balance:</td>
                                <td>{{ number_format($shift->closing_balance ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Difference:</td>
                                <td>
                                    @php
                                        $difference = ($shift->closing_balance ?? 0) - ($shift->opening_balance ?? 0);
                                    @endphp
                                    <span class="{{ $difference >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($difference, 2) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Total Transactions:</td>
                                <td><span class="badge badge-info">{{ $statistics['total_transactions'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Total Amount:</td>
                                <td><span class="fw-bold text-primary">{{ number_format($statistics['total_amount'], 2) }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Total Fees:</td>
                                <td>{{ number_format($statistics['total_fee'], 2) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Total Loans:</td>
                                <td><span class="badge badge-warning">{{ $statistics['total_loans'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-800">Total Loan Amount:</td>
                                <td>{{ number_format($statistics['total_loan_amount'], 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Breakdown -->
        @if($transactionBreakdown->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Transaction Breakdown by Type</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-rounded table-striped border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>Transaction Type</th>
                                        <th>Count</th>
                                        <th>Total Amount</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactionBreakdown as $transaction)
                                        <tr>
                                            <td>
                                                <span class="badge badge-light-primary">{{ $transaction->type }}</span>
                                            </td>
                                            <td>{{ $transaction->count }}</td>
                                            <td>{{ number_format($transaction->total_amount, 2) }}</td>
                                            <td>
                                                @php
                                                    $percentage = $statistics['total_transactions'] > 0
                                                        ? ($transaction->count / $statistics['total_transactions']) * 100
                                                        : 0;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{ $percentage }}%"
                                                         aria-valuenow="{{ $percentage }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">
                                                        {{ number_format($percentage, 1) }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Network Balances -->
        @if($networkBalances->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Network Balance Changes</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-rounded table-striped border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>Network</th>
                                        <th>Opening Balance</th>
                                        <th>Closing Balance</th>
                                        <th>Difference</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($networkBalances as $network)
                                        <tr>
                                            <td>{{ $network->name }}</td>
                                            <td>{{ number_format($network->balance_old ?? 0, 2) }}</td>
                                            <td>{{ number_format($network->balance_new ?? 0, 2) }}</td>
                                            <td>
                                                @php
                                                    $netDifference = ($network->balance_new ?? 0) - ($network->balance_old ?? 0);
                                                @endphp
                                                <span class="{{ $netDifference >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ number_format($netDifference, 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Transactions Table with DataTables -->
        @if($shift->transactions->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex align-items-center justify-content-between w-100">
                            <h3 class="fw-bold mb-0">All Transactions ({{ $shift->transactions->count() }})</h3>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge badge-light-primary fs-7">
                                    Total: {{ number_format($statistics['total_amount'], 2) }}
                                </span>
                                <span class="badge badge-light-info fs-7">
                                    Fee: {{ number_format($statistics['total_fee'], 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Custom Search and Filter Section -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" id="custom-search" class="form-control" placeholder="Search transactions...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2">
                                    <select id="type-filter" class="form-select">
                                        <option value="">All Types</option>
                                        <option value="IN">Money In</option>
                                        <option value="OUT">Money Out</option>
                                    </select>
                                    <button type="button" id="clear-filters" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Clear
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="transactions-table" class="table table-rounded table-striped border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Fee</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- DataTables will populate this via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
@endsection

@push('js')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#transactions-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        searching: false, // Disable default search since we're using custom
        ajax: {
            url: '{{ route("admin.analytics.shifts.transactions.data", $shift->id) }}',
            type: 'GET',
            data: function(d) {
                // Add custom search parameters
                d.custom_search = $('#custom-search').val();
                d.type_filter = $('#type-filter').val();
            }
        },
        columns: [
            { data: 'id', name: 'id', title: 'ID', className: 'fw-bold' },
            { data: 'type', name: 'type', title: 'Type', orderable: false, className: 'text-center' },
            { data: 'amount', name: 'amount', title: 'Amount', className: 'text-end fw-bold text-primary' },
            { data: 'fee', name: 'fee', title: 'Fee', className: 'text-end' },
            { data: 'description', name: 'description', title: 'Description' },
            { data: 'created_at', name: 'created_at', title: 'Date', className: 'text-nowrap' }
        ],
        order: [[5, 'desc']], // Order by date descending
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>',
            emptyTable: 'No transactions found for this shift',
            zeroRecords: 'No matching transactions found',
            info: 'Showing _START_ to _END_ of _TOTAL_ transactions',
            infoEmpty: 'Showing 0 to 0 of 0 transactions',
            infoFiltered: '(filtered from _MAX_ total transactions)',
            lengthMenu: 'Show _MENU_ transactions per page'
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 text-end"B>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        drawCallback: function(settings) {
            // Re-initialize any tooltips or other components if needed
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    // Custom search functionality
    $('#custom-search').on('keyup', function() {
        table.draw();
    });

    // Type filter functionality
    $('#type-filter').on('change', function() {
        table.draw();
    });

    // Clear filters functionality
    $('#clear-filters').on('click', function() {
        $('#custom-search').val('');
        $('#type-filter').val('');
        table.draw();
    });

    // Add loading state to custom search
    $('#custom-search').on('keyup', function() {
        var search = this;
        clearTimeout($(search).data('timer'));
        $(search).data('timer', setTimeout(function() {
            table.draw();
        }, 500)); // Debounce search
    });
});
</script>
@endpush
