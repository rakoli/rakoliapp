@extends('layouts.auth_basic')

@section('title', __('general.LBL_AGENT_REGISTRATION'))

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
    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" data-kt-redirect-url="{{route('registration.agent')}}" action="{{route('register')}}">

        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ __("general.LBL_SIGN_UP") }}</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __("Have an account?") }}
                <a href="{{route('login')}}" class="link-primary fw-bold"> {{ __("general.LBL_SIGN_IN") }}  </a>
            </div>
            <!--end::Subtitle=-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="fv-row flex-row-fluid">
                    <input type="text" placeholder="{{ __("general.LBL_BUSINESS_NAME") }}" name="business_name" autocomplete="off" class="form-control bg-transparent" />
                </div>
            </div>
        </div>

        <div class="fv-row mb-8">
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="fv-row flex-row-fluid">
                    <input type="text" placeholder="{{ __("general.LBL_FIRST_NAME") }}" name="fname" autocomplete="off" class="form-control bg-transparent" />
                </div>
                <div class="fv-row flex-row-fluid">
                    <input type="text" placeholder="{{ __("general.LBL_LAST_NAME") }}" name="lname" autocomplete="off" class="form-control bg-transparent" />
                </div>
            </div>
        </div>

        <div class="fv-row mb-8">
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="flex-row-fluid" style="max-width: 160px;">
                    <!--begin::Input-->
                    <select  id="countrySelect" class="form-control bg-transparent" name="country">
                        <option value="">{{ __("general.LBL_YOUR_COUNTRY") }}</option>
                        @foreach(\App\Models\Country::all() as $country)
                            <option value="{{$country->dialing_code}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
                <div class="fv-row flex-row-fluid" style="max-width: 70px;">
                    <!--begin::Input-->
                    <input id="codeInput" class="form-control bg-transparent" placeholder="{{__('general.LBL_CODE')}}" name="country_dial_code" readonly placeholder="" value="" />
                    <!--end::Input-->
                </div>
                <div class="fv-row flex-row-fluid">
                    <!--begin::Input-->
                    <input class="form-control bg-transparent" name="phone" placeholder="07XX..." value="" maxlength="10" />
                    <!--end::Input-->
                </div>
            </div>
        </div>
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="{{ __("general.LBL_EMAIL") }}" name="email" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Email-->
        </div>
        <!--begin::Input group-->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="{{ __("general.LBL_PASSWORD") }}" name="password" autocomplete="off" />
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="ki-outline ki-eye-slash fs-2"></i>
                        <i class="ki-outline ki-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!--end::Input wrapper-->
                <!--begin::Meter-->
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
                <!--end::Meter-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Hint-->
            <div class="text-muted">{{ __("general.MSG_PASSWORD_VALIDATION") }}</div>
            <!--end::Hint-->
        </div>
        <!--end::Input group=-->
        <!--end::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Repeat Password-->
            <input placeholder="{{ __("general.LBL_REPEAT_PASSWORD") }}" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Repeat Password-->
        </div>
        <!--end::Input group=-->
        @if($hasReferral)
            <div class="fv-row mb-8">
                <!--begin::Hint-->
                <div class="text-muted">{{ __("general.MSG_REFERRAL")." \"$referrerName\"" }}</div>
                <!--end::Hint-->
            </div>
            <input name="referral_business_code" type="hidden" value="{{$referrer}}" />
        @else
            <div class="fv-row mb-8">
                <!--begin::Hint-->
                <div class="text-muted">{{ __("general.MSG_REFERRAL")." \"$referrerName\"" }}</div>
                <!--end::Hint-->
                <input name="referral_business_code" placeholder="{{ __("general.LBL_REFERRAL_CODE") }}" class="form-control bg-transparent" type="text" />
            </div>
        @endif
        <!--begin::Accept-->
        <div class="fv-row mb-8">
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="toc" value="1" />
                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">{{ __("general.LBL_TERMS_ACCEPT") }}
                                        <a href="#" class="ms-1 link-primary">{{ __("general.LBL_TERMS") }}</a></span>
            </label>
        </div>
        <!--end::Accept-->

        <div id="register_captcha_id">

        </div>

        {!!  GoogleReCaptchaV3::renderOne('register_captcha_id','register') !!}

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                <!--begin::Indicator label-->
                <span class="indicator-label">{{ __("general.LBL_SIGN_UP") }}</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress">{{ __("general.LBL_WAIT") }}
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
        </div>
        <!--end::Submit button-->
        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">{{ __("general.MSG_ALREADY_HAVE_AN_ACCOUNT") }}
            <a href="{{route('login')}}" class="link-primary fw-semibold">{{ __("general.LBL_SIGN_IN") }}</a></div>
            <div class="playstore-btn" id="playbtn">
                <a href="https://apps.apple.com/tz/app/rakoli/id6457264938" target="_blank"><img src="{{asset('assets/media/app-store.png')}}"></a>
                <a href="https://play.google.com/store/apps/details?id=com.rakolisystems" target="_blank"><img src="{{asset('assets/media/play-store.png')}}"></a>
            </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->

@endsection

@section('js')
<script src="{{asset('assets/js/mobile-detect.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const md = new MobileDetect(window.navigator.userAgent);
            const playbtn = document.getElementById("playbtn");
            if (md.is("iOS")) {
                playbtn.style.display = "flex";
            } else {
                playbtn.style.display = "none";
            }
        });
    </script>
    {!!  GoogleReCaptchaV3::init() !!}
    <script src="{{asset('assets/js/custom/authentication/sign-up/general.js')}}"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NZ3CDJHW11"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-NZ3CDJHW11');
    </script>

@endsection
