@extends('layouts.users.agent')

@section('title', "Analytics Dashboard")

@section('header_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Analytics</small>
    <!--end::Description-->
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">

        <!-- Date Range Filter -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('analytics.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="date_from" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                       value="{{ request('date_from', Carbon\Carbon::now()->subDays(30)->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="date_to" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                       value="{{ request('date_to', Carbon\Carbon::now()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row gy-5 g-xl-10 mb-5">
            <!-- Total Shifts -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary">
                    <div class="card-header">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($analyticsData['totalShifts']) }}</span>
                            <span class="text-white pt-1 fw-semibold fs-6">Total Shifts</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-white">
                            <span class="fs-6 fw-semibold">Open: {{ number_format($analyticsData['openShifts']) }}</span><br>
                            <span class="fs-6 fw-semibold">Closed: {{ number_format($analyticsData['closedShifts']) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success">
                    <div class="card-header">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($analyticsData['totalTransactions']) }}</span>
                            <span class="text-white pt-1 fw-semibold fs-6">Total Transactions</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-white">
                            <span class="fs-6 fw-semibold">Volume: {{ $analyticsData['currency'] }} {{ number_format($analyticsData['totalAmount'], 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Money In -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info">
                    <div class="card-header">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $analyticsData['currency'] }} {{ number_format($analyticsData['moneyIn'], 2) }}</span>
                            <span class="text-white pt-1 fw-semibold fs-6">Money In</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Money Out -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning">
                    <div class="card-header">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $analyticsData['currency'] }} {{ number_format($analyticsData['moneyOut'], 2) }}</span>
                            <span class="text-white pt-1 fw-semibold fs-6">Money Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Amount -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card {{ $analyticsData['netAmount'] >= 0 ? 'bg-light-success' : 'bg-light-danger' }}">
                    <div class="card-body text-center">
                        <h2 class="fw-bold {{ $analyticsData['netAmount'] >= 0 ? 'text-success' : 'text-danger' }}">
                            Net Amount: {{ $analyticsData['currency'] }} {{ number_format($analyticsData['netAmount'], 2) }}
                        </h2>
                        <p class="text-muted">{{ $analyticsData['netAmount'] >= 0 ? 'Profit' : 'Loss' }} for selected period</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row gy-5 g-xl-10 mb-5">
            <!-- Shifts Chart -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Shifts Over Time</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="shiftsChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Transactions Chart -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Transaction Volume</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="transactionsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="row gy-5 g-xl-10">
            <!-- Top Users -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Top Performing Users</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>User</th>
                                        <th>Shifts</th>
                                        <th>Transaction Volume</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($analyticsData['topUsers'] as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-45px me-5">
                                                        <span class="symbol-label bg-light-primary text-primary fw-semibold">
                                                            {{ strtoupper(substr($user->name(), 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold text-hover-primary fs-6">{{ $user->name() }}</span>
                                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $user->email }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{ $user->shifts_count }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $analyticsData['currency'] }} {{ number_format($user->shift_transactions_sum_amount ?? 0, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Performance -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Location Performance</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Location</th>
                                        <th>Shifts</th>
                                        <th>Transaction Volume</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($analyticsData['locationPerformance'] as $location)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-45px me-5">
                                                        <span class="symbol-label bg-light-success text-success fw-semibold">
                                                            {{ strtoupper(substr($location->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold text-hover-primary fs-6">{{ $location->name }}</span>
                                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $location->code }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">{{ $location->shifts_count }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $analyticsData['currency'] }} {{ number_format($location->shift_transactions_sum_amount ?? 0, 2) }}</span>
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
    </div>
@endsection

@section('footer_js')
    <script>
        // Shifts Chart
        const shiftsCtx = document.getElementById('shiftsChart').getContext('2d');
        const shiftsChart = new Chart(shiftsCtx, {
            type: 'bar',
            data: {
                labels: @json($analyticsData['shiftsChart']['dates']),
                datasets: [{
                    label: 'Total Shifts',
                    data: @json($analyticsData['shiftsChart']['total']),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Open Shifts',
                    data: @json($analyticsData['shiftsChart']['open']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Closed Shifts',
                    data: @json($analyticsData['shiftsChart']['closed']),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
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

        // Transactions Chart
        const transactionsCtx = document.getElementById('transactionsChart').getContext('2d');
        const transactionsChart = new Chart(transactionsCtx, {
            type: 'line',
            data: {
                labels: @json($analyticsData['transactionsChart']['dates']),
                datasets: [{
                    label: 'Money In',
                    data: @json($analyticsData['transactionsChart']['money_in']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }, {
                    label: 'Money Out',
                    data: @json($analyticsData['transactionsChart']['money_out']),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false
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
    </script>
@endsection
