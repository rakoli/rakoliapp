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
                <div class="w-lg-750px w-xl-800px p-5 p-lg-10 mx-auto">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <!--begin::Form-->
                    <form class="my-auto pb-5" novalidate="novalidate" id="kt_create_account_form" action="" method="GET">
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

                                <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="submit" onclick="moveToComplete()">
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

                    @include('auth.registration_agent.modal_edit_verificationcontacts')

                    <!--begin::Modal group-->
                    <div class="modal fade" tabindex="-1" id="confirm_subscription_details">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">{{__("Confirm Subscription Details")}}</h3>
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <form class="my-auto pb-5" action="{{route('pay.subscription')}}" method="POST">
                                    @csrf
                                    <div class="modal-body">

                                        <input type="hidden" name="selected_plan_code" id="selected_plan_code" class="form-control form-control-solid-bg"/>

                                        <div class="fv-row">
                                            <label for="selected_plan_name" class="required form-label">{{__('Selected Plan')}}</label>
                                            <input type="text" name="selected_plan_name" id="selected_plan_name" class="form-control form-control-solid-bg" readonly/>
                                        </div>

                                        <div class="fv-row">
                                            <label for="plan_price" class="required form-label">{{__('Price')}}</label>
                                            <input type="text" name="plan_price" id="plan_price" class="form-control form-control-solid-bg" readonly/>
                                        </div>

                                        <div class="fv-row">
                                            <label for="payment_method" class="required form-label">{{__('Payment Method')}}</label>
                                            <input type="text" name="payment_method" id="payment_method" class="form-control form-control-solid-bg" readonly/>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">{{__('Pay Subscription')}}</button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal group-->

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
@include('auth.registration_agent.js_steppers_movement')
@include('auth.registration_agent.js_verification')
@include('auth.registration_agent.js_businessdetails')
<script>

    //START:: VERIFICATION STEP ACTIONS
    //Included Above
    //END:: VERIFICATION STEP ACTIONS


    //END:: BUSINESS DETAILS ACTIONS
    //Included Above
    //END:: BUSINESS DETAILS ACTIONS


    //END:: SUBSCRIPTION ACTIONS
    var selectedpackage = "";
    var selectedpackageName = "";
    var selectedpackagePrice = "";
    var selectedpaymentMethod = "";
    function selectSubscription(subscriptionCode, subscriptionName, subscriptionPrice, currency){
        console.log(subscriptionCode);
        if(selectedpackage !== ""){
            document.getElementById(selectedpackage).classList.remove("bg-gray-400");
            document.getElementById(selectedpackage).classList.add("bg-secondary");
        }
        document.getElementById(subscriptionCode).classList.remove("bg-secondary");
        document.getElementById(subscriptionCode).classList.add("bg-gray-400");
        document.getElementById('selected_plan_code').value = subscriptionCode;
        document.getElementById('selected_plan_name').value = subscriptionName;
        document.getElementById('plan_price').value = currency + ' ' +subscriptionPrice;
        document.getElementById('payment_method').value = document.querySelector('input[name="selected_payment_method"]:checked').value;
        selectedpackage = subscriptionCode;
        selectedpackageName = subscriptionName;
        selectedpackagePrice = currency + ' ' +subscriptionPrice;
        selectedpaymentMethod = document.querySelector('input[name="selected_payment_method"]:checked').value;
    }

    function selectPaymentMethod(method){
        document.getElementById('payment_method').value = method.value;
        selectedpaymentMethod = method.value;
    }
    //END:: SUBSCRIPTION ACTIONS




</script>

<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
