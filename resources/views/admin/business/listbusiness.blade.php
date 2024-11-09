@extends('layouts.users.admin')

@section('title', "List Business")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')

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
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1"></div>
                    <!--end::Search-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Table container-->
                <div class="table-responsive">

                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4' , 'id' => 'bussiness-table']) !!}

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
   <script>
    $(document).ready(function () {
        window.LaravelDataTables['bussiness-table'].on('draw', function () {
            KTMenu.createInstances();
        })
    })
</script>
@endsection
