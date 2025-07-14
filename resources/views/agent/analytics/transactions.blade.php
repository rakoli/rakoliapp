@extends('layouts.users.agent')

@section('title', "Transaction Analytics")

@section('header_js')
    <!-- No DataTables -->
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Analytics > Transactions</small>
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
                                        <option value="{{ $user->code }}">{{ $user->name }}</option>
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
                                <label for="type_filter" class="form-label">Type</label>
                                <select class="form-select" id="type_filter" name="type">
                                    <option value="">All Types</option>
                                    <option value="money_in">Money In</option>
                                    <option value="money_out">Money Out</option>
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

        <!-- Transactions Table -->
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
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Date/Time</th>
                                        <th>User</th>
                                        <th>Location</th>
                                        <th>Network</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-30px me-3">
                                                        <span class="symbol-label bg-light-primary text-primary fw-semibold">
                                                            {{ $transaction->user ? strtoupper(substr($transaction->user->name, 0, 1)) : 'N' }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold text-hover-primary fs-7">
                                                            {{ $transaction->user ? $transaction->user->name : 'N/A' }}
                                                        </span>
                                                        <span class="text-muted fw-semibold text-muted d-block fs-8">
                                                            {{ $transaction->user ? $transaction->user->email : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $transaction->location ? $transaction->location->name : 'N/A' }}</td>
                                            <td>{{ $transaction->network ? $transaction->network->name : 'Cash' }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = $transaction->type === \App\Utils\Enums\TransactionTypeEnum::MONEY_IN ? 'badge-success' : 'badge-danger';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $transaction->type->value }}</span>
                                            </td>
                                            <td class="text-end">{{ number_format($transaction->amount, 2) }} {{ $transaction->amount_currency }}</td>
                                            <td class="text-end">{{ number_format($transaction->balance_new, 2) }} {{ $transaction->amount_currency }}</td>
                                            <td>{{ $transaction->category ?? 'N/A' }}</td>
                                            <td>{{ $transaction->description ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="text-muted">No transactions found</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $transactions->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script>
        $(document).ready(function() {
            // Apply filters by submitting the form
            $('#applyFilters').click(function() {
                var params = new URLSearchParams();

                var dateFrom = $('#date_from').val();
                var dateTo = $('#date_to').val();
                var userCode = $('#user_filter').val();
                var locationCode = $('#location_filter').val();
                var type = $('#type_filter').val();

                if (dateFrom) params.append('date_from', dateFrom);
                if (dateTo) params.append('date_to', dateTo);
                if (userCode) params.append('user_code', userCode);
                if (locationCode) params.append('location_code', locationCode);
                if (type) params.append('type', type);

                window.location.href = '{{ route('analytics.transactions') }}?' + params.toString();
            });
        });
    </script>
@endsection
