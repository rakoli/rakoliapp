@extends('layouts.users.admin')

@section('title', "View Business - " . $business->business_name)

@section('breadcrumb')

@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Business Details-->
        <div class="card card-flush mt-6 mt-xl-9">
            <!--begin::Card header-->
            <div class="card-header align-items-center border-0 mt-4">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bolder mb-2 text-dark">Business Details</span>
                    <span class="text-muted fw-bold fs-7">{{ $business->business_name }}</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('admin.business.listbusiness') }}" class="btn btn-sm btn-light me-3">
                        Back to List
                    </a>
                    <a href="{{ route('admin.business.editbusiness', ['code' => $business->code]) }}" class="btn btn-sm btn-primary">
                        Edit Business
                    </a>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <div class="row">
                    <!--begin::Basic Information-->
                    <div class="col-lg-6">
                        <div class="card card-flush mb-6">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3>Basic Information</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Business Code:</td>
                                                <td>{{ $business->code }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Business Name:</td>
                                                <td>{{ $business->business_name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Type:</td>
                                                <td><span class="badge badge-light-primary">{{ ucfirst($business->type) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Country:</td>
                                                <td>{{ $business->country_code }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status:</td>
                                                <td>
                                                    @if($business->status == 'active')
                                                        <span class="badge badge-light-success">Active</span>
                                                    @else
                                                        <span class="badge badge-light-danger">{{ ucfirst($business->status) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Verified:</td>
                                                <td>
                                                    @if($business->is_verified)
                                                        <span class="badge badge-light-success">Yes</span>
                                                    @else
                                                        <span class="badge badge-light-warning">No</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Basic Information-->

                    <!--begin::Contact Information-->
                    <div class="col-lg-6">
                        <div class="card card-flush mb-6">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3>Contact Information</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Email:</td>
                                                <td>{{ $business->business_email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Phone:</td>
                                                <td>{{ $business->business_phone_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Location:</td>
                                                <td>{{ $business->business_location ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tax ID:</td>
                                                <td>{{ $business->tax_id ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Registration No:</td>
                                                <td>{{ $business->business_regno ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Registration Date:</td>
                                                <td>{{ $business->business_reg_date ? \Carbon\Carbon::parse($business->business_reg_date)->format('Y-m-d') : 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Contact Information-->
                </div>

                <div class="row">
                    <!--begin::Package Information-->
                    <div class="col-lg-6">
                        <div class="card card-flush mb-6">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3>Package Information</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Package:</td>
                                                <td>{{ $business->package?->name ? ucfirst($business->package->name) : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Package Code:</td>
                                                <td>{{ $business->package_code ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Trial:</td>
                                                <td>
                                                    @if($business->is_trial)
                                                        <span class="badge badge-light-warning">Yes</span>
                                                    @else
                                                        <span class="badge badge-light-success">No</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Package Expiry:</td>
                                                <td>{{ $business->package_expiry_at ? \Carbon\Carbon::parse($business->package_expiry_at)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Referral Code:</td>
                                                <td>{{ $business->referral_business_code ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Package Information-->

                    <!--begin::Financial Information-->
                    <div class="col-lg-6">
                        <div class="card card-flush mb-6">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3>Financial Information</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Balance:</td>
                                                <td class="text-success fw-bold">{{ money($business->balance, currencyCode(), true) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Last Seen:</td>
                                                <td>{{ $business->last_seen ? \Carbon\Carbon::parse($business->last_seen)->format('Y-m-d H:i:s') : 'Never' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Created:</td>
                                                <td>{{ $business->created_at->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Updated:</td>
                                                <td>{{ $business->updated_at->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Financial Information-->
                </div>

                <!--begin::Actions-->
                <div class="row">
                    <div class="col-12">
                        <div class="card card-flush">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3>Actions</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('admin.business.editbusiness', ['code' => $business->code]) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit Business
                                    </a>
                                    <a href="{{ route('admin.business.resetbusiness', ['code' => $business->code]) }}"
                                       class="btn btn-warning btn-sm"
                                       onclick="return confirm('Are you sure you want to reset this business? This action cannot be undone.')">
                                        <i class="fas fa-redo"></i> Reset Business
                                    </a>
                                    <!-- Add more action buttons here as needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Actions-->

            </div>
            <!--end::Card body-->
        </div>
        <!--end::Business Details-->

    </div>
    <!--end::Container-->

@endsection
