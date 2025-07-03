@extends('layouts.users.agent')

@section('title', __("Subsciption"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.business._submenu_business')

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">

                    <div class="card-body pt-5 pb-5">

                        @if($business->package != null)
                            <button type="button" class="btn btn-primary m-1" onclick="selectSubscription('{{$business->package->code}}','{{strtoupper($business->package->name)}}', '{{number_format($business->package->price)}}', '{{strtoupper($currency)}}')" data-bs-toggle="modal" data-bs-target="#confirm_subscription_details">
                                {{__('Renew')}}
                            </button>
                        @endif

                        <button type="button" class="btn btn-primary m-1" onclick="window.location.href = '{{route('business.subscription.buy')}}'">
                            {{ __('Purchase') }}
                        </button>

                    </div>

                    <!--end::Details toggle-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <!--Begin::Card Footer (Actions)-->
                    <div class="card-body pt-5 pb-5">
                        <!--Begin::Status Details-->
                        <h1 class="fs-3 text-gray-800 text-hover-primary text-center fw-bold">{{__("Subscription Details")}}</h1>
                        <!--End::Status Details-->
                    </div>

                    <!--end::Details toggle-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            @if($business->package == null)
                                <div class=" fs-6">
                                    <div class="fw-bold mt-5 text-center">{{ __("No Active Package") }}</div>
                                </div>
                            @else
                                <div class=" fs-6">
                                <div class="fw-bold mt-5">{{ __("Package Name") }}</div>
                                <div class="text-gray-600">
                                    {{ ucfirst($business->package->name) ?? '' }}
                                </div>

                                <div class="fw-bold mt-5">{{ __("Package Price") }}</div>
                                <div class="text-gray-600">
                                    {{ number_format($business->package->price) ?? ''}} {{$currency}}
                                </div>


                                <div class="fw-bold mt-5">{{ __("Package Expiry At") }}</div>
                                {{-- Display Package Expiry Date --}}
                                <div class="text-gray-600">
                                    {{ $business->package_expiry_at ?? '' }}
                                </div>
                                {{-- Display Days Left --}}
                                @php
                                    $expiryDateTime = $business->package_expiry_at ?? null;
                                    $daysLeft = null;

                                    if ($expiryDateTime) {
                                        $now = now(); // Assuming Laravel's now() helper function is available
                                        $expiryTime = \Carbon\Carbon::parse($expiryDateTime);

                                        if ($expiryTime > $now) {
                                            $daysLeft = $now->diffInDays($expiryTime);
                                        } else {
                                            $daysLeft = 0; // Package has expired
                                        }
                                    }
                                @endphp
                                @if($daysLeft !== null)
                                    <div class="text-gray-600">
                                        @if($daysLeft > 0)
                                            {{ __("Days Left") }}: {{ $daysLeft }} {{ __("day(s)") }}
                                        @else
                                            {{ __("Expired") }}
                                        @endif
                                    </div>
                                @endif


                                <div class="fw-bold mt-5">{{__("Features List")}}</div>
                                @foreach(\App\Models\PackageFeature::where("package_code", $business->package->code)->get() as $packageFeature)
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-1">
                                            <span class="text-gray-600 flex-grow-1 pe-3">{{str_camelcase($packageFeature->feature->name)}}
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
                            @endif
                        </div>
                        <!--end::Details content-->
                    </div>

                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!--begin::Messenger-->
                    <!--begin::Card header-->
                    <div class="tab-pane fade show active" role="tabpanel">

                        @if($hasPendingPayment == true)

                            <div class="card pt-4 mb-6 mb-xl-9 mt-5">
                                <h3 class="fw-bold text-dark m-5">{{__('Pending Payments')}}</h3>

                                <div class="table-responsive m-5">
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
                                                <td>{{\App\Models\Package::where('code',$initiatedPayment->description)->first()->name}} - {{__('annual subscription')}}</td>
                                                <td>{{strtoupper($initiatedPayment->amount_currency)}} {{number_format($initiatedPayment->amount)}}</td>
                                                <td>{{strtoupper($initiatedPayment->channel)}}</td>
                                                <td>
                                                    <a href="{{$initiatedPayment->pay_url}}" class="btn btn-bg-light btn-secondary">{{__('Pay Now')}}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        @endif

                        <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-1">
                            <div class="col">
                                <!--begin::Card-->
                                <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            {{-- <h2 class="fw-bold">Reward Points</h2> --}}
                                            <h2 class="fw-bold">
                                                <h1 class="text-center fw-bold">{{__("Business Balance")}}</h1>
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="fs-2">
                                            <div class="d-flex">
                                                <i class="ki-outline text-info fs-2x"></i>
                                                <div class="ms-2">{{number_format($business->balance)}}  {{$currency}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <div class="col">
                                <!--begin::Card-->
                                <div class="card pt-4 h-md-100 mb-6 mb-md-0"
                                     @if($business->package == null)
                                         style="background-color: indianred"
                                     @else
                                         style="background-color: {{ now()->lt($business->package_expiry_at) ? 'lightgreen' : 'orange' }}"
                                     @endif
                                >
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            {{-- <h2 class="fw-bold">Reward Points</h2> --}}
                                            <h2 class="fw-bold">
                                                <h1 class="text-center fw-bold">{{__("Current Subscription")}}</h1>
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="fs-2">
                                            <div class="d-flex">
                                                <i class="ki-outline text-info fs-2x"></i>
                                                <div class="ms-2">
                                                    @if($business->package == null)
                                                        {{__('No Active')}}
                                                    @else
                                                        {{ now()->lt($business->package_expiry_at) ? __('Active') : __('Inactive') }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                        </div>

                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9 mt-5">
                            <!--begin::Card header-->

                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>{{__('Transaction History')}}</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--begin::Table-->

                                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4' , 'style="font-size: 1.1rem;"'],true) !!}

                                <!--end::Table -->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Card header-->
                <!--end::Messenger-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->

    @if($business->package != null)
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

                            <input type="hidden" name="selected_plan_code" id="selected_plan_code" value="{{$business->package->code}}" class="form-control form-control-solid-bg"/>

                            <div class="fv-row">
                                <label for="selected_plan_name" class="required form-label">{{__('Selected Plan')}}</label>
                                <input type="text" name="selected_plan_name" id="selected_plan_name" value="{{strtoupper($business->package->name)}}" class="form-control form-control-solid-bg" readonly/>
                            </div>

                            <div class="fv-row">
                                <label for="plan_price" class="required form-label">{{__('Price')}}</label>
                                <input type="text" name="plan_price" id="plan_price" class="form-control form-control-solid-bg" value="{{strtoupper($currency)}} {{number_format($business->package->price)}}" readonly/>
                            </div>

                            <div class="fv-row">
                                {{--            <label for="selected_plan" class="required form-label">Selected Plan</label>--}}
                                <input type="hidden" name="selected_plan" id="selected_plan" class="form-control form-control-solid-bg " readonly/>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Notice-->
                            <div class="text-muted fw-semibold fs-6 mb-5 mt-5">{{__('Choose payment method below')}}</div>
                            <!--end::Notice-->

                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="payment_method" id="pesapal_method" value="pesapal" onchange="selectPaymentMethod(this)" checked="checked"/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="pesapal_method">
                                <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/pesapal.png')}}" class="mw-200px mh-70px"></i>
                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-3">PesaPal</span>
                                    <span class="text-muted fw-semibold fs-6">Pay with Visa, MasterCard, Bank and Mobile Money like Mpesa, Airtel Money, Mixx by Yas, MTN MoMo Pay and Orange Money</span>
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="payment_method" id="dpopay_method" value="dpopay" onchange="selectPaymentMethod(this)"/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="dpopay_method">
                                <i class="ki-duotone fs-4x me-4"><img src="{{asset('assets/media/misc/DPOPay.webp')}}" class="mw-200px mh-70px"></i>
                                <span class="d-block fw-semibold text-start">
                                        <span class="text-gray-900 fw-bold d-block fs-3">DPO Pay</span>
                                        <span class="text-muted fw-semibold fs-6">
                                            Pay with Visa, MasterCard, Paypal and Mobile Money like Mpesa (TZ and KE), Airtel Money, Mixx by Yas, MTN MoMo Pay and Orange Money
                                        </span>
                                    </span>
                            </label>
                            <!--end::Option-->

                            @if(env('APP_ENV') != 'production')
                                <!--begin::Option-->
                                <input type="radio" class="btn-check" name="payment_method" id="test_method" value="test" onchange="selectPaymentMethod(this)"/>
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
    @endif

@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>

    {!! $dataTableHtml->scripts() !!}

    <script>
        var selectedpackage = "";
        var selectedpackageName = "";
        var selectedpackagePrice = "";
        var selectedpaymentMethod = "";
        var selectedPlan = "";

        function selectSubscription(subscriptionCode, subscriptionName, subscriptionPrice, currency) {
            console.log(subscriptionCode);
            document.getElementById('selected_plan_code').value = subscriptionCode;
            document.getElementById('selected_plan_name').value = subscriptionName;
            document.getElementById('selected_plan').value = selectedPlan;
            document.getElementById('plan_price').value = currency + ' ' + subscriptionPrice;
            document.getElementById('payment_method').value = document.querySelector('input[name="payment_method"]:checked').value;
            selectedpackage = subscriptionCode;
            selectedpackageName = subscriptionName;
            selectedpackagePrice = currency + ' ' + subscriptionPrice;
            selectedpaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        }

        function selectPaymentMethod(element) {
            // Update the value of selected_plan based on the selected payment method
            var selectedPlan = ''; // Update this variable based on your logic
            document.getElementById('selected_plan').value = selectedPlan;
        }
    </script>

@endsection
