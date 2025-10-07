@extends('layouts.auth_basic')

@section('title', __('Phone Verification'))

@section('body')
<style>
    .otp-input {
        text-align: center;
        font-size: 1.5rem    // Toast notification helper
    function showToast(message, type = 'success') {
        const toastEl = document.getElementById('notificationToast');
        const toastBody = document.getElementById('toastMessage');

        // Set message
        toastBody.textContent = message;

        // Set color based on type
        toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-warning', 'text-bg-info');
        if (type === 'success') {
            toastEl.classList.add('text-bg-success');
        } else if (type === 'error') {
            toastEl.classList.add('text-bg-danger');
        } else if (type === 'warning') {
            toastEl.classList.add('text-bg-warning');
        } else {
            toastEl.classList.add('text-bg-info');
        }

        // Show toast
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    // Form validation and submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!otpInput.value || otpInput.value.length < 4) {
            showToast('{{ __('Please enter a valid verification code') }}', 'error');
            return;
        }  font-weight: bold;
    }
           .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                showToast('{{ __('OTP sent successfully!') }}', 'success');
                startCountdown();
            } else {
                showToast(data.message || '{{ __('Failed to send OTP. Please try again.') }}', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('{{ __('An error occurred. Please try again.') }}', 'error');
        });n-container {
        max-width: 500px;
        margin: 0 auto;
    }
    .countdown {
        color: #dc3545;
        font-weight: bold;
    }
    .toast-container {
        z-index: 9999;
    }
</style>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
    <div id="notificationToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!--begin::Form-->
<form class="form w-100" id="kt_phone_verification_form" method="POST" action="{{ route('registration.phone.verify.submit') }}">
    @csrf

    <!--begin::Heading-->
    <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3">{{ __('general.LBL_VERIFY_YOUR_PHONE_NUMBER') }}</h1>
        <!--end::Title-->
        <!--begin::Subtitle-->
        <div class="text-gray-500 fw-semibold fs-6 mb-5">
            {{ __('general.LBL_WE_HAVE_SENT_VERIFICATION_CODE') }}<br>
            <strong>{{ $formattedPhone }}</strong>
        </div>
        <!--end::Subtitle-->
    </div>
    <!--end::Heading-->

    @if ($errors->any())
        <div class="alert alert-danger mb-8">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mb-8">
            {{ session('success') }}
        </div>
    @endif

    <!--begin::Input group-->
    <div class="fv-row mb-8">
        <div class="verification-container">
            <label class="form-label fw-bolder text-dark fs-6 mb-3">{{ __('general.LBL_ENTER_OTP') }}</label>
            <input type="text"
                   name="phone_code"
                   class="form-control form-control-lg form-control-solid otp-input"
                   placeholder="123456"
                   maxlength="6"
                   required
                   autocomplete="off" />
        </div>
    </div>
    <!--end::Input group-->

    <!--begin::Actions-->
    <div class="d-grid mb-10">
        <button type="submit" id="kt_phone_verification_submit" class="btn btn-primary">
            <!--begin::Indicator label-->
            <span class="indicator-label">{{ __('general.LBL_VERIFY_PHONE') }}</span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress">{{ __("Please wait...") }}
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
            <!--end::Indicator progress-->
        </button>
    </div>
    <!--end::Actions-->

    <!--begin::Resend-->
    <div class="text-center">
        <div class="text-gray-500 fw-semibold fs-6 mb-3">
            {{ __('general.LBL_DID_NOT_RECEIVE_CODE') }}
        </div>
        <button type="button" id="resend-otp-btn" class="btn btn-link p-0 text-primary fw-bold">
            {{ __('general.LBL_RESEND_CODE') }}
        </button>
        <div id="countdown-timer" class="countdown mt-2" style="display: none;"></div>

        <!--begin::Change Phone-->
        <div class="mt-4">
            <button type="button" id="change-phone-btn" class="btn btn-link p-0 text-primary fw-bold">
                {{ __('Wrong phone number? Click to edit') }}
            </button>
        </div>
        <!--end::Change Phone-->
    </div>
    <!--end::Resend-->
</form>
<!--end::Form-->

@endsection

