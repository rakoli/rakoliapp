@extends('layouts.users.admin')

@section('title', "Edit Business - " . $business->business_name)

@section('breadcrumb')

@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Edit Business Form-->
        <div class="card card-flush mt-6 mt-xl-9">
            <!--begin::Card header-->
            <div class="card-header align-items-center border-0 mt-4">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bolder mb-2 text-dark">Edit Business</span>
                    <span class="text-muted fw-bold fs-7">{{ $business->business_name }}</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('admin.business.listbusiness') }}" class="btn btn-sm btn-light me-3">
                        Back to List
                    </a>
                    <a href="{{ route('admin.business.viewbusiness', ['code' => $business->code]) }}" class="btn btn-sm btn-primary">
                        View Details
                    </a>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <form action="{{ route('admin.business.updatebusiness', ['code' => $business->code]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                    <!--begin::Business Name-->
                                    <div class="mb-10 fv-row">
                                        <label class="required form-label">Business Name</label>
                                        <input type="text" name="business_name" class="form-control mb-2"
                                               value="{{ old('business_name', $business->business_name) }}" required />
                                        @error('business_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Business Name-->

                                    <!--begin::Business Code-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Business Code</label>
                                        <input type="text" name="code" class="form-control mb-2"
                                               value="{{ $business->code }}" readonly />
                                        <div class="text-muted fs-7">Business code cannot be changed</div>
                                    </div>
                                    <!--end::Business Code-->

                                    <!--begin::Type-->
                                    <div class="mb-10 fv-row">
                                        <label class="required form-label">Type</label>
                                        <select name="type" class="form-select mb-2" required>
                                            <option value="agent" {{ $business->type == 'agent' ? 'selected' : '' }}>Agent</option>
                                            <option value="sales" {{ $business->type == 'sales' ? 'selected' : '' }}>Sales</option>
                                        </select>
                                        @error('type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Type-->

                                    <!--begin::Country-->
                                    <div class="mb-10 fv-row">
                                        <label class="required form-label">Country</label>
                                        <select name="country_code" class="form-select mb-2" required>
                                            <option value="">Select Country</option>
                                            @foreach($countries as $code => $name)
                                                <option value="{{ $code }}" {{ old('country_code', $business->country_code) == $code ? 'selected' : '' }}>
                                                    {{ $name }} ({{ $code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Country-->

                                    <!--begin::Status-->
                                    <div class="mb-10 fv-row">
                                        <label class="required form-label">Status</label>
                                        <select name="status" class="form-select mb-2" required>
                                            <option value="active" {{ $business->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $business->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="suspended" {{ $business->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Status-->

                                    <!--begin::Verified-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Verification Status</label>
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="is_verified" value="1"
                                                   {{ $business->is_verified ? 'checked' : '' }} />
                                            <label class="form-check-label">Verified Business</label>
                                        </div>
                                    </div>
                                    <!--end::Verified-->
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
                                    <!--begin::Email-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Business Email</label>
                                        <input type="email" name="business_email" class="form-control mb-2"
                                               value="{{ old('business_email', $business->business_email) }}" />
                                        @error('business_email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Email-->

                                    <!--begin::Phone-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="business_phone_number" class="form-control mb-2"
                                               value="{{ old('business_phone_number', $business->business_phone_number) }}" />
                                        @error('business_phone_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Phone-->

                                    <!--begin::Location-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Business Location</label>
                                        <textarea name="business_location" class="form-control mb-2" rows="3">{{ old('business_location', $business->business_location) }}</textarea>
                                        @error('business_location')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Location-->

                                    <!--begin::Tax ID-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Tax ID</label>
                                        <input type="text" name="tax_id" class="form-control mb-2"
                                               value="{{ old('tax_id', $business->tax_id) }}" />
                                        @error('tax_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Tax ID-->

                                    <!--begin::Registration Number-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Registration Number</label>
                                        <input type="text" name="business_regno" class="form-control mb-2"
                                               value="{{ old('business_regno', $business->business_regno) }}" />
                                        @error('business_regno')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Registration Number-->

                                    <!--begin::Registration Date-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Registration Date</label>
                                        <input type="date" name="business_reg_date" class="form-control mb-2"
                                               value="{{ old('business_reg_date', $business->business_reg_date ? \Carbon\Carbon::parse($business->business_reg_date)->format('Y-m-d') : '') }}" />
                                        @error('business_reg_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Registration Date-->
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
                                    <!--begin::Package-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Package</label>
                                        <select name="package_code" class="form-select mb-2">
                                            <option value="">Select Package</option>
                                            @foreach($packages as $code => $name)
                                                <option value="{{ $code }}" {{ old('package_code', $business->package_code) == $code ? 'selected' : '' }}>
                                                    {{ ucfirst($name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('package_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Package-->

                                    <!--begin::Trial-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Trial Status</label>
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="is_trial" value="1"
                                                   {{ $business->is_trial ? 'checked' : '' }} />
                                            <label class="form-check-label">Trial Package</label>
                                        </div>
                                    </div>
                                    <!--end::Trial-->

                                    <!--begin::Package Expiry-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Package Expiry Date</label>
                                        <input type="datetime-local" name="package_expiry_at" class="form-control mb-2"
                                               value="{{ old('package_expiry_at', $business->package_expiry_at ? \Carbon\Carbon::parse($business->package_expiry_at)->format('Y-m-d\TH:i') : '') }}" />
                                        @error('package_expiry_at')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Package Expiry-->

                                    <!--begin::Referral Code-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Referral Business Code</label>
                                        <input type="text" name="referral_business_code" class="form-control mb-2"
                                               value="{{ old('referral_business_code', $business->referral_business_code) }}" />
                                        @error('referral_business_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Referral Code-->
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
                                    <!--begin::Balance-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Balance</label>
                                        <input type="number" step="0.01" name="balance" class="form-control mb-2"
                                               value="{{ old('balance', $business->balance) }}" />
                                        @error('balance')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Balance-->

                                    <!--begin::Business Logo-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Business Logo</label>
                                        <input type="file" name="business_logo" class="form-control mb-2" accept="image/*" />
                                        @if($business->business_logo)
                                            <div class="text-muted fs-7 mt-2">
                                                Current logo: {{ basename($business->business_logo) }}
                                            </div>
                                        @endif
                                        @error('business_logo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Business Logo-->

                                    <!--begin::Read Only Fields Info-->
                                    <div class="mb-10">
                                        <div class="notice d-flex bg-light-info rounded border-info border border-dashed p-6">
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-bold">
                                                    <h4 class="text-gray-900 fw-bolder">Read-Only Information</h4>
                                                    <div class="fs-6 text-gray-700">
                                                        <strong>Created:</strong> {{ $business->created_at->format('Y-m-d H:i:s') }}<br>
                                                        <strong>Last Updated:</strong> {{ $business->updated_at->format('Y-m-d H:i:s') }}<br>
                                                        <strong>Last Seen:</strong> {{ $business->last_seen ? \Carbon\Carbon::parse($business->last_seen)->format('Y-m-d H:i:s') : 'Never' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Read Only Fields Info-->
                                </div>
                            </div>
                        </div>
                        <!--end::Financial Information-->
                    </div>

                    <!--begin::Actions-->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-flush">
                                <div class="card-body pt-0">
                                    <div class="d-flex justify-content-end gap-3">
                                        <a href="{{ route('admin.business.listbusiness') }}" class="btn btn-light">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Update Business</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Actions-->

                </form>

            </div>
            <!--end::Card body-->
        </div>
        <!--end::Edit Business Form-->

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
<script>
    // Form validation and submission handling
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const countrySelect = document.querySelector('select[name="country_code"]');
        const packageSelect = document.querySelector('select[name="package_code"]');

        form.addEventListener('submit', function() {
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
        });

        // Update packages when country changes
        countrySelect.addEventListener('change', function() {
            const countryCode = this.value;

            if (countryCode) {
                // Clear current packages
                packageSelect.innerHTML = '<option value="">Loading packages...</option>';

                // Fetch packages for selected country
                fetch(`/admin/business/packages/${countryCode}`)
                    .then(response => response.json())
                    .then(data => {
                        packageSelect.innerHTML = '<option value="">Select Package</option>';
                        if (data.success && data.packages) {
                            data.packages.forEach(package => {
                                const option = document.createElement('option');
                                option.value = package.code;
                                option.textContent = package.name.charAt(0).toUpperCase() + package.name.slice(1);
                                packageSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching packages:', error);
                        packageSelect.innerHTML = '<option value="">Error loading packages</option>';
                    });
            } else {
                packageSelect.innerHTML = '<option value="">Select Package</option>';
            }
        });
    });
</script>
@endsection
