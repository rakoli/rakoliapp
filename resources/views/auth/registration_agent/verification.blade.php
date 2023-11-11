<div class="current" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-10 pb-lg-10">
            <!--begin::Title-->
            <h2 class="fw-bold d-flex align-items-center text-dark">Contact Verification</h2>
            <!--end::Title-->
            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">Please take a moment to confirm the accuracy
                of your provided contact information</div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->
        <!--begin::Input group-->
        <div class="row mb-5">
            <div class="text-muted fw-semibold fs-6">Email: {{auth()->user()->email}}</div>
            <div class="input-group input-group-lg mb-5">
                <span class="input-group-text" id="basic-addon1">Email code</span>
                <input type="text" class="form-control" placeholder="Email Code"/>
                <button id="request_email_code" type="button" class="btn btn-secondary fw-bold flex-shrink-0 ml-5" onclick="requestEmailCode()">Request Code</button>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="row">
            <div class="text-muted fw-semibold fs-6">Phone: +{{auth()->user()->phone}}</div>
            <div class="input-group input-group-lg mb-5">
                <span class="input-group-text" id="basic-addon1">Phone code</span>
                <input type="text" class="form-control" placeholder="Phone Code"/>
                <button id="request_phone_code" type="button" class="btn btn-secondary fw-bold flex-shrink-0 ml-5" onclick="requestPhoneCode()">Request Code</button>
            </div>
        </div>
        <!--end::Input group-->

        <div class="mt-5">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_contact_modal">
                Edit Contact Information
            </button>
            <button type="button" class="btn btn-primary disabled">
                Verify Email
            </button>
            <button type="button" class="btn btn-primary disabled">
                Verify Phone
            </button>
        </div>


        <!--begin::Modal group-->
        <div class="modal fade" tabindex="-1" id="edit_contact_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Modal title</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal group-->

    </div>
    <!--end::Wrapper-->
</div>
