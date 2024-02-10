@extends('layouts.users.vas')

@section('title', __("Create Task"))

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('vas.opportunities._submenu')

        @include('vas.tasks._form', ['submitUrl'=>route('vas.tasks.store'),'isEdit'=>false])

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    @include('vas.tasks._form_js')
@endsection
