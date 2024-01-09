<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('business.role')}}" action="{{$submitUrl}}" method="post">

    @csrf

    @if($isEdit)
        <input type="hidden" name="role_id" value="{{$role->id}}">
    @endif

    <!--begin::Aside column-->
    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

        @if($isEdit)
            <!--begin::Status-->

            <!--end::Status-->
        @endif
    </div>
    <!--end::Aside column-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Pricing-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>{{__("Role Detail")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Role Name')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="name" name="name" value="@if($isEdit){{$role->name}}@endif" placeholder="{{__("Enter Role Name")}}">

                </div>
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">

            <!--begin::Button-->
            {{-- @if(auth()->user()->type == \App\Utils\Enums\UserTypeEnum::ADMIN->value) --}}
                {{-- <a href="{{route('admin.exchange.ads')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a> --}}
            {{-- @else --}}
                <a href="{{route('business.role')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a>
            {{-- @endif --}}

            {{-- @if($isEdit && $exchangeAd->status != \App\Utils\Enums\ExchangeStatusEnum::DELETED->value) --}}
                <!--begin::Button-->
                {{-- <button type="submit" id="adsubmit_button" class="btn btn-primary">
                    <span class="indicator-label">{{__('Submit')}}</span>
                    <span class="indicator-progress">{{__('Please wait...')}}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button> --}}
                <!--end::Button-->
            {{-- @else --}}
                <!--begin::Button-->
                <button type="submit" id="adsubmit_button" class="btn btn-primary">
                    <span class="indicator-label">{{__('Submit')}}</span>
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
