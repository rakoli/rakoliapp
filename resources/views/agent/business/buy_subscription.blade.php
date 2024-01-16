@include('layouts.components.header_auth')

<div class="" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-800">

    


        <!--begin::Heading-->
        <div>
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">{{__('Select Package')}}</h2>
            <!--end::Title-->
            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">{{__('Choose a subscription package that fits your business needs')}}.</div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->
        <!--begin::Plans-->
        <div class="d-flex flex-column">

            <!--begin::Row-->
            <div class="row">

                @foreach(\App\Models\Package::where('country_code', auth()->user()->country_code)->get() as $package )

                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <div class="d-flex h-100 align-items-center m-2">
                            <!--begin::Option-->
                            <div class="w-100 d-flex flex-column flex-center rounded-3 py-15 px-10 bg-secondary" id="{{$package->code}}" onclick="selectSubscription('{{$package->code}}','{{strtoupper($package->name)}}', '{{number_format($package->price)}}', '{{strtoupper($package->price_currency)}}')">
                                <!--begin::Heading-->
                                <div class="mb-7 text-center">
                                    <!--begin::Title-->
                                    <h1 class="text-dark mb-5 fw-bolder" id="package_name">{{strtoupper($package->name)}}</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-gray-600 fw-semibold mb-5">{{$package->description}}</div>
                                    <!--end::Description-->
                                    <!--begin::Price-->
                                    <div class="text-center">
                                        <span class="mb-2 text-primary">{{strtoupper($package->price_currency)}}</span>
                                        <span class="fs-3x fw-bold text-primary">{{number_format_short($package->price)}}</span>
                                        <span class="fs-7 fw-semibold opacity-50">/
																<span data-kt-element="period">{{$package->package_interval_days}} days</span></span>
                                    </div>
                                    <!--end::Price-->
                                </div>
                                <!--end::Heading-->
                                <!--begin::Features-->
                                <div class="w-100 mb-5">
                                    @foreach(\App\Models\PackageFeature::where("package_code", $package->code)->get() as $packageFeature)
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-5">
                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{$packageFeature->feature->name}}
                                                @if($packageFeature->feature->name == 'tills')
                                                    per branch
                                                @endif
                                                @if($packageFeature->feature_value != null)
                                                    ({{$packageFeature->feature_value}})
                                                @endif
                                            </span>
                                            <i class="ki-outline
                                            @if($packageFeature->available == true)
                                                ki-check-circle fs-1 text-success
                                            @else
                                                ki-cross-circle fs-1
                                            @endif"></i>
                                        </div>
                                        <!--end::Item-->
                                    @endforeach
                                </div>
                                <!--end::Features-->
                                <!--begin::Select-->
                                <button type="button" class="btn btn-sm btn-primary" onclick="selectSubscription('{{$package->code}}','{{strtoupper($package->name)}}', '{{number_format($package->price)}}', '{{strtoupper($package->price_currency)}}')">{{__('Select')}}</button>
                                <!--end::Select-->
                            </div>
                            <!--end::Option-->
                        </div>
                    </div>
                    <!--end::Col-->

                @endforeach

            </div>
            <!--end::Row-->
        </div>
        <!--end::Plans-->
        <!--begin::Input group-->
        <div class="fv-row">
{{--            <label for="selected_plan" class="required form-label">Selected Plan</label>--}}
            <input type="hidden" name="selected_plan" id="selected_plan" class="form-control form-control-solid-bg " readonly/>
        </div>
        <!--end::Input group-->
        <!--begin::Notice-->
        <div class="text-muted fw-semibold fs-6 mb-5 mt-5">{{__('Choose payment method below')}}</div>
        <!--end::Notice-->

        <!--begin::Option-->
        <input type="radio" class="btn-check" name="selected_payment_method" value="pesapal" id="pesapal" onchange="selectPaymentMethod(this)" checked="checked"/>
        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="pesapal">
            <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/pesapal.png')}}" class="mw-200px mh-70px"></i>
            <span class="d-block fw-semibold text-start">
            <span class="text-gray-900 fw-bold d-block fs-3">PesaPal</span>
            <span class="text-muted fw-semibold fs-6">Pay with Visa, MasterCard, Bank and Mobile Money like Mpesa, Airtel Money, TigoPesa, MTN MoMo Pay and Orange Money</span>
        </span>
        </label>
        <!--end::Option-->

        <!--begin::Option-->
        <input type="radio" class="btn-check" name="selected_payment_method" value="dpopay" id="dpopay_method" onchange="selectPaymentMethod(this)"/>
        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="dpopay_method">
            <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/DPOPay.webp')}}" class="mw-200px mh-70px"></i>
            <span class="d-block fw-semibold text-start">
                <span class="text-gray-900 fw-bold d-block fs-3">DPO Pay</span>
                <span class="text-muted fw-semibold fs-6">
                    Pay with Visa, MasterCard, Paypal and Mobile Money like Mpesa (TZ and KE), Airtel Money, TigoPesa, MTN MoMo Pay and Orange Money
                </span>
            </span>
        </label>
        <!--end::Option-->

        @if(env('APP_ENV') != 'production')
                <!--begin::Option-->
                <input type="radio" class="btn-check" name="selected_payment_method" value="test" id="test_method" onchange="selectPaymentMethod(this)"/>
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="test_method">
                    <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/test_pay.jpg')}}" class="mw-200px mh-70px"></i>
                    <span class="d-block fw-semibold text-start">
                <span class="text-gray-900 fw-bold d-block fs-3">TEST Pay</span>
                <span class="text-muted fw-semibold fs-6">
                    Demo payment for testing. (An auto complete button will be provided).
                </span>
            </span>
                </label>
                <!--end::Option-->
        @endif

        <div class="m-5 fv-row">
            <button id="verify_phone_button" type="button" class="btn btn-primary" onclick="validateSubscriptionAndOpenModal()">
                {{__('Make Payment')}}
            </button>
        </div>


    </div>
    <!--end::Wrapper-->
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
{{-- @include('auth.registration_agent.js_steppers_movement')
@include('auth.registration_agent.js_verification')
@include('auth.registration_agent.js_businessdetails') --}}
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
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

    function openModal() {
        var modal = document.getElementById('confirm_subscription_details');
        modal.style.display = 'block';
    }

    function validateSubscriptionAndOpenModal() {
        if (selectedpackage !== "") {
            $('#confirm_subscription_details').modal('show');
        } else {
            toastr.error("Select Package First");
        }
    }
    //END:: SUBSCRIPTION ACTIONS




</script>