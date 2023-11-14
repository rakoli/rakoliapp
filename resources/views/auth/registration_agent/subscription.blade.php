<div class="" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-800">
        <!--begin::Heading-->
        <div>
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">Select Package</h2>
            <!--end::Title-->
            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">Choose a subscription package that fits your business needs.</div>
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
                            <div class="w-100 d-flex flex-column flex-center rounded-3 py-15 px-10 bg-secondary" id="{{$package->code}}" onclick="selectSubscription('{{$package->code}}')">
                                <!--begin::Heading-->
                                <div class="mb-7 text-center">
                                    <!--begin::Title-->
                                    <h1 class="text-dark mb-5 fw-bolder">{{strtoupper($package->name)}}</h1>
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
                                <button type="button" class="btn btn-sm btn-primary" onclick="selectSubscription('{{$package->code}}')">Select</button>
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
        <div class="text-muted fw-semibold fs-6 mb-5 mt-5">Choose payment method below</div>
        <!--end::Notice-->


        <!--begin::Option-->
        <input type="radio" class="btn-check" name="selected_payment_method" value="apps" checked="checked"  id="kt_radio_buttons_2_option_1"/>
        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="kt_radio_buttons_2_option_1">
            <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/DPOPay.webp')}}" class="mw-200px mh-70px"></i>

            <span class="d-block fw-semibold text-start">
                <span class="text-gray-900 fw-bold d-block fs-3">DPO Pay</span>
                <span class="text-muted fw-semibold fs-6">
                    Pay with Visa, MasterCard, Paypal and Mobile Money like Mpesa (TZ and KE), Airtel Money, TigoPesa, MTN MoMo Pay and Orange Money
                </span>
            </span>
        </label>
        <!--end::Option-->

        <!--begin::Option-->
        <input type="radio" class="btn-check" name="selected_payment_method" value="sms" id="kt_radio_buttons_2_option_2"/>
        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="kt_radio_buttons_2_option_2">
            <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/nmblogo.png')}}" class="mw-200px mh-70px"></i>

            <span class="d-block fw-semibold text-start">
            <span class="text-gray-900 fw-bold d-block fs-3">NMB Bank (TZ Only)</span>
            <span class="text-muted fw-semibold fs-6">Pay via NMB Bank Agent and Tanzania local all mobile money providers like Mpesa, TigoPesa, AirtelMoney and HaloPesa.</span>
        </span>
        </label>
        <!--end::Option-->

        <div class="m-5 fv-row">
            <button id="verify_phone_button" type="button" class="btn btn-primary">
                {{__('Make Payment')}}
            </button>
        </div>


    </div>
    <!--end::Wrapper-->

</div>
