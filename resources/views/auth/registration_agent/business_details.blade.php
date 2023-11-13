<div class="" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-10 pb-lg-10">
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">Business Information</h2>
            <!--end::Title-->
            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">Complete your business registration</div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->
        <!--begin::Input group-->
        <div class="mb-5 fv-row">
            <label for="business_name" class="required form-label">Business Name</label>
            <input type="text" name="business_name" id="business_name" class="form-control form-control-solid @if(auth()->user()->business_code != null) disabled @endif" placeholder="@if(auth()->user()->business_code != null) {{__('BUSINESS UPDATE COMPLETE')}} @else {{__('Enter Business Name')}} @endif"/>
        </div>
        <!--end::Input group-->
        <!--begin::Notice-->
        <div class="text-muted fw-semibold fs-6 mb-5">Below are optional fields you can complete later</div>
        <!--end::Notice-->
        <!--begin::Input group-->
        <div class="mb-10 fv-row">
            <label for="reg_id" class="form-label">Registration Identification</label>
            <input type="text" name="reg_id" id="reg_id" class="form-control form-control-solid @if(auth()->user()->business_code != null) disabled @endif" placeholder="@if(auth()->user()->business_code != null) {{__('BUSINESS UPDATE COMPLETE')}} @else {{__('Enter Registrar Identification')}} @endif"/>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="mb-10 fv-row">
            <label for="tax_id" class="form-label">TAX Identification</label>
            <input type="text" name="tax_id" id="tax_id" class="form-control form-control-solid @if(auth()->user()->business_code != null) disabled @endif" placeholder="@if(auth()->user()->business_code != null) {{__('BUSINESS UPDATE COMPLETE')}} @else {{__('Enter TAX Identification')}} @endif"/>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="mb-10 fv-row" id="regdate_picker" data-td-target-input="nearest" data-td-target-toggle="nearest">
            <label for="tax_id" class="form-label">Business Registration Date</label>
            <div class="input-group">
                <input id="regdate_picker_input" type="text" class="form-control form-control-solid @if(auth()->user()->business_code != null) disabled @endif"
                       data-td-target="#regdate_picker" data-td-toggle="datetimepicker" placeholder="@if(auth()->user()->business_code != null) {{__('BUSINESS UPDATE COMPLETE')}} @else {{__('Select Business Registration Date')}} @endif"/>
                <span class="input-group-text" data-td-target="#regdate_picker" data-td-toggle="datetimepicker">
                <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
            </span>
            </div>
        </div>
        <!--end::Input group-->

        <button id="verify_phone_button" type="button" class="btn btn-primary" onclick="updateBusinessDetails()">
            {{__('Update Business Details')}}
        </button>
    </div>
    <!--end::Wrapper-->
</div>
