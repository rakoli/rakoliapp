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
                                <div class="fw-bold mt-5">{{ __("Package Price") }}
                                    {{-- @foreach($packages as $package) --}}
                                        <div class="text-gray-600">
                                            {{ $balance[0]->package->price ?? ''}}
                                        </div>
                                    {{-- @endforeach --}}
                                </div>
                                <div class="fw-bold mt-5">{{ __("Package Expiry At") }}
                                    {{-- @foreach($packages as $package) --}}
                                        <div class="text-gray-600">
                                            {{ $balance[0]->package_expiry_at ?? ''}}
                                        </div>
                                    {{-- @endforeach --}}
                                </div>

                                <div class="fw-bold mt-5">{{__("Features List")}}
                                    <div class="text-gray-600">
                                        @foreach($balance[0]->package->featuress as $pack)
                                           <div class="text-gray-600">
                                                * {{ $pack->feature->name ?? '' }}
                                            </div>
                                        @endforeach
                                        {{-- {{ old('method_name', $existingData[0]->method_ac_name ?? '') }} --}}
                                    </div>
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
                                <div class="card pt-4 h-md-100 mb-6 mb-md-0"  style="background-color: {{ now()->lt($balance[0]->package_expiry_at) ? 'lightgreen' : 'yellow' }}">
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update_method_modal">
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
    <div class="modal fade" tabindex="-1" id="update_method_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__("Update Withdraw Details")}}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form class="my-auto pb-5" action="{{route('business.finance.update')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Name")}}</span>
                                    <input name="method_name" type="text" class="form-control" value="{{ old('method_name', $existingData[0]->method_name ?? '') }}" value="" placeholder="{{__('enter method name')}}"/>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("AC Name")}}</span>
                                    <input name="method_ac_name" type="text" class="form-control" value="{{ old('method_name', $existingData[0]->method_ac_name ?? '') }}" value="" placeholder="{{__('enter method ac name')}}"/>
                                    {{-- <textarea name="description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"></textarea> --}}
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("AC Number")}}</span>
                                    <input name="method_ac_number" type="text" class="form-control" value="{{ old('method_name', $existingData[0]->method_ac_number ?? '') }}" value="" placeholder="{{__('enter method ac number')}}"/>
                                    {{-- <textarea name="description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"></textarea> --}}
                                </div>
                            </div>
                            <!--end::Input group-->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal group-->
        <!--begin::Modal group-->
        <div class="modal fade" tabindex="-1" id="withdraw_method_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">{{__("Add Withdraw Fund Details")}}</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <form class="my-auto pb-5" action="{{route('business.finance.withdraw')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Amount")}}</span>
                                    <input name="amount" type="number" class="form-control" placeholder="{{__('enter amount')}}"/>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Category")}}</span>
                                    <select name="category" class="form-select">
                                        <option value="general">General</option>
                                        <option value="income">Income</option>
                                        <option value="expense">Expense</option>
                                    </select>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Description")}}</span>
                                    {{-- <input name="method_ac_name" type="text" class="form-control" placeholder="{{__('enter method ac name')}}"/> --}}
                                    <textarea name="description" type="text" class="form-control" placeholder="{{__('enter description')}}"></textarea>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
    
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
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

        //ACCOUNT NAME - CLIPBOARD
        const targetAcName = document.getElementById('kt_clipboard_acname');
        const acNameButton = targetAcName.nextElementSibling;
        var acNameClipboard = new ClipboardJS(acNameButton, {
            target: targetAcName,
            text: function() {
                return targetAcName.value;
            }
        });
        acNameClipboard.on('success', function(e) {
            const currentLabel = acNameButton.innerHTML;
            if(acNameButton.innerHTML === 'Copied!'){
                return;
            }
            acNameButton.innerHTML = 'Copied!';
            setTimeout(function(){
                acNameButton.innerHTML = currentLabel;
            }, 3000)
        });
        //END:: ACCOUNT NAME - CLIPBOARD

        //ACCOUNT NUMBER - CLIPBOARD
        const targetAcNumber = document.getElementById('kt_clipboard_acnumber');
        const acNumberButton = targetAcNumber.nextElementSibling;
        var acNumberClipboard = new ClipboardJS(acNumberButton, {
            target: targetAcNumber,
            text: function() {
                return targetAcNumber.value;
            }
        });
        acNumberClipboard.on('success', function(e) {
            const currentLabel = acNumberButton.innerHTML;
            if(acNumberButton.innerHTML === 'Copied!'){
                return;
            }
            acNumberButton.innerHTML = 'Copied!';
            setTimeout(function(){
                acNumberButton.innerHTML = currentLabel;
            }, 3000)
        });
        //END:: ACCOUNT NUMBER - CLIPBOARD

    </script>

@endsection
