<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('exchange.posts')}}" action="{{$submitUrl}}" method="post">

    @csrf

    <!--begin::Aside column-->
    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">


        <!--begin::Status-->
        <div class="card card-flush py-4 d-none">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>Status</h2>
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
                </div>
                <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Select2-->
                <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select">
                    <option></option>
                    <option value="published" selected="selected">Published</option>
                    <option value="draft">Draft</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="inactive">Inactive</option>
                </select>
                <!--end::Select2-->
                <!--begin::Description-->
                <div class="text-muted fs-7">Set the advertisement status.</div>
                <!--end::Description-->
                <!--begin::Datepicker-->
                <div class="d-none mt-10">
                    <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select publishing date and time</label>
                    <input class="form-control" id="kt_ecommerce_add_product_status_datepicker" placeholder="Pick date & time" />
                </div>
                <!--end::Datepicker-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Status-->

        <!--begin::Category & tags-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>{{__("Location Details")}}</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Business Branch')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a branch")}}" id="ad_branch" name="ad_branch">
                    <option></option>
                    @foreach($branches as $branch)
                        <option value="{{$branch->code}}">{{$branch->name}}</option>
                    @endforeach
                </select>
                <!--End::Input group-->

                <!--end::Details toggle-->
                <div class="separator separator-dashed mt-3 mb-3"></div>
                <!--begin::Details content-->

                <div class="mb-5 text-gray-600 text-center">
                    {{__('Access Area')}}
                </div>

                <!--begin::Input group-->
                <div class="mb-2 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__("Availability Description")}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" id="availability_desc" name="availability_desc"></textarea>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Region')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Region")}}" id="ad_region" name="ad_region" onchange="regionChanged(this)">
                    <option value="all">{{__('ALL')}}</option>
                    @foreach($regions as $region)
                        <option value="{{$region->code}}">{{$region->name}}</option>
                    @endforeach
                </select>
                <!--End::Input group-->
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Town')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Town")}}" id="ad_town" name="ad_town" onchange="townChanged(this)">
                    <option value="all">{{__('ALL')}}</option>
                </select>
                <!--End::Input group-->
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Area')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select an Area")}}" id="ad_area" name="ad_area">
                    <option value="all">{{__('ALL')}}</option>
                </select>
                <!--End::Input group-->

            </div>
            <!--end::Card body-->
        </div>
        <!--end::Category & tags-->
    </div>
    <!--end::Aside column-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Pricing-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>{{__("Ads Detail")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__('Buy (Receive)')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select Buy Methods")}}" id="ad_buy" name="ad_buy[]" data-allow-clear="true" multiple="multiple" data-close-on-select="false">
                        <option></option>
                        @foreach($businessExchangeMethods as $businessExchangeMethod)
                            <option value="{{$businessExchangeMethod->id}}">{{$businessExchangeMethod->nickname}}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__('Sell (Give)')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select Sell Methods")}}" id="ad_sell" name="ad_sell[]" data-allow-clear="true" multiple="multiple" data-close-on-select="false">
                        <option></option>
                        @foreach($businessExchangeMethods as $businessExchangeMethod)
                            <option value="{{$businessExchangeMethod->id}}">{{$businessExchangeMethod->nickname}}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="d-flex flex-wrap gap-5 mb-5">
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{__("Min Amount")}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" name="amount_min" class="form-control" placeholder="{{__('Minimum trade amount')}}" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{__("Max Amount")}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" name="amount_max" class="form-control" placeholder="{{__('Maximum trade amount')}}" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__("Description")}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" id="description" name="description"></textarea>
                    <!--end::Input-->
                    <div class="text-muted fs-7">{{__('Maximum of 200 characters')}}</div>
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__("Terms")}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" id="terms" name="terms"></textarea>
                    <!--end::Input-->
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__("Opening Note")}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" id="open_note" name="open_note"></textarea>
                    <!--end::Input-->
                </div>
                <!--End::Input group-->

            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">
            <!--begin::Button-->
            <a href="{{route('exchange.posts')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="submit" id="adsubmit_button" class="btn btn-primary">
                <span class="indicator-label">{{__('Submit')}}</span>
                <span class="indicator-progress">{{__('Please wait...')}}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
        </div>
    </div>
    <!--end::Main column-->
</form>
<!--end::Form-->
