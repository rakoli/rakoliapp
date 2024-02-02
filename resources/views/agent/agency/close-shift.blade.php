@extends('layouts.users.agent')

@section('title', "Close Shift")

@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Agency</small>
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Close Shift</small>
    <!--end::Description-->
@endsection

@section('content')

    <div class="d-flex flex-column flex-lg-row px-lg-6">

        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
            <!--begin::Card-->
            <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary"
                 data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}"
                 data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false"
                 data-kt-sticky-zindex="95">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Summary</h2>
                    </div>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::More options-->
                        <a href="#" class="btn btn-sm btn-light btn-icon" data-kt-menu-trigger="click"
                           data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-dots-square fs-3"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span><span class="path4"></span></i> </a>
                        <!--begin::Menu-->
                        <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-6 w-200px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Pause Subscription
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-subscriptions-view-action="delete">
                                    Edit Subscription
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link text-danger px-3" data-kt-subscriptions-view-action="edit">
                                    Cancel Subscription
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        <!--end::More options-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0 fs-6">

                    @include('agent.agency.shift.close-shift')

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Sidebar-->


        <!--begin::Content-->
        <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">

            <div class="card card-flush pt-3 mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Recent Events</h2>
                    </div>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-light-primary">View All Events</a>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table wrapper-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-5"
                               id="kt_table_customers_events">
                            <tbody>
                            <tr>
                                <td class="min-w-400px">
                                    <a href="#" class="fw-bold text-gray-800 text-hover-primary me-1">Emma Smith</a> has
                                    made payment to <a href="#" class="fw-bold text-gray-800 text-hover-primary">4614-8680</a>
                                </td>
                                <td class="pe-0 text-gray-600 text-end min-w-200px">
                                    21 Feb 2024, 10:10 pm
                                </td>
                            </tr>
                            <tr>
                                <td class="min-w-400px">
                                    Invoice <a href="#"
                                               class="fw-bold text-gray-800 text-hover-primary me-1">6912-9503</a>
                                    status has changed from <span
                                        class="badge badge-light-primary me-1">In Transit</span> to <span
                                        class="badge badge-light-success">Approved</span>
                                </td>
                                <td class="pe-0 text-gray-600 text-end min-w-200px">
                                    20 Jun 2024, 2:40 pm
                                </td>
                            </tr>
                            <tr>
                                <td class="min-w-400px">
                                    Invoice <a href="#"
                                               class="fw-bold text-gray-800 text-hover-primary me-1">6004-8122</a>
                                    status has changed from <span class="badge badge-light-warning me-1">Pending</span>
                                    to <span class="badge badge-light-info">In Progress</span>
                                </td>
                                <td class="pe-0 text-gray-600 text-end min-w-200px">
                                    21 Feb 2024, 8:43 pm
                                </td>
                            </tr>
                            <tr>
                                <td class="min-w-400px">
                                    <a href="#" class="fw-bold text-gray-800 text-hover-primary me-1">Emma Smith</a> has
                                    made payment to <a href="#" class="fw-bold text-gray-800 text-hover-primary">4614-8680</a>
                                </td>
                                <td class="pe-0 text-gray-600 text-end min-w-200px">
                                    20 Jun 2024, 11:05 am
                                </td>
                            </tr>
                            <tr>
                                <td class="min-w-400px">
                                    <a href="#" class="fw-bold text-gray-800 text-hover-primary me-1">Sean Bean</a> has
                                    made payment to <a href="#" class="fw-bold text-gray-800 text-hover-primary">7942-1982</a>
                                </td>
                                <td class="pe-0 text-gray-600 text-end min-w-200px">
                                    25 Oct 2024, 11:30 am
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table wrapper-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->


            <!--begin::Card-->
            <div class="card card-flush pt-3 mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Invoices</h2>
                    </div>
                    <!--end::Card title-->

                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Tab nav-->
                        <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs nav-line-tabs-2x border-transparent"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <a id="kt_referrals_year_tab" class="nav-link text-active-primary active"
                                   data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_1"
                                   aria-selected="true">
                                    This Year
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a id="kt_referrals_2019_tab" class="nav-link text-active-primary ms-3"
                                   data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_2"
                                   aria-selected="false" tabindex="-1">
                                    2020
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a id="kt_referrals_2018_tab" class="nav-link text-active-primary ms-3"
                                   data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_3"
                                   aria-selected="false" tabindex="-1">
                                    2019
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a id="kt_referrals_2017_tab" class="nav-link text-active-primary ms-3"
                                   data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_4"
                                   aria-selected="false" tabindex="-1">
                                    2018
                                </a>
                            </li>
                        </ul>
                        <!--end::Tab nav-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-2">
                    <!--begin::Tab Content-->
                    <div id="kt_referred_users_tab_content" class="tab-content">
                        <!--begin::Tab panel-->
                        <div id="kt_customer_details_invoices_1" class="tab-pane fade show active" role="tabpanel"
                             aria-labelledby="kt_referrals_year_tab">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="kt_customer_details_invoices_table_1"
                                       class="table align-middle table-row-dashed fs-6 fw-bold gs-0 gy-4 p-0 m-0">
                                    <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                    <tr class="text-start text-gray-500">
                                        <th class="min-w-100px">Order ID</th>
                                        <th class="min-w-100px">Amount</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-125px">Date</th>
                                        <th class="w-100px">Invoice</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">102445788</a></td>
                                        <td class="text-success">$38.00</td>
                                        <td><span class="badge badge-light-danger">Rejected</span></td>
                                        <td>Nov 01, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">423445721</a></td>
                                        <td class="text-danger">$-2.60</td>
                                        <td><span class="badge badge-light-info">In progress</span></td>
                                        <td>Oct 24, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">312445984</a></td>
                                        <td class="text-success">$76.00</td>
                                        <td><span class="badge badge-light-danger">Rejected</span></td>
                                        <td>Oct 08, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">312445984</a></td>
                                        <td class="text-success">$5.00</td>
                                        <td><span class="badge badge-light-danger">Rejected</span></td>
                                        <td>Sep 15, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">523445943</a></td>
                                        <td class="text-danger">$-1.30</td>
                                        <td><span class="badge badge-light-success">Approved</span></td>
                                        <td>May 30, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_customer_details_invoices_2" class="tab-pane fade " role="tabpanel"
                             aria-labelledby="kt_referrals_2019_tab">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="kt_customer_details_invoices_table_2"
                                       class="table align-middle table-row-dashed fs-6 fw-bold gs-0 gy-4 p-0 m-0">
                                    <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                    <tr class="text-start text-gray-500">
                                        <th class="min-w-100px">Order ID</th>
                                        <th class="min-w-100px">Amount</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-125px">Date</th>
                                        <th class="w-100px">Invoice</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">523445943</a></td>
                                        <td class="text-danger">$-1.30</td>
                                        <td><span class="badge badge-light-info">In progress</span></td>
                                        <td>May 30, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">231445943</a></td>
                                        <td class="text-success">$204.00</td>
                                        <td><span class="badge badge-light-warning">Pending</span></td>
                                        <td>Apr 22, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">426445943</a></td>
                                        <td class="text-success">$31.00</td>
                                        <td><span class="badge badge-light-info">In progress</span></td>
                                        <td>Feb 09, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">984445943</a></td>
                                        <td class="text-success">$52.00</td>
                                        <td><span class="badge badge-light-warning">Pending</span></td>
                                        <td>Nov 01, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">324442313</a></td>
                                        <td class="text-danger">$-0.80</td>
                                        <td><span class="badge badge-light-danger">Rejected</span></td>
                                        <td>Jan 04, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_customer_details_invoices_3" class="tab-pane fade " role="tabpanel"
                             aria-labelledby="kt_referrals_2018_tab">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="kt_customer_details_invoices_table_3"
                                       class="table align-middle table-row-dashed fs-6 fw-bold gs-0 gy-4 p-0 m-0">
                                    <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                    <tr class="text-start text-gray-500">
                                        <th class="min-w-100px">Order ID</th>
                                        <th class="min-w-100px">Amount</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-125px">Date</th>
                                        <th class="w-100px">Invoice</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">426445943</a></td>
                                        <td class="text-success">$31.00</td>
                                        <td><span class="badge badge-light-danger">Rejected</span></td>
                                        <td>Feb 09, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">984445943</a></td>
                                        <td class="text-success">$52.00</td>
                                        <td><span class="badge badge-light-success">Approved</span></td>
                                        <td>Nov 01, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">324442313</a></td>
                                        <td class="text-danger">$-0.80</td>
                                        <td><span class="badge badge-light-success">Approved</span></td>
                                        <td>Jan 04, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">312445984</a></td>
                                        <td class="text-success">$5.00</td>
                                        <td><span class="badge badge-light-info">In progress</span></td>
                                        <td>Sep 15, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">102445788</a></td>
                                        <td class="text-success">$38.00</td>
                                        <td><span class="badge badge-light-info">In progress</span></td>
                                        <td>Nov 01, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_customer_details_invoices_4" class="tab-pane fade " role="tabpanel"
                             aria-labelledby="kt_referrals_2017_tab">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="kt_customer_details_invoices_table_4"
                                       class="table align-middle table-row-dashed fs-6 fw-bold gs-0 gy-4 p-0 m-0">
                                    <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                    <tr class="text-start text-gray-500">
                                        <th class="min-w-100px">Order ID</th>
                                        <th class="min-w-100px">Amount</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-125px">Date</th>
                                        <th class="w-100px">Invoice</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">102445788</a></td>
                                        <td class="text-success">$38.00</td>
                                        <td><span class="badge badge-light-danger">Rejected</span></td>
                                        <td>Nov 01, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">423445721</a></td>
                                        <td class="text-danger">$-2.60</td>
                                        <td><span class="badge badge-light-info">In progress</span></td>
                                        <td>Oct 24, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">102445788</a></td>
                                        <td class="text-success">$38.00</td>
                                        <td><span class="badge badge-light-danger">Rejected</span></td>
                                        <td>Nov 01, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">423445721</a></td>
                                        <td class="text-danger">$-2.60</td>
                                        <td><span class="badge badge-light-success">Approved</span></td>
                                        <td>Oct 24, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="text-gray-600 text-hover-primary">426445943</a></td>
                                        <td class="text-success">$31.00</td>
                                        <td><span class="badge badge-light-danger">Rejected</span></td>
                                        <td>Feb 09, 2020</td>
                                        <td class="">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Tab panel-->
                    </div>
                    <!--end::Tab Content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content-->






    </div>




    @push('js')


    @endpush

@endsection