<!-- Phone Update Modal -->
<div class="modal fade" id="phoneUpdateModal" tabindex="-1" aria-labelledby="phoneUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="phoneUpdateModalLabel">{{ __('Update Phone Number') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="phone-update-form">
                    @csrf
                    <div class="mb-3">
                        <label for="country_code" class="form-label">{{ __('Country') }}</label>
                        <select name="country_code" id="country_code" class="form-select" required>
                            <option value="">{{ __('Select Country') }}</option>
                            @php
                                $countries = \App\Models\Country::orderBy('name')->get();
                            @endphp
                            @foreach($countries as $country)
                                <option value="{{ $country->code }}" {{ $user->country_code == $country->code ? 'selected' : '' }}>
                                    {{ $country->name }} (+{{ $country->dialing_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                        <input type="text"
                               class="form-control"
                               id="phone"
                               name="phone"
                               placeholder="{{ __('Enter phone number') }}"
                               required>
                        <div class="form-text">{{ __('Enter phone number without country code') }}</div>
                    </div>
                    <div class="alert alert-info">
                        <small>{{ __('A new verification code will be sent to the updated number') }}</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" id="update-phone-submit" class="btn btn-primary">
                    <span class="indicator-label">{{ __('Update & Send OTP') }}</span>
                    <span class="indicator-progress" style="display: none;">{{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('kt_phone_verification_form');
    const submitButton = document.getElementById('kt_phone_verification_submit');
    const resendButton = document.getElementById('resend-otp-btn');
    const countdownTimer = document.getElementById('countdown-timer');
    const otpInput = document.querySelector('input[name="phone_code"]');

    let countdownInterval;
    let canResend = true;

    // Form validation and submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!otpInput.value || otpInput.value.length < 4) {
            alert('{{ __("Please enter a valid verification code") }}');
            return;
        }

        // Show loading state
        submitButton.disabled = true;
        submitButton.querySelector('.indicator-label').style.display = 'none';
        submitButton.querySelector('.indicator-progress').style.display = 'inline-block';

        // Submit form
        form.submit();
    });

    // Auto-focus on OTP input
    otpInput.focus();

    // Only allow numeric input
    otpInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Resend OTP functionality
    resendButton.addEventListener('click', function() {
        if (!canResend) return;

        fetch('{{ route("registration.phone.resend") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                alert('{{ __("OTP sent successfully!") }}');
                startCountdown();
            } else {
                alert(data.message || '{{ __("Failed to send OTP. Please try again.") }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __("An error occurred. Please try again.") }}');
        });
    });

    function startCountdown() {
        canResend = false;
        resendButton.disabled = true;
        resendButton.style.display = 'none';
        countdownTimer.style.display = 'block';

        let timeLeft = 60; // 60 seconds countdown

        countdownInterval = setInterval(function() {
            countdownTimer.textContent = `{{ __("Resend available in") }} ${timeLeft}{{ __("s") }}`;
            timeLeft--;

            if (timeLeft < 0) {
                clearInterval(countdownInterval);
                canResend = true;
                resendButton.disabled = false;
                resendButton.style.display = 'inline-block';
                countdownTimer.style.display = 'none';
            }
        }, 1000);
    }

    // Check if we should start countdown (if OTP was recently sent)
    @if(session('otp_sent_recently'))
        startCountdown();
    @endif

    // Phone number update functionality
    const changePhoneBtn = document.getElementById('change-phone-btn');
    const phoneUpdateModal = new bootstrap.Modal(document.getElementById('phoneUpdateModal'));
    const phoneUpdateForm = document.getElementById('phone-update-form');
    const updatePhoneSubmit = document.getElementById('update-phone-submit');

    changePhoneBtn.addEventListener('click', function() {
        phoneUpdateModal.show();
    });

    // Only allow numeric input for phone
    document.getElementById('phone').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    updatePhoneSubmit.addEventListener('click', function() {
        const phone = document.getElementById('phone').value;
        const countryCode = document.getElementById('country_code').value;

        if (!phone || !countryCode) {
            showToast('{{ __('Please fill in all fields') }}', 'warning');
            return;
        }

        if (phone.length < 8) {
            showToast('{{ __('Please enter a valid phone number') }}', 'warning');
            return;
        }

        // Show loading state
        updatePhoneSubmit.disabled = true;
        updatePhoneSubmit.querySelector('.indicator-label').style.display = 'none';
        updatePhoneSubmit.querySelector('.indicator-progress').style.display = 'inline-block';

        fetch('{{ route("registration.phone.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                phone: phone,
                country_code: countryCode
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                phoneUpdateModal.hide();
                showToast(data.message, 'success');
                // Update the displayed phone number
                if (data.formatted_phone) {
                    document.querySelector('.text-gray-500 strong').textContent = data.formatted_phone;
                }
                // Clear the OTP input
                otpInput.value = '';
                otpInput.focus();
                // Start countdown for new OTP
                startCountdown();
            } else {
                showToast(data.message || '{{ __('Failed to update phone number. Please try again.') }}', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('{{ __('An error occurred. Please try again.') }}', 'error');
        })
        .finally(() => {
            // Reset button state
            updatePhoneSubmit.disabled = false;
            updatePhoneSubmit.querySelector('.indicator-label').style.display = 'inline-block';
            updatePhoneSubmit.querySelector('.indicator-progress').style.display = 'none';
        });
    });
});
</script>
@endsection
