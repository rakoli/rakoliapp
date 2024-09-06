@extends('layouts.users.admin')

@section('title', __("Add Sales User"))

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

        @include('admin.business._add_user_form',['submitUrl'=>route('admin.business.users.store'), 'isEdit'=>false])

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    @include('agent.exchange._ad_post_form_js')
@endsection
