@extends('layouts.users.vas')

@section('title', __("Create Contract"))

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('vas.opportunities._submenu')

        @include('vas.contracts._form', ['submitUrl'=>route('vas.contracts.store'),'isEdit'=>false])

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    @include('vas.contracts._form_js')
@endsection
