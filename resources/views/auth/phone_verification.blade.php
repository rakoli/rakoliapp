@extends('layouts.auth_basic')

@section('title', __('Phone Verification'))

@section('body')
<style>
    .otp-input {
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
    }
    .verification-container {
        max-width: 500px;
        margin: 0 auto;
    }
    .countdown {
        color: #dc3545;
        font-weight: bold;
    }
</style>

<!--begin::Form-->
<form class="form w-100" id="kt_phone_verification_form" method="POST" action="{{ route('registration.phone.verify.submit') }}">
    @csrf

    <!--begin::Heading-->
    <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3">{{ __("Verify Your Phone Number") }}</h1>
        <!--end::Title-->
        <!--begin::Subtitle-->
        <div class="text-gray-500 fw-semibold fs-6 mb-5">
            {{ __("We've sent a verification code to") }}<br>
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
            <label class="form-label fw-bolder text-dark fs-6 mb-3">{{ __("Enter Verification Code") }}</label>
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
            <span class="indicator-label">{{ __("Verify Phone") }}</span>
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
            {{ __("Didn't receive the code?") }}
        </div>
        <button type="button" id="resend-otp-btn" class="btn btn-link p-0 text-primary fw-bold">
            {{ __("Resend Code") }}
        </button>
        <div id="countdown-timer" class="countdown mt-2" style="display: none;"></div>
    </div>
    <!--end::Resend-->
</form>
<!--end::Form-->

@endsection

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
});
</script>
@endsection
