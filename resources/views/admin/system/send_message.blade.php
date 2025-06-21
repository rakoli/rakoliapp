@extends('layouts.users.admin')

@section('title', __("Send Message"))

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">System</small>
    <!--end::Description-->
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('admin.system._send_message_form',['submitUrl'=>route('admin.system.send-message')])

    </div>
    <!--end::Container-->

@endsection