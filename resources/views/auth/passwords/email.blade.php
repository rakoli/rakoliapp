@extends('layouts.auth_basic')

@section('title', __('Email Reset Password'))

@section('body')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="/login" action="{{ route('password.email') }}" method="post">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ __("Forgot Password?")}}</h1>
            <!--end::Title-->
            <!--begin::Link-->
            <div class="text-gray-500 fw-semibold fs-6">{{ __("Enter your email to reset your password")}}</div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="{{__('Email')}}" name="email" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Email-->
        </div>
        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
                <!--begin::Indicator label-->
                <span class="indicator-label">{{ $translator("Submit","Wasilisha")}}</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress">{{ $translator("Please wait...","Tafadhali subiri...")}}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                <!--end::Indicator progress-->
            </button>
            <a href="{{route('login')}}" class="btn btn-light">{{ $translator("Cancel","Acha")}}</a>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->

@endsection

@section('js')

    <script src="{{asset('assets/js/custom/authentication/reset-password/reset-password.js')}}"></script>

@endsection
