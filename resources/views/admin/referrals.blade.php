@extends('layouts.users.admin')

@section('title', "Sales Users & Referrals")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="page-title d-flex flex-column me-3">
        <h1 class="d-flex text-white fw-bold my-1 fs-3">{{ __('Sales Users & Referrals') }}</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
            <li class="breadcrumb-item text-white opacity-75">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-hover-primary">{{ __('Dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-white opacity-75">{{ __('Sales Users') }}</li>
        </ul>
    </div>
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl pt-8">

        <!--begin::Row-->
        <div class="row gy-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-2 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-people fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format($stats['total_sales_users'])}}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Sales Users')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-primary fs-base">
                            <i class="ki-outline ki-user fs-5 text-primary ms-n1"></i>{{__('Active')}}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-2 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-user-tick fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format($stats['total_referrals'])}}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Total Referrals')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-success fs-base">
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>{{__('All Time')}}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-2 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-shield-tick fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{number_format($stats['active_referrals'])}}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Active Referrals')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-success fs-base">
                            <i class="ki-outline ki-check fs-5 text-success ms-n1"></i>{{__('With Packages')}}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-dollar fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{session('currency', 'TZS')}} {{number_format($stats['total_commission'], 0)}}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Total Commission Value')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-info fs-base">
                            <i class="ki-outline ki-chart-line-up fs-5 text-info ms-n1"></i>{{__('Revenue')}}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-5 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="ki-outline ki-chart-pie-simple fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            @php
                                $conversionRate = $stats['total_referrals'] > 0
                                    ? round(($stats['active_referrals'] / $stats['total_referrals']) * 100, 1)
                                    : 0;
                            @endphp
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{$conversionRate}}%</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">{{__('Conversion Rate')}}</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-{{ $conversionRate >= 50 ? 'success' : ($conversionRate >= 25 ? 'warning' : 'danger') }} fs-base">
                            <i class="ki-outline ki-{{ $conversionRate >= 50 ? 'arrow-up' : ($conversionRate >= 25 ? 'minus' : 'arrow-down') }} fs-5 text-{{ $conversionRate >= 50 ? 'success' : ($conversionRate >= 25 ? 'warning' : 'danger') }} ms-n1"></i>
                            {{ $conversionRate >= 50 ? __('Excellent') : ($conversionRate >= 25 ? __('Good') : __('Needs Work')) }}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">

                    <!--begin::Details content-->
                    <!-- <div class="separator separator-dashed"></div> -->
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            <div class="py-5 fs-6">

                                <div class="fw-bold mt-5">{{__("Total Sales Users")}}</div>
                                <div class="text-gray-600">{{number_format($stats['total_sales_users'])}}</div>

                                <div class="fw-bold mt-5">{{__("Total Referrals Made")}}</div>
                                <div class="text-gray-600">
                                    {{number_format($stats['total_referrals'])}}
                                </div>

                                <div class="fw-bold mt-5">{{__("Active Referrals")}}</div>
                                <div class="text-gray-600">
                                    {{number_format($stats['active_referrals'])}}
                                </div>

                                <div class="fw-bold mt-5">{{__("Total Commission Value")}}</div>
                                <div class="text-gray-600">
                                    {{session('currency', 'TZS')}} {{number_format($stats['total_commission'], 2)}}
                                </div>

                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>

                    <!--begin::Filters-->
                    <div class="separator separator-dashed"></div>
                    <div class="card-body pt-1">
                        <div class="collapse show">
                            <div class="py-5 fs-6">
                                <div class="fw-bold mb-5">{{__("Filters")}}</div>
                                <form method="GET" action="{{ route('admin.referrals.index') }}">
                                    <div class="fv-row mb-5">
                                        <label for="performance_filter" class="form-label">{{ __('Performance') }}</label>
                                        <select class="form-select" name="performance" id="performance_filter">
                                            <option value="">{{ __('All Sales Users') }}</option>
                                            <option value="high_performers" {{ request('performance') == 'high_performers' ? 'selected' : '' }}>{{ __('High Performers (5+ referrals)') }}</option>
                                            <option value="active" {{ request('performance') == 'active' ? 'selected' : '' }}>{{ __('Active (1+ referrals)') }}</option>
                                            <option value="inactive" {{ request('performance') == 'inactive' ? 'selected' : '' }}>{{ __('No Referrals') }}</option>
                                        </select>
                                    </div>
                                    <div class="fv-row mb-5">
                                        <label for="country_filter" class="form-label">{{ __('Country') }}</label>
                                        <select class="form-select" name="country" id="country_filter">
                                            <option value="">{{ __('All Countries') }}</option>
                                            <option value="TZ" {{ request('country') == 'TZ' ? 'selected' : '' }}>{{ __('Tanzania') }}</option>
                                            <option value="KE" {{ request('country') == 'KE' ? 'selected' : '' }}>{{ __('Kenya') }}</option>
                                            <option value="UG" {{ request('country') == 'UG' ? 'selected' : '' }}>{{ __('Uganda') }}</option>
                                            <option value="RW" {{ request('country') == 'RW' ? 'selected' : '' }}>{{ __('Rwanda') }}</option>
                                        </select>
                                    </div>
                                    <div class="fv-row mb-5">
                                        <label for="date_from" class="form-label">{{ __('Registered From') }}</label>
                                        <input type="date" class="form-control" name="date_from" id="date_from" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="fv-row mb-5">
                                        <label for="date_to" class="form-label">{{ __('Registered To') }}</label>
                                        <input type="date" class="form-control" name="date_to" id="date_to" value="{{ request('date_to') }}">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm">{{ __('Filter') }}</button>
                                        <a href="{{ route('admin.referrals.index') }}" class="btn btn-secondary btn-sm">{{ __('Reset') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Filters-->

                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!--begin::Earnings Summary Card-->
                <div class="card card-flush mb-5">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Referral Earnings Summary') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Total Earned') }}</span>
                                    <span class="text-gray-400 fw-semibold fs-4">{{ session('currency', 'TZS') }} {{ number_format($earningStats['total_earned'] ?? 0, 0) }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Total Paid') }}</span>
                                    <span class="text-success fw-semibold fs-4">{{ session('currency', 'TZS') }} {{ number_format($earningStats['total_paid'] ?? 0, 0) }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Pending Payments') }}</span>
                                    <span class="text-warning fw-semibold fs-4">{{ session('currency', 'TZS') }} {{ number_format($earningStats['pending_payments'] ?? 0, 0) }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Outstanding Balance') }}</span>
                                    <span class="text-danger fw-semibold fs-4">{{ session('currency', 'TZS') }} {{ number_format($earningStats['outstanding_balance'] ?? 0, 0) }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Registration Bonuses') }}</span>
                                    <span class="text-gray-400 fw-semibold fs-4">{{ session('currency', 'TZS') }} {{ number_format($earningStats['registration_bonuses'] ?? 0, 0) }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Transaction Bonuses') }}</span>
                                    <span class="text-gray-400 fw-semibold fs-4">{{ session('currency', 'TZS') }} {{ number_format($earningStats['transaction_bonuses'] ?? 0, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Earnings Summary Card-->

                <!--begin::Table-->
                <div class="card card-flush">

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table container-->
                        <div class="table-responsive">

                            {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4'], true) !!}

                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            </div>
            <!--end::Content-->

        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->
@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}

    <!-- Payment Management JavaScript -->
    <script>
        function processPayment(userId) {
            // Get pending payments for the user
            fetch(`/admin/referrals/payments/${userId}/history`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('paymentModalContent').innerHTML = html;
                    $('#paymentModal').modal('show');
                });
        }

        function showPaymentModal(userId, userName, pendingAmount) {
            // First get the pending payments details
            fetch(`/admin/referrals/payments/pending/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.payments && data.payments.length > 0) {
                        let paymentsHtml = '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Type</th><th>Referral</th><th>Amount</th><th>Date</th></tr></thead><tbody>';

                        data.payments.forEach(payment => {
                            paymentsHtml += `<tr>
                                <td>${payment.payment_type}</td>
                                <td>${payment.referral_name}</td>
                                <td>TZS ${new Intl.NumberFormat().format(payment.amount)}</td>
                                <td>${payment.created_at}</td>
                            </tr>`;
                        });

                        paymentsHtml += '</tbody></table></div>';

                        Swal.fire({
                            title: `Process Payment for ${userName}`,
                            html: `
                                <div class="text-start">
                                    <p><strong>Total Pending:</strong> TZS ${new Intl.NumberFormat().format(data.total_pending)}</p>
                                    <p><strong>Business:</strong> ${data.user.business_name}</p>

                                    <div class="mb-4">
                                        <h6>Pending Payments:</h6>
                                        ${paymentsHtml}
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="payment_method" class="form-label">Payment Method *</label>
                                        <select id="payment_method" class="form-select" required>
                                            <option value="">Select payment method</option>
                                            <option value="mobile_money">Mobile Money</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="cash">Cash</option>
                                            <option value="check">Check</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="payment_reference" class="form-label">Payment Reference</label>
                                        <input type="text" id="payment_reference" class="form-control"
                                               placeholder="Transaction ID, Check number, etc.">
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_notes" class="form-label">Notes (Optional)</label>
                                        <textarea id="payment_notes" class="form-control" rows="2"
                                                  placeholder="Additional notes about this payment"></textarea>
                                    </div>
                                </div>
                            `,
                            width: '600px',
                            showCancelButton: true,
                            confirmButtonText: `Pay TZS ${new Intl.NumberFormat().format(data.total_pending)}`,
                            confirmButtonColor: '#28a745',
                            cancelButtonText: 'Cancel',
                            preConfirm: () => {
                                const method = document.getElementById('payment_method').value;
                                const reference = document.getElementById('payment_reference').value;
                                const notes = document.getElementById('payment_notes').value;

                                if (!method) {
                                    Swal.showValidationMessage('Please select a payment method');
                                    return false;
                                }

                                return {
                                    user_id: userId,
                                    payment_method: method,
                                    payment_reference: reference,
                                    notes: notes
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                processReferralPayment(result.value);
                            }
                        });
                    } else {
                        Swal.fire('No Payments', 'No pending payments found for this user.', 'info');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to load payment details.', 'error');
                });
        }

        function processReferralPayment(paymentData) {
            // Show loading
            Swal.fire({
                title: 'Processing Payment...',
                text: 'Please wait while we process the payment.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('/admin/referrals/payments/process-referral', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(paymentData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Payment Processed!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reload the DataTable to show updated payment status
                        if (window.LaravelDataTables && window.LaravelDataTables['dataTableBuilder']) {
                            window.LaravelDataTables['dataTableBuilder'].draw();
                        }
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'An error occurred while processing the payment.', 'error');
            });
        }

        function processUserPayments(userId) {
            Swal.fire({
                title: '{{ __("Process Payments") }}',
                html: `
                    <div class="form-group mb-3">
                        <label for="payment_method" class="form-label">{{ __("Payment Method") }}</label>
                        <select id="payment_method" class="form-select">
                            <option value="mobile_money">{{ __("Mobile Money") }}</option>
                            <option value="bank_transfer">{{ __("Bank Transfer") }}</option>
                            <option value="cash">{{ __("Cash") }}</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="payment_reference" class="form-label">{{ __("Payment Reference") }}</label>
                        <input type="text" id="payment_reference" class="form-control" placeholder="Enter transaction reference">
                    </div>
                    <div class="form-group">
                        <label for="payment_notes" class="form-label">{{ __("Notes (Optional)") }}</label>
                        <textarea id="payment_notes" class="form-control" rows="3" placeholder="Add any notes..."></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '{{ __("Process Payment") }}',
                cancelButtonText: '{{ __("Cancel") }}',
                preConfirm: () => {
                    const method = document.getElementById('payment_method').value;
                    const reference = document.getElementById('payment_reference').value;
                    const notes = document.getElementById('payment_notes').value;

                    if (!method) {
                        Swal.showValidationMessage('{{ __("Please select a payment method") }}');
                        return false;
                    }

                    return {
                        payment_method: method,
                        payment_reference: reference,
                        notes: notes
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Get all pending payment IDs for this user
                    const pendingPayments = getPendingPaymentIds(userId);

                    fetch('/admin/referrals/payments/process', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            payment_ids: pendingPayments,
                            ...result.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('{{ __("Success") }}', data.message, 'success');
                            // Reload the DataTable
                            window.LaravelDataTables['dataTableBuilder'].draw();
                            $('#paymentModal').modal('hide');
                        } else {
                            Swal.fire('{{ __("Error") }}', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('{{ __("Error") }}', '{{ __("An error occurred while processing the payment") }}', 'error');
                    });
                }
            });
        }

        function processBulkPayments() {
            // Get selected users (if implementing bulk selection)
            const selectedUsers = getSelectedUsers();

            if (selectedUsers.length === 0) {
                Swal.fire('{{ __("No Selection") }}', '{{ __("Please select users to process payments for") }}', 'warning');
                return;
            }

            Swal.fire({
                title: '{{ __("Bulk Payment Processing") }}',
                html: `
                    <p>{{ __("Process payments for") }} ${selectedUsers.length} {{ __("selected users") }}</p>
                    <div class="form-group mb-3">
                        <label for="bulk_payment_method" class="form-label">{{ __("Payment Method") }}</label>
                        <select id="bulk_payment_method" class="form-select">
                            <option value="mobile_money">{{ __("Mobile Money") }}</option>
                            <option value="bank_transfer">{{ __("Bank Transfer") }}</option>
                            <option value="cash">{{ __("Cash") }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bulk_reference_prefix" class="form-label">{{ __("Reference Prefix") }}</label>
                        <input type="text" id="bulk_reference_prefix" class="form-control" placeholder="BULK-PAY">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '{{ __("Process All") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    const method = document.getElementById('bulk_payment_method').value;
                    const prefix = document.getElementById('bulk_reference_prefix').value;

                    fetch('/admin/referrals/payments/bulk', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            user_ids: selectedUsers,
                            payment_method: method,
                            payment_reference_prefix: prefix
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('{{ __("Success") }}', data.message, 'success');
                            window.LaravelDataTables['dataTableBuilder'].draw();
                        } else {
                            Swal.fire('{{ __("Error") }}', data.message, 'error');
                        }
                    });
                }
            });
        }

        function exportPayments() {
            window.open('/admin/referrals/payments/export', '_blank');
        }

        // Helper functions
        function getPendingPaymentIds(userId) {
            // This would need to be implemented based on your specific data structure
            // For now, return empty array - this should be populated with actual pending payment IDs
            return [];
        }

        function getSelectedUsers() {
            // This would implement checkbox selection logic for bulk operations
            return [];
        }
    </script>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="paymentModalContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
@endsection
