@extends('layouts.users.agent')

@section('title', __("Finance"))

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

                    <div class="card-body pt-5">
                        <h1 class="text-center fw-bold">{{__("Balance")}}</h1>
                        <h2 class="mb-5 text-gray-600 text-center">
                            {{$balance[0]->balance}}
                        </h2>
                    </div>

                    <!--end::Details toggle-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            <div class="py-5 fs-6 text-center">
                                <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#update_method_modal">
                                    {{__('Update')}}
                                </button>
                            </div>
                            <div class=" fs-6">
                                <div class="fw-bold mt-5">{{__("Method Name")}}
                                    <div class="text-gray-600">
                                        {{ old('method_name', $existingData[0]->method_name ?? '') }}
                                    </div>
                                </div>

                                <div class="fw-bold mt-5">{{__("Method AC Name")}}
                                    <div class="text-gray-600">
                                        {{ old('method_ac_name', $existingData[0]->method_ac_name ?? '') }}
                                    </div>
                                </div>

                                <div class="fw-bold mt-5">{{__("Method AC Number")}}
                                    <div class="text-gray-600">
                                        {{ old('method_ac_number', $existingData[0]->method_ac_number ?? '') }}
                                    </div>
                                </div>
                     
                                <div class="fw-bold mt-5">{{__("Amount Currency")}}
                                    <div class="text-gray-600">
                                        {{ old('amount_currency', $existingData[0]->amount_currency ?? '') }}
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
                <div class="card" id="kt_chat_messenger">
                    <!--begin::Card header-->
                    <div class="card-header" id="kt_chat_messenger_header">
                        <!--begin::Title-->
                        <div class="card-title">
                            <!--begin::User-->
                            <div class="d-flex justify-content-center flex-column me-3">
                                {{-- <a href="#" class="fs-1 fw-bold text-gray-900 text-hover-primary me-1 mb-2 mt-5 lh-1">{{__("Transactions")}}</a> --}}
                                {{-- <a href="#" class="fs-1 fw-bold text-gray-900 text-hover-primary me-1 mb-2 mt-5 lh-1 text-center">{{__("Transactions")}}</a> --}}
                                                               
                                <!--begin::Info-->
                                <div class="card-body pt-0">
                                    <button type="button" class="btn btn-primary me-1 mb-2 mt-5 lh-1" data-bs-toggle="modal" data-bs-target="#withdraw_method_modal">
                                        {{__('Withdraw Fund')}}
                                    </button>
    
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
                                    <input name="method_ac_name" type="text" class="form-control" value="{{ old('method_ac_name', $existingData[0]->method_ac_name ?? '') }}" value="" placeholder="{{__('enter method ac name')}}"/>
                                    {{-- <textarea name="description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"></textarea> --}}
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("AC Number")}}</span>
                                    <input name="method_ac_number" type="text" class="form-control" value="{{ old('method_ac_number', $existingData[0]->method_ac_number ?? '') }}" value="" placeholder="{{__('enter method ac number')}}"/>
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
