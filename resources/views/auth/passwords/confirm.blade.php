@extends('layouts.auth_basic')

@section('title', 'Confirm')

@section('body')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="/login" action="{{ route('password.confirm') }}" method="post">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ $translator("Confirm Password","Thibitisha Nyuwila")}}</h1>
            <!--end::Title-->
            <!--begin::Link-->
            <div class="text-gray-500 fw-semibold fs-6">{{ $translator("Please confirm your password before continuing","Tafadhali thibitisha nyuwila kabla ya kuendelea")}}</div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input id="password" placeholder="{{ $translator("Password","Nyuwila")}}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            <!--end::Email-->
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" id="kt_password_reset_submit" class="btn btn-primary me-4">
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

@endsection
