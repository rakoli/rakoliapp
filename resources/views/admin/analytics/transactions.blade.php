@extends('layouts.users.admin')

@section('title', "Transaction Analytics")

@section('header_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Analytics > Transaction Analytics</small>
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
                            <h3 class="fw-bold">Transaction Analytics Filters</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.analytics.transactions') }}" class="row g-3">
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
                                <label for="type_filter" class="form-label">Type</label>
                                <select class="form-select" id="type_filter" name="type">
                                    <option value="">All Types</option>
                                    <option value="IN" {{ request('type') == 'IN' ? 'selected' : '' }}>Money In</option>
                                    <option value="OUT" {{ request('type') == 'OUT' ? 'selected' : '' }}>Money Out</option>
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
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="card bg-primary">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Total Transactions</h6>
                                <h2>{{ $summaryData['total_transactions'] ?? 0 }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="ki-outline ki-wallet fs-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Total Amount</h6>
                                <h2>{{ $summaryData['total_amount'] ?? '0.00' }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="ki-outline ki-dollar fs-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Cash In</h6>
                                <h2>{{ $summaryData['cash_in_amount'] ?? '0.00' }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="ki-outline ki-arrow-down fs-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Cash Out</h6>
                                <h2>{{ $summaryData['cash_out_amount'] ?? '0.00' }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="ki-outline ki-arrow-up fs-2x"></i>
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
                            <h3 class="fw-bold">Transaction Types</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="transactionTypesChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Daily Transaction Volume</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyVolumeChart" width="400" height="200"></canvas>
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
                            <h3 class="fw-bold">Transaction Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-rounded table-striped border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>ID</th>
                                        <th>Business</th>
                                        <th>Shift</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Commission</th>
                                        <th>Location</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td>{{ $transaction->shift && $transaction->shift->business ? $transaction->shift->business->business_name : 'N/A' }}</td>
                                            <td>{{ $transaction->shift_id }}</td>
                                            <td>
                                                @if($transaction->type == 'IN')
                                                    <span class="badge badge-success">Money In</span>
                                                @else
                                                    <span class="badge badge-danger">Money Out</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($transaction->amount, 2) }}</td>
                                            <td>{{ number_format($transaction->commission ?? 0, 2) }}</td>
                                            <td>{{ $transaction->shift && $transaction->shift->location ? $transaction->shift->location->name : 'N/A' }}</td>
                                            <td>{{ $transaction->shift && $transaction->shift->user ? $transaction->shift->user->name : 'N/A' }}</td>
                                            <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="viewTransaction({{ $transaction->id }})">View</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No transactions found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($transactions->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <div class="text-muted">
                                    Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} results
                                </div>
                                <div>
                                    {{ $transactions->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('footer_js')
    <script>
        // Initialize charts on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTypesChart(@json($chartData['typesChart'] ?? []));
            updateDailyChart(@json($chartData['dailyChart'] ?? []));
        });

        // Chart instances
        var typesChart = null;
        var dailyChart = null;

        function updateTypesChart(data) {
            const ctx = document.getElementById('transactionTypesChart').getContext('2d');

            if (typesChart) {
                typesChart.destroy();
            }

            typesChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels || [],
                    datasets: [{
                        data: data.data || [],
                        backgroundColor: ['#50CD89', '#F1416C', '#FFC700', '#7239EA'],
                        borderWidth: 0
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
        }

        function updateDailyChart(data) {
            const ctx = document.getElementById('dailyVolumeChart').getContext('2d');

            if (dailyChart) {
                dailyChart.destroy();
            }

            dailyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels || [],
                    datasets: [{
                        label: 'Transaction Volume',
                        data: data.data || [],
                        borderColor: '#009EF7',
                        backgroundColor: 'rgba(0, 158, 247, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function viewTransaction(id) {
            // Add your view transaction logic here
            console.log('View transaction:', id);
        }
    </script>
@endsection
