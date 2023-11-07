@extends('layouts.auth_basic')

@section('title', __('Reset Password'))

@section('body')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!--begin::Form-->
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark fw-bolder mb-3">{{ __("Setup New Password")}}</h1>
                    <!--end::Title-->
                    <!--begin::Link-->
                    <div class="text-gray-500 fw-semibold fs-6">{{ __("Have you already reset the password?")}}
                        <a href="{{route('login')}}" class="link-primary fw-bold">{{ __("Sign In")}}</a></div>
                    <!--end::Link-->
                </div>
                <!--begin::Heading-->

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="fv-row mb-8">
                    <input id="email" type="email" class="form-control bg-transparent @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                </div>


                <div class="fv-row mb-8">
                    <input id="password" type="password" placeholder="{{ __("Password")}}" class="form-control bg-transparent @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>
                    <!--begin::Hint-->
                    <div class="text-muted">{{ __("Use 8 or more characters with a mix of letters, numbers & symbols.")}}</div>
                    <!--end::Hint-->
                </div>

                <div class="fv-row mb-8">
                    <input id="password-confirm" type="password" placeholder="{{ __("Repeat Password")}}" class="form-control bg-transparent" name="password_confirmation" required autocomplete="new-password">
                </div>


                <div class="d-grid mb-10">
                    <button type="submit" class="btn btn-primary">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">{{ __("Submit")}}</span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">
                            {{ __("Please wait...")}}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!--end::Indicator progress-->
                    </button>
                </div>

            </form>

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Form-->

@endsection

@section('js')

@endsection
