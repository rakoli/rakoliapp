@extends('layouts.users.admin')

@section('title', "Business Performance Analytics")

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Analytics > Business Performance</small>
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
                            <h3 class="fw-bold">Business Performance Filters</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.analytics.businesses') }}" class="row g-3">
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
                                <label for="country_filter" class="form-label">Country</label>
                                <select class="form-select" id="country_filter" name="country_code">
                                    <option value="">All Countries</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->code }}" {{ request('country_code') == $country->code ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status_filter" class="form-label">Status</label>
                                <select class="form-select" id="status_filter" name="status">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Verified</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
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

        <!-- Business Performance Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold">Business Performance Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Business</th>
                                        <th>Country</th>
                                        <th>Status</th>
                                        <th>Users</th>
                                        <th>Shifts</th>
                                        <th>Performance</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($businesses as $business)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-45px me-5">
                                                        <div class="symbol-label fs-3 bg-light-primary text-primary">
                                                            {{ substr($business->business_name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold text-hover-primary fs-6">{{ $business->business_name }}</span>
                                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $business->code }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $business->country ? $business->country->name : 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if($business->is_verified)
                                                    <span class="badge badge-success">Verified</span>
                                                @else
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $business->users_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $business->shifts_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bold d-block fs-6">
                                                        {{ number_format($business->business_account_transactions_sum_amount ?? 0, 2) }}
                                                    </span>
                                                    <span class="text-muted fw-semibold text-muted d-block fs-7">Total Revenue</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">{{ $business->created_at->format('Y-m-d') }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.business.viewbusiness', $business->code) }}" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No businesses found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($businesses->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <div class="text-muted">
                                    Showing {{ $businesses->firstItem() ?? 0 }} to {{ $businesses->lastItem() ?? 0 }} of {{ $businesses->total() }} results
                                </div>
                                <div>
                                    {{ $businesses->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
