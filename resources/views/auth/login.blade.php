@extends('layouts.auth_basic')

@section('title', __('general.LBL_ACCOUNT_LOGIN'))

@section('body')
<style>
    .playstore-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    column-gap: 12px;
    margin-top:20px;
}
.playstore-btn a {
    display: inline-block;
    max-width: 190px;
}
.playstore-btn a img{width:100%}


</style>
    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{route('home')}}" action="{{route('login')}}" method="post">

        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ __("general.LBL_SIGN_IN")}}</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __("general.LBL_NEW_HERE")}}
                <a href="{{route('register')}}" class="link-primary fw-bold"> {{ __("general.LBL_CREATE_ACCOUNT")}}  </a>
            </div>
            <!--end::Subtitle=-->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="{{ __("general.LBL_ENTER_EMAIL")}}" name="email" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Email-->
        </div>
        <!--end::Input group=-->
        <div class="fv-row mb-3">
            <!--begin::Password-->
            <input type="password" placeholder="{{ __("general.LBL_ENTER_PASSWORD")}}" name="password" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Password-->
        </div>
        <!--end::Input group=-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <!--begin::Link-->
            <a href="{{url('password/reset')}}" class="link-primary">{{ __("general.LBL_FORGOT_PASSWORD")}}</a>
            <!--end::Link-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                <!--begin::Indicator label-->
                <span class="indicator-label">{{ __("general.LBL_SIGN_IN")}}</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress">{{ __("general.LBL_PLEASE_WAIT")}}
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6" id="agentReg">{{ __("general.LBL_NOT_A_MEMBER")}}
            <a href="{{route('register')}}" class="link-primary">{{ __("general.LBL_SIGN_UP")}}</a>
        </div>
        <div class="playstore-btn" id="playbtn">
            <a href="https://apps.apple.com/tz/app/rakoli/id6457264938" target="_blank"><img src="{{asset('assets/media/app-store.png')}}"></a>
            <a href="https://play.google.com/store/apps/details?id=com.rakolisystems" target="_blank"><img src="{{asset('assets/media/play-store.png')}}"></a>
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
            const playbtn = document.getElementById("playbtn");
            if (md.is("iOS")) {
                agentReg.style.display = "block";
                playbtn.style.display = "flex";
            } else {
                agentReg.style.display = "block";
                playbtn.style.display = "none";
            }
        });
    </script>
    <script>
        var email_error_msg = "{!! __('general.MSG_EMAIL_IS_REQUIRED') !!}";
        var invalid_email_msg = "{!! __('general.MSG_INVALID_EMAIL') !!}"
        var password_error_msg = "{!! __('general.MSG_PASSWORD_IS_REQUIRED') !!}";
        var login_success_msg = "{!! __('general.MSG_LOGIN_SUCCESSFULLY') !!}";
        var login_error_msg = "{!! __('general.MSG_LOGIN_FAILED') !!}"
        var validation_error_msg = "{!! __('general.MSG_VALIDATION_ERROR') !!}"
        var swal_okay = "{!! __('general.BTN_SWL_OKAY') !!}"

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
