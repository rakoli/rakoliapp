@section('title', __('Agent Registration'))

@include('layouts.components.header_auth')

<!--begin::Body-->
<body id="kt_body" class="auth-bg">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">

    <!--begin::Authentication - Multi-steps-->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid stepper stepper-pills stepper-column stepper-multistep" id="kt_create_account_stepper">


        <!--begin::Aside-->
        <div class="d-flex flex-column flex-lg-row-auto w-lg-350px w-xl-500px">
            <div class="d-flex flex-column position-lg-fixed top-0 bottom-0 w-lg-350px w-xl-500px scroll-y bgi-size-cover bgi-position-center" style="background-color: #409992">
                <!--begin::Header-->
                <div class="d-flex flex-center py-10 py-lg-20 mt-lg-20">
                    <!--begin::Logo-->
                    <a href="#">
                        <img alt="Logo" src="{{asset('assets/media/logo-rakoli/logo_white_full.svg')}}" class="h-60px" />
                    </a>
                    <!--end::Logo-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="d-flex flex-row-fluid justify-content-center p-10">
                    <!--begin::Nav-->
                    <div class="stepper-nav">
                        <!--begin::Step 1-->
                        <div class="stepper-item current" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper">
                                <!--begin::Icon-->
                                <div class="stepper-icon rounded-3">
                                    <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title fs-2">{{__('Verification')}}</h3>
                                    <div class="stepper-desc fw-normal">{{__('Verify your contact information')}}</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 1-->
                        <!--begin::Step 2-->
                        <div class="stepper-item" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper">
                                <!--begin::Icon-->
                                <div class="stepper-icon rounded-3">
                                    <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title fs-2">{{__('Business Information')}}</h3>
                                    <div class="stepper-desc fw-normal">{{__('Enter your business information')}}</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 2-->
                        <!--begin::Step 3-->
                        <div class="stepper-item" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper">
                                <!--begin::Icon-->
                                <div class="stepper-icon">
                                    <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title fs-2">{{__('Subscription')}}</h3>
                                    <div class="stepper-desc fw-normal">{{__('Pay your annual subscription')}}</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 3-->
                        <!--begin::Step 4-->
                        <div class="stepper-item" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper">
                                <!--begin::Icon-->
                                <div class="stepper-icon">
                                    <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">4</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">{{__('Completed')}}</h3>
                                    <div class="stepper-desc fw-normal">{{__('Your account is created')}}</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Step 4-->
                    </div>
                    <!--end::Nav-->

                </div>
                <!--end::Body-->
            </div>
        </div>
        <!--begin::Aside-->


        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid py-10">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-650px w-xl-700px p-10 p-lg-15 mx-auto">


                    <!--begin::Form-->
                    <form class="my-auto pb-5" novalidate="novalidate" id="kt_create_account_form">
                        <!--begin::Step 1-->
                        @include('auth.registration_agent.verification')
                        <!--end::Step 1-->
                        <!--begin::Step 2-->
                        @include('auth.registration_agent.business_details')
                        <!--end::Step 2-->
                        <!--begin::Step 3-->
                        @include('auth.registration_agent.subscription')
                        <!--end::Step 3-->
                        <!--begin::Step 4-->
                        @include('auth.registration_agent.complete')
                        <!--end::Step 4-->
                        <!--begin::Actions-->
                        <div class="d-flex flex-stack pt-15">
{{--                            <div class="mr-2">--}}
{{--                                <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">--}}
{{--                                    <i class="ki-outline ki-arrow-left fs-4 me-1"></i>{{__('Previous')}}</button>--}}
{{--                            </div>--}}
                            <div>

                                <button type="submit" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
											<span class="indicator-label">{{ __("Submit")}}
											<i class="ki-outline ki-arrow-right fs-4 ms-2"></i></span>
                                    <span class="indicator-progress">{{ __("Please wait...")}}
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>

                                <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">{{ __("Continue")}}
                                    <i class="ki-outline ki-arrow-right fs-4 ms-1"></i>
                                </button>

                            </div>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->

                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->

            <!--begin::Footer-->
            <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
                <!--begin::Languages-->
                <div class="me-10">
                    <!--begin::Toggle-->
                    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                        <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ getLocaleSVGImagePath(session('locale')) }}"  alt="" />
                        <span data-kt-element="current-lang-name" class="me-1">{{ localeToLanguage(session('locale'))}}</span>
                        <span class="d-flex flex-center rotate-180">
                            <i class="ki-outline ki-down fs-5 text-muted m-0"></i>
                        </span>
                    </button>
                    <!--end::Toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{route('languageSwitch',['language'=>'en'])}}" class="menu-link d-flex px-5" data-kt-lang="English">
										<span class="symbol symbol-20px me-4">
											<img data-kt-element="lang-flag" class="rounded-1" src="{{ getLocaleSVGImagePath('en') }}" alt="" />
										</span>
                                <span data-kt-element="lang-name">{{ $translator("English", "Kiingereza") }}</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{route('languageSwitch',['language'=>'sw'])}}" class="menu-link d-flex px-5" data-kt-lang="Swahili">
										<span class="symbol symbol-20px me-4">
											<img data-kt-element="lang-flag" class="rounded-1" src="{{ getLocaleSVGImagePath('sw') }}" alt="" />
										</span>
                                <span data-kt-element="lang-name">{{ $translator("Swahili", "Kiswahili") }}</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Languages-->


            </div>
            <!--end::Footer-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Multi-steps-->
