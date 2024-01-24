@extends('layouts.users.agent')

@section('title', __("Payment Methods"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.exchange._submenu_exchange')

        <!--begin::Table-->
        <div class="card card-flush mt-6 mt-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-5">
                <!--begin::Card toolbar-->
                <div class="card-toolbar my-1">
                    <button type="button" class="btn btn-primary m-5" data-bs-toggle="modal" data-bs-target="#add_method_modal">
                        {{__('Add')}}
                    </button>
                </div>
                <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table container-->
                <div class="table-responsive">

                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4'],true) !!}

                </div>
                <!--end::Table container-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->


    </div>
    <!--end::Container-->

    <!--begin::Modal group-->
    <div class="modal fade" tabindex="-1" id="add_method_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__("Add Payment Method")}}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form class="my-auto pb-5" action="{{route('exchange.methods.add')}}" method="POST">
                    @csrf
                    <div class="modal-body">

                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Nickname")}}</span>
                                    <input name="nickname" type="text" class="form-control" value="" placeholder="{{__('enter payment method nickname')}}"/>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <label class="form-label">{{__('Payment Method Name')}}</label>
                                    <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("select payment method name")}}" id="method_name" name="method_name">
                                        <option></option>
                                        @foreach($paymentMethods as $paymentMethod)
                                            <option value="{{$paymentMethod['name']}}">{{$paymentMethod['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Account Name")}}</span>
                                    <input name="account_name" type="text" class="form-control" value="" placeholder="{{__('enter account name')}}"/>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Account Number")}}</span>
                                    <input name="account_number" type="text" class="form-control" value="" placeholder="{{__('enter account number')}}"/>
                                </div>
                            </div>
                            <!--end::Input group-->

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Add')}}</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal group-->

    <!--begin::Modal group-->
    <div class="modal fade" tabindex="-1" id="edit_method_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__("Edit Payment Method")}}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form class="my-auto pb-5" action="{{route('exchange.methods.edit')}}" method="POST">
                    @csrf
                    <input name="edit_id" id="edit_id" type="hidden"/>

                    <div class="modal-body">

                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Nickname")}}</span>
                                <input name="edit_nickname" id="edit_nickname" type="text" class="form-control" value="" placeholder="{{__('enter payment method nickname')}}"/>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <label class="form-label">{{__('Payment Method Name')}}</label>
                                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("select payment method name")}}" id="edit_method_name" name="edit_method_name">
                                    @foreach($paymentMethods as $paymentMethod)
                                        <option value="{{$paymentMethod['name']}}">{{$paymentMethod['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Account Name")}}</span>
                                <input name="edit_account_name" id="edit_account_name" type="text" class="form-control" value="" placeholder="{{__('enter account name')}}"/>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Account Number")}}</span>
                                <input name="edit_account_number" id="edit_account_number" type="text" class="form-control" value="" placeholder="{{__('enter account number')}}"/>
                            </div>
                        </div>
                        <!--end::Input group-->

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Edit')}}</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal group-->

    <!--begin::Modal group-->
    <div class="modal fade" tabindex="-1" id="delete_method_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__("Delete Payment Method")}}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form class="my-auto pb-5" action="{{route('exchange.methods.delete')}}" method="POST">
                    @csrf
                    <input name="delete_id" id="delete_id" type="hidden"/>

                    <div class="modal-body">

                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Payment Method Name")}}</span>
                                <input id="delete_name" type="text" class="form-control" disabled/>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Account Name")}}</span>
                                <input id="delete_account_name" type="text" class="form-control" disabled/>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Account Number")}}</span>
                                <input id="delete_account_number" type="text" class="form-control" disabled/>
                            </div>
                        </div>
                        <!--end::Input group-->

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Delete')}}</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal group-->




@endsection

@section('footer_js')
    <script>
        const methods = JSON.parse('{!! $methodsJson !!}');

        function editClicked(methodIdNo){

            const theMethod = methods.find(item => item.id === methodIdNo);

            document.getElementById('edit_id').value = theMethod.id;
            document.getElementById('edit_nickname').value = theMethod.nickname;
            document.getElementById('edit_account_name').value = theMethod.account_name;
            document.getElementById('edit_account_number').value = theMethod.account_number;

            const selectMethodNameElement = document.getElementById('edit_method_name');
            const optionValueToSelect = theMethod.method_name;

            //Clear previous selection
            for (let i = 0; i < selectMethodNameElement.options.length; i++) {
                selectMethodNameElement.options[i].selected = false;
            }
            // Loop through each option in the select element
            for (let i = 0; i < selectMethodNameElement.options.length; i++) {
                // Check if the current option's value matches the value you want to select
                if (selectMethodNameElement.options[i].value === optionValueToSelect) {
                    // Set the 'selected' attribute of the matching option to true
                    selectMethodNameElement.options[i].selected = true;
                    break; // Break the loop once the option is selected
                }
            }

            const event = new Event('change');
            selectMethodNameElement.dispatchEvent(event);//To ensure value is changed  (bug fix)

        }

        function deleteClicked(methodIdNo){

            const theMethod = methods.find(item => item.id === methodIdNo);

            document.getElementById('delete_id').value = theMethod.id;
            document.getElementById('delete_name').value = theMethod.method_name + " (" +theMethod.nickname+ ")";
            document.getElementById('delete_account_name').value = theMethod.account_name;
            document.getElementById('delete_account_number').value = theMethod.account_number;

            console.log(theMethod);

        }
    </script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
@endsection

