
@extends('layouts.users.agent')

@section('title', __("User Verification "))

@section('header_js')
@endsection

@section('content')
<style>
.w-bg{
    background-color: #fff;
    padding:50px;
}
</style>
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.business._submenu_business')

        @include('agent.business._ad_verification_form')

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
@include('auth.registration_agent.js_verification')
@endsection