</div>
<!--end::Root-->
<!--end::Main-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
@yield('js')

<script>
    "use strict";

    var KTCreateAccount = function() {

        var options = {startIndex: {{$step}} };

        var modalElement = document.querySelector("#kt_modal_create_account");
        var stepperElement = document.querySelector("#kt_create_account_stepper");
        var formElement = stepperElement.querySelector("#kt_create_account_form");
        var submitButton = stepperElement.querySelector('[data-kt-stepper-action="submit"]');
        var nextButton = stepperElement.querySelector('[data-kt-stepper-action="next"]');
        var stepper = new KTStepper(stepperElement, options);

        return {
            init: function() {
                if (modalElement) {
                    new bootstrap.Modal(modalElement);
                }

                if (stepperElement) {
                    stepper.on("kt.stepper.changed", function(e) {
                        if (stepper.getCurrentStepIndex() === 4) {
                            submitButton.classList.remove("d-none");
                            submitButton.classList.add("d-inline-block");
                            nextButton.classList.add("d-none");
                        } else if (stepper.getCurrentStepIndex() === 5) {
                            submitButton.classList.add("d-none");
                            nextButton.classList.add("d-none");
                        } else {
                            submitButton.classList.remove("d-inline-block");
                            submitButton.classList.remove("d-none");
                            nextButton.classList.remove("d-none");
                        }
                    });

                    stepper.on("kt.stepper.next", function(e) {
                        stepper.goNext();
                        KTUtil.scrollTop();
                    });

                    stepper.on("kt.stepper.previous", function(e) {
                        stepper.goPrevious();
                        KTUtil.scrollTop();
                    });
                }
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTCreateAccount.init();

        @if(\App\Utils\VerifyOTP::hasActiveEmailOTP(auth()->user()))
            emailCodeTimer({{\App\Utils\VerifyOTP::emailOTPTimeRemaining(auth()->user())}})
        @endif

        @if(\App\Utils\VerifyOTP::hasActivePhoneOTP(auth()->user()))
            phoneCodeTimer({{\App\Utils\VerifyOTP::phoneOTPTimeRemaining(auth()->user())}})
        @endif

    });


    //START:: VERIFICATION STEP ACTIONS
    function requestEmailCode() {
        console.log("REQUESTED EMAIL CODE");
        var request_emailcode_button = document.getElementById("request_emailcode_button");
        request_emailcode_button.classList.add("disabled")

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        xhr.open("GET", "{{route('request.email.code')}}", true);

        xhr.setRequestHeader("Accept", "application/json");

        // Set up a function to handle the response
        xhr.onload = function () {
            var verify_button = document.getElementById("verify_email_button");

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log("Response Data:", responseData);
                toastr.success(responseData.message, "Send Email Verification");

                if(responseData.message === 'Email already verified'){
                    document.getElementById("email_code").placeholder = "EMAIL ALREADY VERIFIED";
                    document.getElementById("email_code").setAttribute('readonly', true);
                }else{
                    verify_button.classList.remove("disabled");
                    emailCodeTimer({{\App\Utils\VerifyOTP::$validtime}});
                }

            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "Send Email Verification");
            }
            request_emailcode_button.classList.remove("disabled");
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Send the GET request
        xhr.send();
    }

    let emailTimerOn = true;
    function emailCodeTimer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('email_timer').innerHTML = 'Time remaining: '+ m + ':' + s;
        remaining -= 1;

        if(remaining >= 0 && emailTimerOn) {
            setTimeout(function() {
                emailCodeTimer(remaining);
            }, 1000);
            return;
        }

        // Do timeout stuff here
        console.log('EMAIL TIMEOUT STAFF:')
        document.getElementById("verify_email_button").classList.add("disabled")
        document.getElementById("request_emailcode_button").classList.remove("disabled")

    }

    function verifyEmailCode() {
        console.log("VERIFYING EMAIL CODE");
        var inputEmailCode = document.getElementById('email_code').value;
        var verify_button = document.getElementById("verify_email_button");
        verify_button.classList.add("disabled")

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        var url = "{{route('verify.email.code')}}";
        url = url + "?email_code="+inputEmailCode;
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log("Response Data:", responseData);
                toastr.success(responseData.message, "Verify Email Code");
                document.getElementById("request_emailcode_button").classList.add("disabled");
                document.getElementById("email_code").value = "";
                document.getElementById("email_code").placeholder = "EMAIL VERIFIED";
                document.getElementById("email_code").classList.add("disabled");
                document.getElementById("email_code").setAttribute('readonly', true);

            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "Verify Email Code");
            }
            verify_button.classList.remove("disabled");
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Sending data with the request
        xhr.send();
    }

    function requestPhoneCode() {
        console.log("REQUESTED PHONE CODE");
        var request_phonecode_button = document.getElementById("request_phonecode_button");
        request_phonecode_button.classList.add("disabled")

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        xhr.open("GET", "{{route('request.phone.code')}}", true);

        xhr.setRequestHeader("Accept", "application/json");

        // Set up a function to handle the response
        xhr.onload = function () {
            var verify_button = document.getElementById("verify_phone_button");

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log("Response Data:", responseData);
                toastr.success(responseData.message, "Send Phone Verification");
                if(responseData.message === 'Phone already verified'){
                    document.getElementById("phone_code").placeholder = "PHONE ALREADY VERIFIED";
                    document.getElementById("phone_code").setAttribute('readonly', true);
                }else{
                    verify_button.classList.remove("disabled");
                    phoneCodeTimer({{\App\Utils\VerifyOTP::$validtime}});
                }

            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "Send Phone Verification");
            }

            request_phonecode_button.classList.remove("disabled");
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Send the GET request
        xhr.send();
    }

    let phoneTimerOn = true;
    function phoneCodeTimer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('phone_timer').innerHTML = 'Time remaining: '+ m + ':' + s;
        remaining -= 1;

        if(remaining >= 0 && phoneTimerOn) {
            setTimeout(function() {
                phoneCodeTimer(remaining);
            }, 1000);
            return;
        }

        // Do timeout stuff here
        console.log('PHONE TIMEOUT STAFF:')
        document.getElementById("verify_phone_button").classList.add("disabled")
        document.getElementById("request_phonecode_button").classList.remove("disabled")

    }

    function verifyPhoneCode() {
        console.log("VERIFYING PHONE CODE");
        var inputPhoneCode = document.getElementById('phone_code').value;
        var verify_button = document.getElementById("verify_phone_button");
        verify_button.classList.add("disabled")

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        var url = "{{route('verify.phone.code')}}";
        url = url + "?phone_code="+inputPhoneCode;
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                toastr.success(responseData.message, "Verify Phone Code");
                document.getElementById("request_phonecode_button").classList.add("disabled");
                document.getElementById("phone_code").value = "";
                document.getElementById("phone_code").placeholder = "PHONE VERIFIED";
                document.getElementById("phone_code").classList.add("disabled");
                document.getElementById("phone_code").setAttribute('readonly', true);
            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "Verify Phone Code");
            }
            verify_button.classList.remove("disabled");
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Sending data with the request
        xhr.send();
    }
    //END:: VERIFICATION STEP ACTIONS
</script>

{{--<script src="{{asset('assets/js/custom/utilities/modals/create-account.js')}}"></script>--}}
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
