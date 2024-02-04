@extends('layouts.users.agent')

@section('title', "Transactions")

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::STATISTICS program-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Body-->
            <div class="card-body py-10">
                <!--begin::Stats-->
                <div class="row">
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-info pb-1 px-2">Net Earnings</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">$
												<span data-kt-countup="true" data-kt-countup-value="63,240.00">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-success pb-1 px-2">Balance</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">$
												<span data-kt-countup="true" data-kt-countup-value="8,530.00">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-danger pb-1 px-2">Avg Deal Size</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">$
												<span data-kt-countup="true" data-kt-countup-value="2,600">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-primary pb-1 px-2">Referral Signups</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">$
												<span data-kt-countup="true" data-kt-countup-value="783&quot;">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::STATISTICS program-->

        <!--begin::Order details page-->
        <div class="d-flex flex-column gap-7 gap-lg-10">
            <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#page1">Page Summary</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#page2">Page Form</a>
                    </li>
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs-->
            </div>
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="page1" role="tab-panel">
                    <!--begin::View-->
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::View Content-->
                        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Order #14534</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                        <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-175px">Product</th>
                                            <th class="min-w-100px text-end">SKU</th>
                                            <th class="min-w-70px text-end">Qty</th>
                                            <th class="min-w-100px text-end">Unit Price</th>
                                            <th class="min-w-100px text-end">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->
                                                    <a href="../../demo6/dist/apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                        <span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/1.png);"></span>
                                                    </a>
                                                    <!--end::Thumbnail-->
                                                    <!--begin::Title-->
                                                    <div class="ms-5">
                                                        <a href="../../demo6/dist/apps/ecommerce/catalog/edit-product.html" class="fw-bold text-gray-600 text-hover-primary">Product 1</a>
                                                        <div class="fs-7 text-muted">Delivery Date: 19/07/2023</div>
                                                    </div>
                                                    <!--end::Title-->
                                                </div>
                                            </td>
                                            <td class="text-end">02652001</td>
                                            <td class="text-end">2</td>
                                            <td class="text-end">$120.00</td>
                                            <td class="text-end">$240.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->
                                                    <a href="../../demo6/dist/apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                        <span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/100.png);"></span>
                                                    </a>
                                                    <!--end::Thumbnail-->
                                                    <!--begin::Title-->
                                                    <div class="ms-5">
                                                        <a href="../../demo6/dist/apps/ecommerce/catalog/edit-product.html" class="fw-bold text-gray-600 text-hover-primary">Footwear</a>
                                                        <div class="fs-7 text-muted">Delivery Date: 19/07/2023</div>
                                                    </div>
                                                    <!--end::Title-->
                                                </div>
                                            </td>
                                            <td class="text-end">01863004</td>
                                            <td class="text-end">1</td>
                                            <td class="text-end">$24.00</td>
                                            <td class="text-end">$24.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Subtotal</td>
                                            <td class="text-end">$264.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">VAT (0%)</td>
                                            <td class="text-end">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Shipping Rate</td>
                                            <td class="text-end">$5.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="fs-3 text-dark text-end">Grand Total</td>
                                            <td class="text-dark fs-3 fw-bolder text-end">$269.00</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::View Content-->
                    </div>
                    <!--end::Orders-->
                </div>
                <!--end::Tab pane-->
                <!--begin::Tab pane-->
                <div class="tab-pane fade" id="page2" role="tab-panel">
                    <!--begin::View-->
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::View content-->
                        <div class="card card-flush py-4 flex-row-fluid">
                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <!--begin::Form-->
                                <form id="kt_modal_create_api_key_form" class="form" action="#">
                                    <!--begin::Modal body-->
                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Scroll-->
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_create_api_key_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_create_api_key_header" data-kt-scroll-wrappers="#kt_modal_create_api_key_scroll" data-kt-scroll-offset="300px">
                                            <!--begin::Notice-->
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
                                                <!--begin::Icon-->
                                                <i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1">
                                                    <!--begin::Content-->
                                                    <div class="fw-semibold">
                                                        <h4 class="text-gray-900 fw-bold">Please Note!</h4>
                                                        <div class="fs-6 text-gray-700">Adding new API key may afftect to your
                                                            <a href="#">Affiliate Income</a></div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Notice-->
                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-semibold mb-2">API Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid" placeholder="Your API Name" name="name" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-semibold mb-2">Short Description</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea class="form-control form-control-solid" rows="3" name="description" placeholder="Describe your API"></textarea>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-semibold mb-2">Category</label>
                                                <!--end::Label-->
                                                <!--begin::Select-->
                                                <select name="category" data-control="select2" data-hide-search="true" data-placeholder="Select a Category..." class="form-select form-select-solid">
                                                    <option value="">Select a Category...</option>
                                                    <option value="1">CRM</option>
                                                    <option value="2">Project Alice</option>
                                                    <option value="3">Keenthemes</option>
                                                    <option value="4">General</option>
                                                </select>
                                                <!--end::Select-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Heading-->
                                                <div class="mb-3">
                                                    <!--begin::Label-->
                                                    <label class="d-flex align-items-center fs-5 fw-semibold">
                                                        <span class="required">Specify Your API Method</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Your billing numbers will be calculated based on your API method">
												<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
											</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Description-->
                                                    <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Row-->
                                                <div class="fv-row">
                                                    <!--begin::Radio group-->
                                                    <div class="btn-group w-100" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                                                        <!--begin::Radio-->
                                                        <label class="btn btn-outline btn-active-success btn-color-muted" data-kt-button="true">
                                                            <!--begin::Input-->
                                                            <input class="btn-check" type="radio" name="method" value="1" />
                                                            <!--end::Input-->
                                                            Open API</label>
                                                        <!--end::Radio-->
                                                        <!--begin::Radio-->
                                                        <label class="btn btn-outline btn-active-success btn-color-muted active" data-kt-button="true">
                                                            <!--begin::Input-->
                                                            <input class="btn-check" type="radio" name="method" checked="checked" value="2" />
                                                            <!--end::Input-->
                                                            SQL Call</label>
                                                        <!--end::Radio-->
                                                        <!--begin::Radio-->
                                                        <label class="btn btn-outline btn-active-success btn-color-muted" data-kt-button="true">
                                                            <!--begin::Input-->
                                                            <input class="btn-check" type="radio" name="method" value="3" />
                                                            <!--end::Input-->
                                                            UI/UX</label>
                                                        <!--end::Radio-->
                                                        <!--begin::Radio-->
                                                        <label class="btn btn-outline btn-active-success btn-color-muted" data-kt-button="true">
                                                            <!--begin::Input-->
                                                            <input class="btn-check" type="radio" name="method" value="4" />
                                                            <!--end::Input-->
                                                            Docs</label>
                                                        <!--end::Radio-->
                                                    </div>
                                                    <!--end::Radio group-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Scroll-->
                                    </div>
                                    <!--end::Modal body-->
                                    <!--begin::Modal footer-->
                                    <div class="modal-footer flex-center">
                                        <!--begin::Button-->
                                        <button type="reset" id="kt_modal_create_api_key_cancel" class="btn btn-light me-3">Discard</button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                    <!--end::Modal footer-->
                                </form>
                                <!--end::Form-->

                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::View content-->
                    </div>
                    <!--end::View-->
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
        </div>
        <!--end::Order details page-->

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
{{--    {!! $dataTableHtml->scripts() !!}--}}
@endsection
