@extends('layouts.users.agent')

@section('title', __("Business Roles"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.business._submenu_business')
        
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
                    <h3 class="modal-title">{{__("Add Business Roles")}}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form class="my-auto pb-5" action="{{route('business.roles.add')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Name")}}</span>
                                    <input name="name" type="text" class="form-control" value="" placeholder="{{__('enter name')}}"/>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-5">
                                <div class="input-group input-group-lg mb-5">
                                    <span class="input-group-text">{{__("Description")}}</span>
                                    {{-- <input name="description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"/> --}}
                                    <textarea name="description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"></textarea>
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
                    <h3 class="modal-title">{{__("Edit Business Role")}}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form class="my-auto pb-5" action="{{route('business.roles.edit')}}" method="POST">
                    @csrf
                    <input name="edit_id" id="edit_id" type="hidden"/>

                    <div class="modal-body">

                         <!--begin::Input group-->
                         <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Name")}}</span>
                                <input name="edit_name" id="edit_name" type="text" class="form-control" value="" placeholder="{{__('enter name')}}"/>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Description")}}</span>
                                {{-- <input name="edit_description" id="edit_description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"/> --}}
                                <textarea name="edit_description" id="edit_description" type="text" class="form-control" value="" placeholder="{{__('enter description')}}"></textarea>
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
                    <h3 class="modal-title">{{__("Delete Business Role")}}</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form class="my-auto pb-5" action="{{route('business.roles.delete')}}" method="POST">
                    @csrf
                    <input name="delete_id" id="delete_id" type="hidden"/>

                    <div class="modal-body">

                         <!--begin::Input group-->
                         <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Name")}}</span>
                                <input name="delete_name" id="delete_name" type="text" class="form-control" disabled/>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <div class="input-group input-group-lg mb-5">
                                <span class="input-group-text">{{__("Description")}}</span>
                                {{-- <input name="delete_description" id="delete_description" type="text" class="form-control" disabled/> --}}
                                <textarea name="delete_description" id="delete_description" type="text" class="form-control" disabled></textarea>
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
            document.getElementById('edit_name').value = theMethod.name;
            document.getElementById('edit_description').value = theMethod.description;

            const event = new Event('change');

        }

        function deleteClicked(methodIdNo){

            const theMethod = methods.find(item => item.id === methodIdNo);

            document.getElementById('delete_id').value = theMethod.id;
            document.getElementById('delete_name').value = theMethod.name;
            document.getElementById('delete_description').value = theMethod.description;
        }
    </script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
@endsection
