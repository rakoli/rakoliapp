@extends('layouts.users.agent')

@section('title', __("Ads"))

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body pt-5">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            <div class="py-5 fs-6">

                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Business")}}</div>
                                <div class="text-gray-600">{{$exchangeAd->business->business_name}}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("general.exchange.trade")}}</div>
                                <div class="text-gray-600">
                                    <div class="text-gray-600">
                                        {{$exchangeAd->trades}} {{__("trades")}} |
                                        {{$exchangeAd->completion}}% {{__('completion')}} |
                                        <i class="ki-solid ki-like fs-6"></i> {{$exchangeAd->feedback}}%
                                    </div>
                                    <div class="text-gray-600">
                                        {{__("Exchange Volume")}}: {{number_format($exchangeAd->business->exchange_stats->volume_traded)}} {{session('currency')}}
                                    </div>
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Address")}}</div>
                                <div class="text-gray-600">
                                    @if(!empty($exchangeAd->business->business_location))
                                        {{$exchangeAd->business->business_location}}
                                    @else
                                        None
                                    @endif
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__('Verification')}}</div>
                                <div class="text-gray-600">
                                    {{__("Phone")}}
                                    @if(!empty(auth()->user()->phone_verified_at))
                                        <i class="ki-duotone ki-verify fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @else
                                        <i class="ki-duotone ki-information fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    @endif
                                    |
                                    {{__("Identification")}}
                                    @if(!empty(auth()->user()->id_verified_at))
                                        <i class="ki-duotone ki-verify fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @else
                                        <i class="ki-duotone ki-information fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    @endif
                                </div>
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Exchange Availability")}}</div>
                                <div class="text-gray-600">{{$exchangeAd->availability_desc}}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Terms")}}</div>
                                <div class="text-gray-600">{{$exchangeAd->terms}}</div>
                                <!--begin::Details item-->
                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bold">{{__("general.exchange.trade")}}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="fs-6 fw-normal mb-10">{{$exchangeAd->description}}</div>

                        <!--begin::Form-->
                        <form class="form" data-kt-redirect-url="{{route('exchange.orders.view','')}}" action="{{route('exchange.ads.openorder')}}" method="post" id="kt_form">

                            <input type="hidden" name="exchange_id" value="{{$exchangeAd->id}}">
                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <div class="col-md-3 text-md-end">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        {{__("Action")}}
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" name="action_select" id="action_select" onchange="actionChanged(this.value)">
                                        <option selected disabled>{{__("Selected desired action")}}</option>
                                        <option value="buy">{{__("Buy (Receive)")}}</option>
                                        <option value="sell">{{__("Sell (Give)")}}</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <div class="col-md-3 text-md-end">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold form-label mt-3" id="action_target_select_label">

                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" name="action_target_select" id="action_target_select">
                                        <option disabled>{{__("Select payment method")}}</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <div class="col-md-3 text-md-end">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold form-label mt-3" id="action_via_select_label">

                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" name="action_via_select" id="action_via_select">
                                        <option disabled>{{__("Select payment method")}}</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <div class="col-md-3 text-md-end">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        {{__("Amount")}}
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <input id="amount" name="amount" type="number" class="form-control" placeholder="{{__("amount for trade")}}" min="{{$exchangeAd->min_amount}}" max="{{$exchangeAd->max_amount}}"/>
                                    <div class="text-gray-600">{{number_format($exchangeAd->min_amount)}} - {{number_format($exchangeAd->max_amount)}} {{$exchangeAd->currency}}</div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <div class="col-md-3 text-md-end">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        {{__("Comment")}}
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control form-control-solid" id="comment" name="comment"></textarea>
                                </div>
                            </div>
                            <!--end::Input group-->



                            <!--begin::Action buttons-->
                            <div class="row py-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <!--begin::Button-->
                                        <a href="{{route('exchange.ads')}}" class="btn btn-light me-3">{{__("Cancel")}}</a>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-primary" id="kt_submit">
                                            <span class="indicator-label">{{__("Open Trade")}}</span>
                                            <span class="indicator-progress">{{__("Please wait...")}}
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Action buttons-->
                        </form>
                        <!--end::Form-->


                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->

        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->
@endsection

