@extends('layouts.auth_basic')

@section('title', __('Account Login'))

@section('body')

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{route('home')}}" action="{{route('login')}}" method="post">

        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ __("Sign In")}}</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __("New Here?")}}
                <a href="{{route('register')}}" class="link-primary fw-bold"> {{ __("Create an Account")}}  </a>
            </div>
            <!--end::Subtitle=-->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="{{ __("Enter Email")}}" name="email" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Email-->
        </div>
        <!--end::Input group=-->
        <div class="fv-row mb-3">
            <!--begin::Password-->
            <input type="password" placeholder="{{ __("Enter Password")}}" name="password" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Password-->
        </div>
        <!--end::Input group=-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <!--begin::Link-->
            <a href="{{url('password/reset')}}" class="link-primary">{{ __("Forgot Password?")}}</a>
            <!--end::Link-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                <!--begin::Indicator label-->
                <span class="indicator-label">{{ __("Sign In")}}</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress">{{ __("Please wait...")}}
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6" id="agentReg">{{ __("Not a Member yet?")}}
            <a href="{{route('register')}}" class="link-primary">{{ __("Sign Up")}}</a>
        </div>
        <!--end::Sign up-->
        <!--begin::Sign up-->
        {{-- <div class="text-gray-500 text-center fw-semibold fs-6" id="vasReg">{{ __("Need VAS Provider Account?")}}
            <a href="{{route('register.vas')}}" class="link-primary">{{ __("Register VAS Account")}}</a>
        </div> --}}
        <!--end::Sign up-->

    </form>
    <!--end::Form-->

@endsection

@section('js')
    <script src="{{asset('assets/js/mobile-detect.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const md = new MobileDetect(window.navigator.userAgent);
            const agentReg = document.getElementById("agentReg");
            const vasReg = document.getElementById("vasReg");
            if (md.is("iOS")) {
                agentReg.style.display = "block";
                vasReg.style.display = "block";
            } else {
                agentReg.style.display = "block";
                vasReg.style.display = "block";
            }
        });
    </script>
    <script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NZ3CDJHW11"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-NZ3CDJHW11');
    </script>

@endsection
