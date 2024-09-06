@extends('layouts.users.agent')

@section('title', __("Dashboard"))

@section('header_js')
@endsection
<style>
    .d-flex.flex-column.content-justify-center.flex-row-fluid{width:100%}
    .align-start{align-items: flex-start;}
</style>
@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">


        <!--begin::Row-->
        <div class="row g-5 gx-xl-10 mb-5 mb-xl-10 align-start">

            <!--begin::Col-->
            <div class="col-xxl-6">
                <!--begin::Engage widget 10-->
                <div class="card card-flush h-md-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0" >
                        <!--begin::Wrapper-->
                        <div class="mb-10">
                            <!--begin::Title-->
                            <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                                                    <span class="me-2">Welcome to the leading
                                                    <br />
                                                    <span class="position-relative d-inline-block text-danger">
                                                        <!--begin::Separator-->
                                                        <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                                        <!--end::Separator-->
                                                    </span></span>Sales Management</div>
                            <!--end::Title-->
                            <!--begin::Action-->
                        </div>
                        <!--begin::Wrapper-->
                        <!--begin::Illustration-->
                        <img class="mx-auto h-150px h-lg-200px theme-light-show" src="{{asset('assets/media/illustrations/misc/upgrade.svg')}}" alt="" />
                        <img class="mx-auto h-150px h-lg-200px theme-dark-show" src="{{asset('assets/media/illustrations/misc/upgrade-dark.svg')}}" alt="" />
                        <!--end::Illustration-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Engage widget 10-->
            </div>
            <!--end::Col-->

        </div>
        <!--end::Row-->

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
@endsection
