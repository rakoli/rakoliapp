@extends('layouts.users.agent')

@section('title', "Tills")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Agency</small>
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Tills</small>
    <!--end::Description-->
@endsection

@section('content')


    @push('js')


        <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
                type="text/javascript"></script>



    @endpush

@endsection
