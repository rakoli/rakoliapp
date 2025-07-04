<div class="" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-800">

        @if($hasPendingPayment == true)
            <h3 class="fw-bold text-dark">{{__('Pending Payments')}}</h3>

            <div class="table-responsive">
                <table class="table table-rounded table-striped border gy-7 gs-7">
                    <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>{{__('Time Left')}}</th>
                        <th>{{__('Payment For')}}</th>
                        <th>{{__('Amount Due')}}</th>
                        <th>{{__('Payment Method')}}</th>
                        <th>{{__('Pay Link')}}</th>
                    </tr>
                    </thead>
                    <tbody class="table-hover">
                    @foreach($initiatedPayments as $initiatedPayment)
                        <tr>
                            <td>{{\Carbon\Carbon::create($initiatedPayment->expiry_time)->diffForHumans()}}</td>
                            <td>{{\App\Models\Package::where('code',$initiatedPayment->description)->first()->name}}
                                - {{__('annual subscription')}}</td>
                            <td>{{strtoupper($initiatedPayment->amount_currency)}} {{number_format($initiatedPayment->amount)}}</td>
                            <td>{{strtoupper($initiatedPayment->channel)}}</td>
                            <td>
                                <a href="{{$initiatedPayment->pay_url}}"
                                   class="btn btn-bg-light btn-secondary">{{__('Pay Now')}}</a>
                                {{--                                <a type="button" class="btn btn-primary" href="{{$initiatedPayment->pay_url}}">--}}
                                {{--                                    {{__('Pay Now')}}--}}
                                {{--                                </a>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endif


        <!--begin::Heading-->
        <div>
            <!--begin::Title-->
            @if(env('GRACE_PERIOD') == 'true')
                <h2 class="fw-bold text-dark">{{__('Start using Rakoli for Free!')}}</h2>
            @else
                <h2 class="fw-bold text-dark">{{__('Select Package')}}</h2>
            @endif
            <!--end::Title-->
            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">
                @if(env('GRACE_PERIOD') == 'true')
                    {{__('Click Start for Free Now! to start using Rakoli for free.')}}
                @else
                    {{__('Choose a subscription package that fits your business needs')}}
                @endif
            </div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->
        <!--begin::Plans-->
        <div class="d-flex flex-column">

            <!--begin::Row-->
            <div class="row">

                @foreach(\App\Models\Package::where('country_code', auth()->user()->country_code)->where('status',1)->when(env('GRACE_PERIOD') == 'true', function($query) {
                    $query->where('name', 'elite');
                })->get() as $package )

                    <!--begin::Col-->
                    <div class="@if(env('GRACE_PERIOD') == 'true') col-xl-12 @else col-xl-4 @endif">
                        <div class="d-flex h-100 align-items-center m-2">
                            <!--begin::Option-->
                            <div class="w-100 d-flex flex-column flex-center rounded-3 py-15 px-10 bg-secondary"
                                 id="{{$package->code}}"
                                 onclick="selectSubscription('{{$package->code}}','{{strtoupper($package->name)}}', '{{number_format($package->price)}}', '{{strtoupper($package->price_currency)}}')">
                                <!--begin::Heading-->
                                <div class="mb-7 text-center">
                                    <!--begin::Title-->
                                    <h1 class="text-dark mb-5 fw-bolder"
                                        id="package_name">{{strtoupper($package->name)}}</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-gray-600 fw-semibold mb-5">{{$package->description}}</div>
                                    <!--end::Description-->
                                    <!--begin::Price-->
                                    @if(env('GRACE_PERIOD') != 'true')
                                        <div class="text-center">
                                            <span class="mb-2 text-primary">{{strtoupper($package->price_currency)}}</span>
                                            <span
                                                class="fs-3x fw-bold text-primary">{{number_format_short($package->price)}}</span>
                                            <span class="fs-7 fw-semibold opacity-50">/
                                                <span data-kt-element="period">{{$package->package_interval_days}} days</span></span>
                                        </div>
                                    @endif
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
                                <div class="t-btn">
                                    @if(env('GRACE_PERIOD') == 'true')
                                        <button type="button" class="btn btn-lg btn-primary w-100" onclick="selectSubscription('{{$package->code}}','{{strtoupper($package->name)}}', '{{number_format($package->price)}}', '{{strtoupper($package->price_currency)}}','true')">{{__('Start for Free Now!')}}</button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-primary" onclick="selectSubscription('{{$package->code}}','{{strtoupper($package->name)}}', '{{number_format($package->price)}}', '{{strtoupper($package->price_currency)}}')">{{__('Select')}}</button>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="selectSubscription('{{$package->code}}','{{strtoupper($package->name)}}', '{{number_format($package->price)}}', '{{strtoupper($package->price_currency)}}','true')">{{__('Trial')}}</button>
                                    @endif
                                </div>
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
        @if(env('GRACE_PERIOD') != 'true')
            <div class="fv-row">
                {{--            <label for="selected_plan" class="required form-label">Selected Plan</label>--}}
                <input type="hidden" name="selected_plan" id="selected_plan" class="form-control form-control-solid-bg "
                   readonly/>
            </div>
            <!--end::Input group-->
            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6 mb-5 mt-5">{{__('Choose payment method below')}}</div>
            <!--end::Notice-->

            <!--begin::Option-->
            <input type="radio" class="btn-check" name="selected_payment_method" value="pesapal" id="pesapal"
                   onchange="selectPaymentMethod(this)" checked="checked"/>
            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center"
                   for="pesapal">
                <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/pesapal.png')}}"
                                  class="mw-200px mh-70px"></i>
                <span class="d-block fw-semibold text-start">
                <span class="text-gray-900 fw-bold d-block fs-3">PesaPal</span>
                <span class="text-muted fw-semibold fs-6">Pay with Visa, MasterCard, Bank and Mobile Money like Mpesa, Airtel Money, TigoPesa, MTN MoMo Pay and Orange Money</span>
            </span>
            </label>
        @endif
        <!--end::Option-->

        <!--begin::Option-->
        <input type="radio" class="btn-check" name="selected_payment_method" value="selcom" id="selcom"
               onchange="selectPaymentMethod(this)" checked="checked"/>
        @if(env('GRACE_PERIOD') != 'true')
            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center"
                   for="selcom">
                <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/selcom.png')}}"
                                  class="mw-200px mh-70px"></i>
                <span class="d-block fw-semibold text-start">
                <span class="text-gray-900 fw-bold d-block fs-3">Selcom Tanzania</span>
                <span class="text-muted fw-semibold fs-6">Pay with Visa, MasterCard and Mobile Money like Mpesa, Airtel Money, TigoPesa</span>
            </span>
            </label>
            <!--end::Option-->

            <!--begin::Option-->
            {{--        <input type="radio" class="btn-check" name="selected_payment_method" value="dpopay" id="dpopay_method" onchange="selectPaymentMethod(this)"/>--}}
            {{--        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="dpopay_method">--}}
            {{--            <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/DPOPay.webp')}}" class="mw-200px mh-70px"></i>--}}
            {{--            <span class="d-block fw-semibold text-start">--}}
            {{--                <span class="text-gray-900 fw-bold d-block fs-3">DPO Pay</span>--}}
            {{--                <span class="text-muted fw-semibold fs-6">--}}
            {{--                    Pay with Visa, MasterCard, Paypal and Mobile Money like Mpesa (TZ and KE), Airtel Money, TigoPesa, MTN MoMo Pay and Orange Money--}}
            {{--                </span>--}}
            {{--            </span>--}}
            {{--        </label>--}}
        @endif
        <!--end::Option-->

        @if(env('APP_ENV') != 'production')
            <!--begin::Option-->
            @if(env('GRACE_PERIOD') != 'true')
                        <input type="radio" class="btn-check" name="selected_payment_method" value="test" id="test_method"
                               onchange="selectPaymentMethod(this)"/>
                        <label
                            class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                            for="test_method">
                            <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/test_pay.jpg')}}"
                                                                  class="mw-200px mh-70px"></i>
                            <span class="d-block fw-semibold text-start">
                            <span class="text-gray-900 fw-bold d-block fs-3">TEST Pay</span>
                            <span class="text-muted fw-semibold fs-6">
                                Demo payment for testing. (An auto complete button will be provided).
                            </span>
                        </span>
                        </label>
            @endif
            <!--end::Option-->
        @endif

        @if(env('GRACE_PERIOD') != 'true')
            <div class="m-5 fv-row">
                <button id="verify_phone_button" type="button" class="btn btn-primary"
                    onclick="validateSubscriptionAndOpenModal()">
                {{__('Make Payment')}}
                </button>
            </div>
        @endif


    </div>
    <!--end::Wrapper-->

</div>