@section('footer_js')
    <script>
        var traderSellMethods = JSON.parse('{!! $traderSellMethods->toJson() !!}');
        var traderBuyMethods = JSON.parse('{!! $traderBuyMethods->toJson() !!}');

        var targetLabel = document.getElementById('action_target_select_label');
        var actionLabel = document.getElementById('action_via_select_label');

        function actionChanged(selectedAction) {

            removeAllOptions('action_target_select');
            removeAllOptions('action_via_select');

            if(selectedAction == 'sell'){
                traderSellMethods.forEach(item => {
                    addOption('action_target_select',item.method_name,item.id);
                });
                traderBuyMethods.forEach(item => {
                    addOption('action_via_select',item.method_name,item.id);
                });
                targetLabel.innerHTML = "{{__("Sell")}}";
                actionLabel.innerHTML = "{{__("Receive")}}";
            }

            if(selectedAction == 'buy'){
                traderBuyMethods.forEach(item => {
                    addOption('action_target_select',item.method_name,item.id);
                });
                traderSellMethods.forEach(item => {
                    addOption('action_via_select',item.method_name,item.id);
                });
                targetLabel.innerHTML = "{{__("Buy")}}";
                actionLabel.innerHTML = "{{__("Pay with")}}";
            }
        }

        function removeAllOptions(selectElementId) {
            var select = document.getElementById(selectElementId);
            while (select.options.length > 0) {
                select.remove(0);
            }
        }

        function addOption(selectorId, optionText, optionValue) {
            var select = document.getElementById(selectorId);
            var option = document.createElement("option");

            option.text = optionText;
            option.value = optionValue;

            select.add(option);
        }

    </script>

    <script>
        "use strict";

        // Class definition
        var KTFormGeneral = function () {
            // Elements
            var form;
            var submitButton;
            var validator;

            // Handle form validation
            var handleValidation = function (e) {
                // Init form validation rules. For more info check the FormValidation plugin's official documentation: https://formvalidation.io/
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'action_select': {
                                validators: {
                                    notEmpty: {
                                        message: 'The Action is required'
                                    }
                                }
                            },
                            'action_method_select': {
                                validators: {
                                    notEmpty: {
                                        message: 'The Action Payment Method is required'
                                    }
                                }
                            },
                            'action_for_select': {
                                validators: {
                                    notEmpty: {
                                        message: 'The Action For is required'
                                    }
                                }
                            },
                            'amount': {
                                validators: {
                                    min: 10000,
                                    max: 40000,
                                    message: 'The Amount is required'
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',  // comment to enable invalid state icons
                                eleValidClass: '' // comment to enable valid state icons
                            })
                        }
                    }
                );
            }

            // Handle form submission via AJAX
            var handleSubmitAjax = function (e) {
                // Handle form submit
                submitButton.addEventListener('click', function (e) {
                    // Prevent button default action
                    e.preventDefault();

                    // Validate form
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple clicks
                            submitButton.disabled = true;

                            // Check axios library docs: https://axios-http.com/docs/intro
                            axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {

                                if (response) {

                                    if(response.data.success == true){
                                        form.reset();
                                        const redirectUrl = form.getAttribute("data-kt-redirect-url")+ "/"+ response.data.orderid;
                                        redirectUrl && (location.href = redirectUrl)
                                    }else Swal.fire({
                                        text: response.data.resultExplanation,
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    })
                                } else Swal.fire({
                                    text: "Sorry, errors trying to submit, please try again or contact support",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })


                            }).catch(function (error) {
                                // Show error message
                                Swal.fire({
                                    text: "Error! " + error.response.data.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }).then(() => {
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                            });
                        } else {
                            // Show validation error message
                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                });
            }

            // Function to check if a string is a valid URL
            var isValidUrl = function (url) {
                try {
                    new URL(url);
                    return true;
                } catch (e) {
                    return false;
                }
            }

            // Public functions
            return {
                // Initialization
                init: function () {
                    // Get form and submit button elements
                    form = document.querySelector('#kt_form');
                    submitButton = document.querySelector('#kt_submit');

                    // Get help block element
                    document.querySelector('.fv-help-block');

                    // Initialize form validation
                    handleValidation();

                    // Handle form submission via AJAX
                    handleSubmitAjax();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTFormGeneral.init();
        });

    </script>
@endsection
