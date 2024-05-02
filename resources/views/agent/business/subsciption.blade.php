@extends('layouts.users.agent')

@section('title', __("Subsciption"))

@section('header_js')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
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

                    <!--Begin::Card Footer (Actions)-->
                    <div class="card-body pt-5">

                        <!--Begin::Status Details-->
                        <h1 class="text-center fw-bold">{{__("Details")}}</h1>
                        {{-- <h2 class="mb-5 text-gray-600 text-center">
                            {{$balance[0]->balance}}
                        </h2> --}}
                        <!--End::Status Details-->
                    </div>
                    <!--end::Card Footer (Actions)-->

                    <!--end::Details toggle-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            {{-- <div class="py-5 fs-6 text-center">
                                <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#update_method_modal">
                                    {{__('Update')}}
                                </button>
                            </div> --}}
                            <div class=" fs-6">
                                <div class="fw-bold mt-5">{{ __("Package Name") }}
                                    {{-- @foreach($packages as $package) --}}
                                        <div class="text-gray-600">
                                            {{ $balance[0]->package->name ?? '' }}
                                        </div>
                                    {{-- @endforeach --}}
                                </div>
                                <div class="fw-bold mt-8">{{ __("Package Price") }}
                                    {{-- @foreach($packages as $package) --}}
                                        <div class="text-gray-600">
                                            {{ number_format($balance[0]->package->price) ?? ''}} {{$currency}}
                                        </div>
                                    {{-- @endforeach --}}
                                </div>
                                <div class="fw-bold mt-8">
                                    {{ __("Package Expiry At") }}
                                
                                    {{-- Display Package Expiry Date --}}
                                    <div class="text-gray-600">
                                        {{ $balance[0]->package_expiry_at ?? '' }}
                                    </div>
                                
                                    {{-- Display Days Left --}}
                                    @php
                                        $expiryDateTime = $balance[0]->package_expiry_at ?? null;
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
                                </div>                                

                                {{-- <div class="fw-bold mt-5">{{__("Features List")}}
                                    <div class="text-gray-600">
                                        @foreach($balance[0]->package->featuresAvailable as $pack)
                                           <div class="text-gray-600">
                                                * {{ $pack->feature->name ?? '' }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div> --}}
                                <div class="fw-bold mt-8">{{__("Features List")}}
                                    @foreach(\App\Models\PackageFeature::where("package_code", $balance[0]->package->code)->get() as $packageFeature)
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="fw-bold text-gray-600 flex-grow-1 pe-3">{{$packageFeature->feature->name}}
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
                            </div>
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
                    <div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">
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
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <i class="ki-outline text-info fs-2x"></i>
                                                <div class="ms-2">{{$balance[0]->balance}}  {{$currency}}
                                                {{-- <span class="text-muted fs-4 fw-semibold">Points earned</span> --}}
                                                </div>
                                            </div>
                                            {{-- <div class="fs-7 fw-normal text-muted">Earn reward points with every purchase.</div> --}}
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <div class="col">
                                <!--begin::Card-->
                                <div class="card pt-4 h-md-100 mb-6 mb-md-0"  style="background-color: {{ now()->lt($balance[0]->package_expiry_at) ? 'lightgreen' : 'orange' }}">
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
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <i class="ki-outline text-info fs-2x"></i>
                                                <div class="ms-2">
                                                        {{ now()->lt($balance[0]->package_expiry_at) ? 'Active' : 'Inactive' }}
                                                {{-- <span class="text-muted fs-4 fw-semibold">Points earned</span> --}}
                                                </div>
                                            </div>
                                            {{-- <div class="fs-7 fw-normal text-muted">Earn reward points with every purchase.</div> --}}
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            {{-- <div class="col">
                                <!--begin::Reward Tier-->
                                <a href="#" class="card bg-info hoverable h-md-100">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <i class="ki-outline ki-award text-white fs-3x ms-n1"></i>
                                        <div class="text-white fw-bold fs-2 mt-5">Premium Member</div>
                                        <div class="fw-semibold text-white">Tier Milestone Reached</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Reward Tier-->
                            </div> --}}
                        </div>
                        <div class="py-3 fs-5 text-center">
                            <button type="button" class="btn btn-primary" onclick="selectSubscription('{{$balance[0]->package->code}}','{{strtoupper($balance[0]->package->name)}}', '{{number_format($balance[0]->package->price)}}', '{{strtoupper($currency)}}')" data-bs-toggle="modal" data-bs-target="#confirm_subscription_details">
                                {{__('Renew')}}
                            </button>
                            <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('business.subscription.buy')}}'">
                                {{ __('Upgrade') }}
                            </button>                            
                        </div>
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                           
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Transaction History</h2>
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

                    <input type="hidden" name="selected_plan_code" id="selected_plan_code" value="{{$balance[0]->package->code}}" class="form-control form-control-solid-bg"/>

                    <div class="fv-row">
                        <label for="selected_plan_name" class="required form-label">{{__('Selected Plan')}}</label>
                        <input type="text" name="selected_plan_name" id="selected_plan_name" value="{{strtoupper($balance[0]->package->name)}}" class="form-control form-control-solid-bg" readonly/>
                    </div>

                    <div class="fv-row">
                        <label for="plan_price" class="required form-label">{{__('Price')}}</label>
                        <input type="text" name="plan_price" id="plan_price" class="form-control form-control-solid-bg" value="{{strtoupper($currency)}} {{number_format($balance[0]->package->price)}}" readonly/>
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
                                    <span class="text-muted fw-semibold fs-6">Pay with Visa, MasterCard, Bank and Mobile Money like Mpesa, Airtel Money, TigoPesa, MTN MoMo Pay and Orange Money</span>
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
                                            Pay with Visa, MasterCard, Paypal and Mobile Money like Mpesa (TZ and KE), Airtel Money, TigoPesa, MTN MoMo Pay and Orange Money
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
