@extends('layouts.users.admin')

@section('title', "Sales Users")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Business</small>
    <!--end::Description-->
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Table-->
        <div class="card card-flush mt-6 mt-xl-9">

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Wrapper-->
                <div class="d-flex flex-stack mb-5">
                    <x-a-button route="{{ route('admin.business.users.create') }}">
                        {{ __('Add Sales User') }}
                    </x-a-button>
                </div>
                <!--end::Wrapper-->

                <!--begin::Table container-->
                <div class="table-responsive">

                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4 align-middle' , 'id' => 'user-table'],true) !!}

                </div>
                <!--end::Table container-->


            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->


    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
   {!! $dataTableHtml->scripts() !!}
@endsection
