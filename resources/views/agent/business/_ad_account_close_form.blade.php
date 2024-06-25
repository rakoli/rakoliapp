<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('exchange.posts')}}" action="{{$submitUrl}}" method="post">

    @csrf
    <!--begin::Aside column-->
    <!--end::Aside column-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Pricing-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>{{__("Close Account")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <p>Once you delete your account, there is no going back. Please be certain.</p>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Password')}}</label>
                    <!--begin::Input-->
                    <input type="password" class="form-control mb-2" id="password" name="password" placeholder="{{__("Enter Password")}}" required>

                </div>
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">
            <!--begin::Button-->
            <button type="submit" id="adsubmit_button" class="btn btn-primary">
                <span class="indicator-label">{{__('Confirm')}}</span>
                <span class="indicator-progress">{{__('Please wait...')}}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            {{-- @endif --}}
        </div>
    </div>
    <!--end::Main column-->
</form>
<!--end::Form-->
