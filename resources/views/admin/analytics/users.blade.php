@extends('layouts.users.admin')

@section('title', "User Analytics")

@section('header_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Analytics > User Analytics</small>
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
                            <h3 class="fw-bold">User Analytics Filters</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.analytics.users') }}" class="row g-3">
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
                                <label for="type_filter" class="form-label">User Type</label>
                                <select class="form-select" id="type_filter" name="user_type">
                                    <option value="">All Types</option>
                                    <option value="AGENT" {{ request('user_type') == 'AGENT' ? 'selected' : '' }}>Agent</option>
                                    <option value="EMPLOYEE" {{ request('user_type') == 'EMPLOYEE' ? 'selected' : '' }}>Employee</option>
                                    <option value="ADMIN" {{ request('user_type') == 'ADMIN' ? 'selected' : '' }}>Admin</option>
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
                                <h6>Total Users</h6>
                                <h2>{{ $summaryData['total_users'] ?? 0 }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="ki-outline ki-people fs-2x"></i>
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
                                <h6>Active Users</h6>
                                <h2>{{ $summaryData['active_users'] ?? 0 }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="ki-outline ki-user-tick fs-2x"></i>
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
                                <h6>Total Shifts</h6>
                                <h2>{{ $summaryData['total_shifts'] ?? 0 }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="ki-outline ki-calendar fs-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info">
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
        </div>

        <!-- Charts Row -->
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">User Types Distribution</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="userTypesChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">User Activity by Location</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="userLocationChart" width="400" height="200"></canvas>
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
                            <h3 class="fw-bold">User Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-rounded table-striped border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Business</th>
                                        <th>Type</th>
                                        <th>Locations</th>
                                        <th>Total Shifts</th>
                                        <th>Total Transactions</th>
                                        <th>Last Activity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-35px me-3">
                                                        <div class="symbol-label fs-6 bg-light-primary text-primary">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <span class="text-dark fw-bold">{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->business ? $user->business->business_name : 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-light-primary">{{ $user->type }}</span>
                                            </td>
                                            <td>
                                                @if($user->locations && $user->locations->count() > 0)
                                                    @foreach($user->locations->take(2) as $location)
                                                        <span class="badge badge-light-info me-1">{{ $location->name }}</span>
                                                    @endforeach
                                                    @if($user->locations->count() > 2)
                                                        <span class="text-muted">+{{ $user->locations->count() - 2 }} more</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">No locations</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->total_shifts ?? 0 }}</td>
                                            <td>
                                                @php
                                                    $totalTransactions = $user->shifts()->withCount('transactions')->get()->sum('transactions_count');
                                                @endphp
                                                {{ $totalTransactions }}
                                            </td>
                                            <td>
                                                @php
                                                    $lastShift = $user->shifts()->latest()->first();
                                                @endphp
                                                {{ $lastShift ? $lastShift->created_at->diffForHumans() : 'Never' }}
                                            </td>
                                            <td>
                                                @if($user->status == \App\Utils\Enums\UserStatusEnum::ACTIVE->value)
                                                    <span class="badge badge-success">Active</span>
                                                @elseif($user->status == \App\Utils\Enums\UserStatusEnum::BLOCKED->value)
                                                    <span class="badge badge-danger">Blocked</span>
                                                @else
                                                    <span class="badge badge-secondary">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="viewUser({{ $user->id }})">View</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center">No users found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($users->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <div class="text-muted">
                                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                                </div>
                                <div>
                                    {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
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
            updateLocationChart(@json($chartData['locationChart'] ?? []));
        });

        // Chart instances
        var typesChart = null;
        var locationChart = null;

        function updateTypesChart(data) {
            const ctx = document.getElementById('userTypesChart').getContext('2d');

            if (typesChart) {
                typesChart.destroy();
            }

            typesChart = new Chart(ctx, {
                type: 'doughnut',
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

        function updateLocationChart(data) {
            const ctx = document.getElementById('userLocationChart').getContext('2d');

            if (locationChart) {
                locationChart.destroy();
            }

            locationChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels || [],
                    datasets: [{
                        label: 'Active Users',
                        data: data.data || [],
                        backgroundColor: '#009EF7',
                        borderWidth: 0
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

        function viewUser(id) {
            // Add your view user logic here
            console.log('View user:', id);
        }
    </script>
@endsection
