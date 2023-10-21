@extends('layouts.auth_basic')

@section('title', 'Sign Up')

@section('body')

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" data-kt-redirect-url="/confirm-email" action="/register">
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">{{ $translator("Sign Up", "Jisajili") }}</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ $translator("Have an account?", "Umeshajiunga?") }}
                <a href="/" class="link-primary fw-bold"> {{ $translator("Sign in", "Ingia") }}  </a>
            </div>
            <!--end::Subtitle=-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="fv-row flex-row-fluid">
                    <input type="text" placeholder="{{ $translator("First Name", "Jina la Kwanza") }}" name="first-name" autocomplete="off" class="form-control bg-transparent" />
                </div>
                <div class="fv-row flex-row-fluid">
                    <input type="text" placeholder="{{ $translator("Last Name", "Jina la Mwisho") }}" name="last-name" autocomplete="off" class="form-control bg-transparent" />
                </div>
            </div>
        </div>

        <div class="fv-row mb-8">
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="flex-row-fluid" style="max-width: 120px;">
                    <!--begin::Input-->
                    <select  id="countrySelect" class="form-control" name="country">
                        <option value="">{{ $translator("Your Country", "Nchi yako") }}</option>
                        <option value="+254">Kenya</option>
                        <option value="+255">Tanzania</option>
                        <option value="+256">Uganda</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="fv-row flex-row-fluid" style="max-width: 70px;">
                    <!--begin::Input-->
                    <input id="codeInput" class="form-control" placeholder="Code" name="code" readonly placeholder="" value="" />
                    <!--end::Input-->
                </div>
                <div class="fv-row flex-row-fluid">
                    <!--begin::Input-->
                    <input class="form-control" name="phone" placeholder="07XX..." value="" />
                    <!--end::Input-->
                </div>
            </div>
        </div>
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="{{ $translator("Email", "Barua pepe") }}" name="email" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Email-->
        </div>
        <!--begin::Input group-->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="{{ $translator("Password", "Nenosiri") }}" name="password" autocomplete="off" />
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
            <div class="text-muted">{{ $translator("Use 8 or more characters with a mix of letters, numbers & symbols.", "Tumia herufi 8 au zaidi na mchanganyiko wa herufi, nambari, na alama.") }}</div>
            <!--end::Hint-->
        </div>
        <!--end::Input group=-->
        <!--end::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Repeat Password-->
            <input placeholder="{{ $translator("Repeat Password", "Rekebisha Nenosiri") }}" name="confirm-password" type="password" autocomplete="off" class="form-control bg-transparent" />
            <!--end::Repeat Password-->
        </div>
        <!--end::Input group=-->
        <!--begin::Accept-->
        <div class="fv-row mb-8">
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="toc" value="1" />
                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">{{ $translator("I Accept the", "Nakubaliana na") }}
                                        <a href="#" class="ms-1 link-primary">{{ $translator("Terms", "Masharti") }}</a></span>
            </label>
        </div>
        <!--end::Accept-->
        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                <!--begin::Indicator label-->
                <span class="indicator-label">{{ $translator("Sign up", "Jiandikishe") }}</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress">{{ $translator("Please wait...", "Tafadhali subiri...") }}
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
        </div>
        <!--end::Submit button-->
        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">{{ $translator("Already have an Account?", "Tayari una akaunti?") }}
            <a href="/" class="link-primary fw-semibold">{{ $translator("Sign in", "Ingia") }}</a></div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->

@endsection

@section('js')
    <script src="{{asset('assets/js/custom/authentication/sign-up/general.js')}}"></script>
@endsection
