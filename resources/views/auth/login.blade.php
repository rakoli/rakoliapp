@extends('layouts.auth_basic')

@section('title', 'Account Login')

@section('body')

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{route('home')}}" action="{{route('login')}}" method="post">

        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ $translator("Sign In","Ingia")}}</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ $translator("New Here?","Huna akaunti?")}}
                <a href="{{route('register')}}" class="link-primary fw-bold"> {{ $translator("Create an Account","Fungua akaunti")}}  </a>
            </div>
            <!--end::Subtitle=-->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="{{ $translator("Enter Email","Jaza barua pepe")}}" name="email" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Email-->
        </div>
        <!--end::Input group=-->
        <div class="fv-row mb-3">
            <!--begin::Password-->
            <input type="password" placeholder="{{ $translator("Enter Password","Jaza neno siri")}}" name="password" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Password-->
        </div>
        <!--end::Input group=-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <!--begin::Link-->
            <a href="{{url('password/reset')}}" class="link-primary">{{ $translator("Forgot Password?","Umesahau neno la siri?")}}</a>
            <!--end::Link-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                <!--begin::Indicator label-->
                <span class="indicator-label">{{ $translator("Sign In","Ingia")}}</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress">{{ $translator("Please wait...","Tafadhali subiri...")}}
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">{{ $translator("Not a Member yet?","Bado hujajisajili?")}}
            <a href="{{route('register')}}" class="link-primary">{{ $translator("Sign Up","Jiunge")}}</a></div>
        <!--end::Sign up-->
        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">{{ $translator("Need VAS Provider Account? ","Unahitaji Akaunti ya VAS Provider?")}}
            <a href="{{route('register.vas')}}" class="link-primary">{{ $translator("Register VAS Account","Sajili Akaunt ya VAS")}}</a></div>
        <!--end::Sign up-->

    </form>
    <!--end::Form-->

@endsection

@section('js')
    <script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@endsection
