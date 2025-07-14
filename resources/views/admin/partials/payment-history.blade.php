<div class="modal fade" id="paymentHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Payment History') }} - {{ $user->name() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Method') }}</th>
                                    <th>{{ __('Reference') }}</th>
                                    <th>{{ __('Processed By') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $payment->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $payment->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">
                                                {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                            </span>
                                        </td>
                                        <td class="fw-bold">
                                            {{ session('currency', 'TZS') }} {{ number_format($payment->amount, 0) }}
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match($payment->payment_status) {
                                                    'paid' => 'badge-success',
                                                    'pending' => 'badge-warning',
                                                    'cancelled' => 'badge-danger',
                                                    'partial' => 'badge-info',
                                                    default => 'badge-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                                        <td>
                                            @if($payment->payment_reference)
                                                <small class="text-muted">{{ $payment->payment_reference }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->processedBy)
                                                <small>{{ $payment->processedBy->name() }}</small>
                                                <br>
                                                <small class="text-muted">{{ $payment->paid_at?->format('M d, Y') }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Summary -->
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Total Earned') }}</span>
                                    <span class="text-gray-400 fw-semibold fs-4">
                                        {{ session('currency', 'TZS') }} {{ number_format($user->getTotalEarnings(), 0) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Total Paid') }}</span>
                                    <span class="text-success fw-semibold fs-4">
                                        {{ session('currency', 'TZS') }} {{ number_format($user->getTotalPaid(), 0) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Pending') }}</span>
                                    <span class="text-warning fw-semibold fs-4">
                                        {{ session('currency', 'TZS') }} {{ number_format($user->getPendingPayments(), 0) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold fs-6 mb-1">{{ __('Balance') }}</span>
                                    <span class="text-danger fw-semibold fs-4">
                                        {{ session('currency', 'TZS') }} {{ number_format($user->getRemainingBalance(), 0) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ki-outline ki-file-deleted fs-3x text-gray-400 mb-3"></i>
                        <h5 class="text-gray-600">{{ __('No payment history found') }}</h5>
                        <p class="text-muted">{{ __('This user has no payment records yet.') }}</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                @if($payments->where('payment_status', 'pending')->count() > 0)
                    <button type="button" class="btn btn-success" onclick="processUserPayments({{ $user->id }})">
                        {{ __('Process Pending Payments') }}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
