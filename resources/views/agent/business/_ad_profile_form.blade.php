<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('exchange.posts')}}" action="{{$submitUrl}}" method="post" enctype="multipart/form-data">

    @csrf

    @if($isEdit)
        <input type="hidden" name="business_id" value="{{$business->id}}">
    @endif

    <!--begin::Aside column-->
    <!--end::Aside column-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Pricing-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>{{__("Profile")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Name')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_name" name="business_name" value="{{$business->business_name }}" placeholder="{{__("Enter Business Name")}}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Tax Identification')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="tax_id" name="tax_id" value="{{$business->tax_id  }}" placeholder="{{__("Enter Tax Identification")}}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Registration number')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_regno" name="business_regno" value="{{$business->business_regno  }}" placeholder="{{__("Enter Registration number")}}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Registration Date')}}</label>
                    <!--begin::Input-->
                    {{-- <input type="date" class="form-control mb-2" id="business_reg_date" name="business_reg_date" value="{{$business->business_reg_date  }}" placeholder="{{__("Enter Registration Date")}}"> --}}
                    <input type="date" class="form-control mb-2" id="business_reg_date" name="business_reg_date" value="{{ \Carbon\Carbon::parse($business->business_reg_date)->format('Y-m-d') }}" placeholder="{{ __("Enter Registration Date") }}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Phone number')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_phone_number" name="business_phone_number" value="{{$business->business_phone_number   }}" placeholder="{{__("Enter Phone number")}}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Email')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_email" name="business_email" value="{{$business->business_email}}" placeholder="{{__("Enter Email")}}">

                </div>
                <div class="mb-5 fv-row b-logo">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Logo')}}</label>
                    <!--begin::Input-->
                    <input type="file" class="form-control mb-2" id="business_logo" name="business_logo" accept="image/*">
                    @if($business->business_logo)
                        <img src="{{ asset('storage/'.$business->business_logo) }}">
                    @endif
                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business location')}}</label>
                    <!--begin::Input-->
                    <textarea type="text" class="form-control mb-2" id="business_location " name="business_location " placeholder="{{__("Enter location")}}">{{$business->business_location  }}</textarea>
                </div>
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">

            <!--begin::Button-->
            {{-- @if(auth()->user()->type == \App\Utils\Enums\UserTypeEnum::ADMIN->value)
                <a href="{{route('admin.exchange.ads')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a>
            @else
                <a href="{{route('exchange.posts')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a>
            @endif --}}

            {{-- @if($isEdit && $exchangeAd->status != \App\Utils\Enums\ExchangeStatusEnum::DELETED->value)
                <!--begin::Button-->
                <button type="submit" id="adsubmit_button" class="btn btn-primary">
                    <span class="indicator-label">{{__('Submit')}}</span>
                    <span class="indicator-progress">{{__('Please wait...')}}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            @else --}}
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
