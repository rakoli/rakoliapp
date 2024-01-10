@extends('layouts.users.agent')

@section('title', __("Transactions"))

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
                        <h1 class="text-center fw-bold">{{__("Balance")}}</h1>
                        <h2 class="mb-5 text-gray-600 text-center">
                            {{$balance[0]->balance}}
                        </h2>
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
                            <div class="py-5 fs-6">

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
                <div class="card" id="kt_chat_messenger">
                    <!--begin::Card header-->
                    <div class="card-header" id="kt_chat_messenger_header">
                        <!--begin::Title-->
                        <div class="card-title">
                            <!--begin::User-->
                            <div class="d-flex justify-content-center flex-column me-3">
                                {{-- <a href="#" class="fs-1 fw-bold text-gray-900 text-hover-primary me-1 mb-2 mt-5 lh-1">{{__("Transactions")}}</a> --}}
                                <a href="#" class="fs-1 fw-bold text-gray-900 text-hover-primary me-1 mb-2 mt-5 lh-1 text-center">{{__("Transactions")}}</a>
                                <!--begin::Info-->
                                <div class="card-body pt-0">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                    
                                        {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4' , 'style="font-size: 1.1rem;"'],true) !!}
                    
                                    </div>
                                    <!--end::Table container-->
                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card header-->

                    {{-- <div class="separator separator-content border-dark my-5"><span class="w-250px fw-bold">{{__("Payment Method")}}</span></div>

                    <div class="card-body">
                        <div class="input-group input-group-solid input-group-sm mb-5">
                            <span class="input-group-text">{{__('Financial Institution')}}</span>
                            <input type="text" class="form-control" value="{{str_camelcase($exchangeTransaction->paymentMethod->method_name)}}" disabled/>
                        </div>
                        <div class="input-group input-group-solid input-group-sm mb-5">
                            <span class="input-group-text">{{__("Account Name")}}</span>
                            <input id="kt_clipboard_acname" type="text" class="form-control" value="{{str_camelcase($exchangeTransaction->paymentMethod->account_name)}}" readonly/>
                            <button class="btn btn-primary" data-clipboard-target="#kt_clipboard_acname">Copy</button>
                        </div>
                        <div class="input-group input-group-solid input-group-sm mb-5">
                            <span class="input-group-text">{{__("Account Number")}}</span>
                            <input id="kt_clipboard_acnumber" type="text" class="form-control" value="{{str_camelcase($exchangeTransaction->paymentMethod->account_number)}}" readonly/>
                            <button class="btn btn-primary" data-clipboard-target="#kt_clipboard_acnumber">Copy</button>
                        </div>
                    </div> --}}

                </div>
                <!--end::Messenger-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->
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
