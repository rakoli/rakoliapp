@extends('layouts.auth_basic')

@section('title', __('Agent Registration'))

@section('body')

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" data-kt-redirect-url="{{route('registration.agent')}}" action="{{route('register')}}">

        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ __("Sign Up") }}</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __("Have an account?") }}
                <a href="{{route('login')}}" class="link-primary fw-bold"> {{ __("Sign In") }}  </a>
            </div>
            <!--end::Subtitle=-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="fv-row flex-row-fluid">
                    <input type="text" placeholder="{{ __("First Name") }}" name="fname" autocomplete="off" class="form-control bg-transparent" />
                </div>
                <div class="fv-row flex-row-fluid">
                    <input type="text" placeholder="{{ __("Last Name") }}" name="lname" autocomplete="off" class="form-control bg-transparent" />
                </div>
            </div>
        </div>

        <div class="fv-row mb-8">
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="flex-row-fluid" style="max-width: 160px;">
                    <!--begin::Input-->
                    <select  id="countrySelect" class="form-control bg-transparent" name="country">
                        <option value="">{{ __("Your Country") }}</option>
                        @foreach(\App\Models\Country::all() as $country)
                            <option value="{{$country->dialing_code}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
                <div class="fv-row flex-row-fluid" style="max-width: 70px;">
                    <!--begin::Input-->
                    <input id="codeInput" class="form-control bg-transparent" placeholder="{{__('Code')}}" name="country_dial_code" readonly placeholder="" value="" />
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
            <input type="text" placeholder="{{ __("Email") }}" name="email" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Email-->
        </div>
        <!--begin::Input group-->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="{{ __("Password") }}" name="password" autocomplete="off" />
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
            <div class="text-muted">{{ __("Use 8 or more characters with a mix of letters, numbers & symbols.") }}</div>
            <!--end::Hint-->
        </div>
        <!--end::Input group=-->
        <!--end::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Repeat Password-->
            <input placeholder="{{ __("Repeat Password") }}" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Repeat Password-->
        </div>
        <!--end::Input group=-->
        <!--begin::Accept-->
        <div class="fv-row mb-8">
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="toc" value="1" />
                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">{{ __("I Accept the") }}
                                        <a href="#" class="ms-1 link-primary">{{ __("Terms") }}</a></span>
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
                <span class="indicator-label">{{ __("Sign Up") }}</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress">{{ __("Please wait...") }}
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
        </div>
        <!--end::Submit button-->
        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">{{ __("Already have an Account?") }}
            <a href="{{route('login')}}" class="link-primary fw-semibold">{{ __("Sign In") }}</a></div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->

@endsection

@section('js')
    {!!  GoogleReCaptchaV3::init() !!}
    <script src="{{asset('assets/js/custom/authentication/sign-up/general.js')}}"></script>
@endsection
