@extends('layouts.users.agent')

@section('title', "User Performance Analytics")

@section('header_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Analytics > Users</small>
    <!--end::Description-->
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">

        <!-- Date Range Filter -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('analytics.users') }}" class="row g-3">
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

        <!-- User Performance Chart -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">User Performance Comparison</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="userPerformanceChart" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Details -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">User Performance Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>User</th>
                                        <th>Total Shifts</th>
                                        <th>Total Hours</th>
                                        <th>Avg Shift Duration</th>
                                        <th>Transaction Volume</th>
                                        <th>Avg Cash End</th>
                                        <th>Performance Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userAnalytics as $user)
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
                                                <span class="badge badge-primary fs-6">{{ $user->shifts_count }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ number_format($user->total_hours, 1) }} hrs</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ number_format($user->avg_shift_duration, 1) }} hrs</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ auth()->user()->business->country->currency }} {{ number_format($user->shift_transactions_sum_amount ?? 0, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ auth()->user()->business->country->currency }} {{ number_format($user->shifts_avg_cash_end ?? 0, 2) }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $score = 0;
                                                    if ($user->shifts_count > 0) {
                                                        $score = ($user->shifts_count * 2) + ($user->total_hours * 0.5) + (($user->shift_transactions_sum_amount ?? 0) / 1000);
                                                        $score = min($score, 100);
                                                    }
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <div class="progress h-20px w-100px me-3">
                                                        <div class="progress-bar
                                                            @if($score >= 80) bg-success
                                                            @elseif($score >= 60) bg-warning
                                                            @else bg-danger
                                                            @endif"
                                                            role="progressbar"
                                                            style="width: {{ $score }}%"
                                                            aria-valuenow="{{ $score }}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <span class="fw-bold fs-6">{{ number_format($score, 1) }}</span>
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

        <!-- User Activity Timeline -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Recent User Activity</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="timeline-label">
                            @foreach($userAnalytics as $user)
                                @if($user->shifts->count() > 0)
                                    <div class="timeline-item">
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            {{ $user->name() }}
                                        </div>
                                        <div class="timeline-badge">
                                            <i class="ki-outline ki-user text-primary fs-2"></i>
                                        </div>
                                        <div class="fw-muted timeline-content text-muted ps-3">
                                            <div class="row">
                                                @foreach($user->shifts->take(3) as $shift)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card card-bordered">
                                                            <div class="card-body p-3">
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <span class="fs-7 fw-bold">Shift #{{ $shift->no }}</span>
                                                                    <span class="badge badge-sm
                                                                        @if($shift->status->value === 'open') badge-success
                                                                        @else badge-secondary
                                                                        @endif">
                                                                        {{ ucfirst($shift->status->value) }}
                                                                    </span>
                                                                </div>
                                                                <div class="fs-8 text-muted">
                                                                    Started: {{ $shift->created_at->format('M d, Y H:i') }}<br>
                                                                    @if($shift->status->value === 'closed')
                                                                        Duration: {{ $shift->created_at->diffInHours($shift->updated_at) }} hrs
                                                                    @else
                                                                        Running: {{ $shift->created_at->diffForHumans() }}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
        // User Performance Chart
        const userPerformanceCtx = document.getElementById('userPerformanceChart').getContext('2d');
        const userPerformanceChart = new Chart(userPerformanceCtx, {
            type: 'bar',
            data: {
                labels: @json($userAnalytics->pluck('name')->map(function($name) { return explode(' ', $name)[0]; })),
                datasets: [{
                    label: 'Total Shifts',
                    data: @json($userAnalytics->pluck('shifts_count')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                }, {
                    label: 'Total Hours',
                    data: @json($userAnalytics->pluck('total_hours')),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1'
                }, {
                    label: 'Transaction Volume (K)',
                    data: @json($userAnalytics->pluck('shift_transactions_sum_amount')->map(function($amount) { return $amount / 1000; })),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    yAxisID: 'y2'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Users'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Shifts'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Hours'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                    y2: {
                        type: 'linear',
                        display: false,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Transaction Volume (K)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
@endsection
