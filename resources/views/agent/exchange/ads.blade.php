@extends('layouts.users.agent')

@section('title', __("Ads"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.exchange._submenu_exchange')

        <!--begin::Row-->
        <div class="row gy-0 mb-6 mb-xl-12">
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card card-md-stretch me-xl-3 mb-md-0 mb-6">
                    <!--begin::Body-->
                    <div class="card-body p-10 p-lg-15">
                        <!--begin::Header-->
                        <div class="d-flex flex-stack mb-7">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark">Popular Tickets</h1>
                            <!--end::Title-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Link-->
                                <a href="https://keenthemes.com/support" class="text-primary fw-bold me-1">Support</a>
                                <!--begin::Link-->
                                <!--begin::Arrow-->
                                <i class="ki-outline ki-arrow-right fs-2 text-primary"></i>
                                <!--end::Arrow-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Accordion-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_1">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">What admin theme does?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-block">React</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_1_1" class="collapse show fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_2">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How Extended Licese works?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-block">Laravel</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_1_2" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_3">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How to install on a local machine?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-block">VueJS</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_1_3" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_4">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How can I import Google fonts?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-block">Angular 9</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_1_4" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_5">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How long the license is valid?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-block">Bootstrap 5</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_1_5" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_6">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How many end projects I can build?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-block">PHP</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_1_6" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--end::Accordion-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card card-md-stretch ms-xl-3">
                    <!--begin::Body-->
                    <div class="card-body p-10 p-lg-15">
                        <!--begin::Header-->
                        <div class="d-flex flex-stack mb-7">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark">FAQ</h1>
                            <!--end::Title-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Link-->
                                <a href="https://keenthemes.com/faqs" class="text-primary fw-bold me-1">Full FAQ</a>
                                <!--begin::Link-->
                                <!--begin::Arrow-->
                                <i class="ki-outline ki-arrow-right fs-2 text-primary"></i>
                                <!--end::Arrow-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Accordion-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_1">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">What admin theme does?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">Bootstrap</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_2_1" class="collapse show fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="d-none"></a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_2">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How Extended Licese works?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">General</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_2_2" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="d-none"></a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_3">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How to install on a local machine?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">React</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_2_3" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="d-none"></a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_4">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How can I import Google fonts?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">Angular</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_2_4" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="d-none"></a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_5">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How long the license is valid?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">Webpack</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_2_5" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="d-none"></a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_6">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <i class="ki-outline ki-down toggle-on text-primary fs-2"></i>
                                    <i class="ki-outline ki-right toggle-off fs-2"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How many end projects I can build?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">Laravel</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_2_6" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="d-none"></a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--end::Accordion-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->


    </div>
    <!--end::Container-->
@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
{{--    {!! $dataTableHtml->scripts() !!}--}}
@endsection
