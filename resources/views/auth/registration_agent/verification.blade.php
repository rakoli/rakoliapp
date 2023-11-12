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
                <input @if(auth()->user()->email_verified_at != null) readonly @endif id="email_code" type="number" class="form-control" placeholder="@if(auth()->user()->email_verified_at != null) EMAIL ALREADY VERIFIED @else EMAIL CODE @endif"/>
                <button id="request_emailcode_button" type="button" class="btn btn-secondary fw-bold flex-shrink-0 ml-5 @if(auth()->user()->email_verified_at != null) disabled @endif" onclick="requestEmailCode()">Request Code</button>
            </div>
            <div id="email_timer" class="text-muted fw-semibold fs-6"></div>


        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="row">
            <div class="text-muted fw-semibold fs-6">Phone: +{{auth()->user()->phone}}</div>
            <div class="input-group input-group-lg mb-5">
                <span class="input-group-text" id="basic-addon1">Phone code</span>
                <input @if(auth()->user()->phone_verified_at != null) readonly @endif id="phone_code" type="number" class="form-control" placeholder="@if(auth()->user()->phone_verified_at != null) PHONE ALREADY VERIFIED @else PHONE CODE @endif"/>
                <button id="request_phonecode_button" type="button" class="btn btn-secondary fw-bold flex-shrink-0 ml-5 @if(auth()->user()->phone_verified_at != null) disabled @endif" onclick="requestPhoneCode()">Request Code</button>
            </div>
            <div id="phone_timer" class="text-muted fw-semibold fs-6"></div>
        </div>
        <!--end::Input group-->

        <div class="mt-5">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_contact_modal">
                Edit Contact Information
            </button>
            <button id="verify_email_button" type="button" class="btn btn-primary
            @if(!\App\Utils\VerifyOTP::hasActiveEmailOTP(auth()->user()))
            disabled
            @endif
            " onclick="verifyEmailCode()">
                Verify Email
            </button>
            <button id="verify_phone_button" type="button" class="btn btn-primary
            @if(!\App\Utils\VerifyOTP::hasActivePhoneOTP(auth()->user()))
            disabled
            @endif
            " onclick="verifyPhoneCode()">
                Verify Phone
            </button>
        </div>

    </div>
    <!--end::Wrapper-->
</div>
