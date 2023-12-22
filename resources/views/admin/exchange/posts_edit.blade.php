@extends('layouts.users.admin')

@section('title', __("Edit Post"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{__('Ads')}}</small>
    <!--end::Description-->
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.exchange._ad_post_form',['submitUrl'=>route('admin.exchange.posts.edit.submit'), 'isEdit'=>true])

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')

    @include('agent.exchange._ad_post_form_js')

    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
{{--    {!! $dataTableHtml->scripts() !!}--}}
@endsection
