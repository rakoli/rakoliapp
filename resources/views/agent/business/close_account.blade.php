
@extends('layouts.users.agent')

@section('title', __("Close Account"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.business._submenu_business')

        @include('agent.business._ad_account_close_form', ['submitUrl'=>route('business.users.close_account')])

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')

    {{-- @include('agent.exchange._ad_post_form_js') --}}

    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
{{--    {!! $dataTableHtml->scripts() !!}--}}
@endsection
