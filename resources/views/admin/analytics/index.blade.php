@extends('layouts.users.admin')

@section('title', "System Analytics Dashboard")

@section('header_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">System Analytics</small>
    <!--end::Description-->
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">

        <!-- Date Range Filter -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.analytics.index') }}" class="row g-3">
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

        <!-- System Overview Stats -->
        <div class="row gy-5 g-xl-10 mb-5">
            <!-- Total Businesses -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary">
                    <div class="card-header">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($analyticsData['totalBusinesses']) }}</span>
                            <span class="text-white pt-1 fw-semibold fs-6">Total Businesses</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-white">
                            <span class="fs-6 fw-semibold">Verified: {{ number_format($analyticsData['verifiedBusinesses']) }}</span><br>
                            <span class="fs-6 fw-semibold">Pending: {{ number_format($analyticsData['totalBusinesses'] - $analyticsData['verifiedBusinesses']) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success">
                    <div class="card-header">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($analyticsData['totalUsers']) }}</span>
                            <span class="text-white pt-1 fw-semibold fs-6">Total Users</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-white">
                            <span class="fs-6 fw-semibold">Active: {{ number_format($analyticsData['activeUsers']) }}</span><br>
                            <span class="fs-6 fw-semibold">Inactive: {{ number_format($analyticsData['totalUsers'] - $analyticsData['activeUsers']) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Shifts -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info">
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
                <div class="card bg-warning">
                    <div class="card-header">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($analyticsData['totalTransactions']) }}</span>
                            <span class="text-white pt-1 fw-semibold fs-6">Total Transactions</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-white">
                            <span class="fs-6 fw-semibold">Volume: {{ number_format($analyticsData['totalAmount'], 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Overview -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Financial Overview</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40px me-4">
                                        <span class="symbol-label bg-light-success text-success fw-bold">IN</span>
                                    </div>
                                    <div>
                                        <div class="text-gray-800 fw-bold fs-2">{{ number_format($analyticsData['moneyIn'], 2) }}</div>
                                        <div class="text-gray-600 fw-semibold">Money In</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40px me-4">
                                        <span class="symbol-label bg-light-danger text-danger fw-bold">OUT</span>
                                    </div>
                                    <div>
                                        <div class="text-gray-800 fw-bold fs-2">{{ number_format($analyticsData['moneyOut'], 2) }}</div>
                                        <div class="text-gray-600 fw-semibold">Money Out</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40px me-4">
                                        <span class="symbol-label bg-light-primary text-primary fw-bold">NET</span>
                                    </div>
                                    <div>
                                        <div class="text-gray-800 fw-bold fs-2 {{ $analyticsData['netAmount'] >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($analyticsData['netAmount'], 2) }}
                                        </div>
                                        <div class="text-gray-600 fw-semibold">Net Amount</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row gy-5 g-xl-10 mb-5">
            <!-- Daily Activity Chart -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Daily Activity Trends</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyActivityChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Country Distribution -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Country Distribution</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="countryChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performing Businesses -->
        <div class="row gy-5 g-xl-10">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Top Performing Businesses</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Business</th>
                                        <th>Shifts</th>
                                        <th>Transaction Volume</th>
                                        <th>Country</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($analyticsData['topBusinesses'] as $business)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-45px me-5">
                                                        <span class="symbol-label bg-light-primary text-primary fw-semibold">
                                                            {{ strtoupper(substr($business->business_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold text-hover-primary fs-6">{{ $business->business_name }}</span>
                                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $business->code }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{ $business->shifts_count }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ number_format($business->business_account_transactions_sum_amount ?? 0, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light">{{ $business->country_code }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Recent Activity</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="timeline-label">
                            @foreach($analyticsData['recentActivities']['shifts']->take(5) as $shift)
                                <div class="timeline-item">
                                    <div class="timeline-label fw-bold text-gray-800 fs-6">
                                        {{ $shift->created_at->format('H:i') }}
                                    </div>
                                    <div class="timeline-badge">
                                        <i class="ki-outline ki-shop text-primary fs-2"></i>
                                    </div>
                                    <div class="fw-muted timeline-content text-muted ps-3">
                                        <strong>{{ $shift->user ? $shift->user->name() : 'Unknown' }}</strong>
                                        {{ $shift->status->value === 'open' ? 'opened' : 'closed' }} a shift
                                        @if($shift->business)
                                            at <strong>{{ $shift->business->business_name }}</strong>
                                        @endif
                                        <div class="text-muted fs-7">{{ $shift->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script>
        // Daily Activity Chart
        const dailyActivityCtx = document.getElementById('dailyActivityChart').getContext('2d');
        const dailyActivityChart = new Chart(dailyActivityCtx, {
            type: 'line',
            data: {
                labels: @json($analyticsData['dailyStats']['dates']),
                datasets: [{
                    label: 'Shifts',
                    data: @json($analyticsData['dailyStats']['shifts']),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: false
                }, {
                    label: 'Transactions',
                    data: @json($analyticsData['dailyStats']['transactions']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }, {
                    label: 'New Businesses',
                    data: @json($analyticsData['dailyStats']['businesses']),
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

        // Country Distribution Chart
        const countryCtx = document.getElementById('countryChart').getContext('2d');
        const countryChart = new Chart(countryCtx, {
            type: 'doughnut',
            data: {
                labels: @json($analyticsData['countryDistribution']->pluck('country')),
                datasets: [{
                    data: @json($analyticsData['countryDistribution']->pluck('count')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
