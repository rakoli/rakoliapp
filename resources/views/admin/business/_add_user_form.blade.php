<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('admin.business.users.sales')}}" action="{{$submitUrl}}" method="post">
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
                    <h2>{{__("Add Sales User")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Country')}}</label>
                    <!--begin::Input-->
                    <select id="countrySelect" class="form-control" name="country_code" required>
                        <option value="">{{ __("Your Country") }}</option>
                        @foreach(\App\Models\Country::all() as $country)
                            <option value="{{$country->code}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Code')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_code" name="business_code" value="{{@$business->code }}" placeholder="{{__("Enter Business Code")}}" required>
                </div>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Name')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_name" name="business_name" value="{{@$business->business_name }}" placeholder="{{__("Enter Business Name")}}" required>

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Tax Identification')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="tax_id" name="tax_id" value="{{@$business->tax_id  }}" placeholder="{{__("Enter Tax Identification")}}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Registration number')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_regno" name="business_regno" value="{{@$business->business_regno  }}" placeholder="{{__("Enter Registration number")}}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business Registration Date')}}</label>
                    <!--begin::Input-->
                    {{-- <input type="date" class="form-control mb-2" id="business_reg_date" name="business_reg_date" value="{{@$business->business_reg_date  }}" placeholder="{{__("Enter Registration Date")}}"> --}}
                    <input type="date" class="form-control mb-2" id="business_reg_date" name="business_reg_date" value="{{ \Carbon\Carbon::parse(@$business->business_reg_date)->format('Y-m-d') }}" placeholder="{{ __("Enter Registration Date") }}">

                </div>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('First Name')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="fname" name="fname" value="{{@$business->business_name }}" placeholder="{{__("Enter Business Name")}}" required>

                </div>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Last Name')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="lname" name="lname" value="{{@$business->business_name }}" placeholder="{{__("Enter Business Name")}}" required>

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Phone number')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_phone_number" name="business_phone_number" value="{{@$business->business_phone_number   }}" placeholder="{{__("Enter Phone number")}}" required>

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Email')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="business_email" name="business_email" value="{{@$business->business_email   }}" placeholder="{{__("Enter Email")}}" required email>

                </div>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Password')}}</label>
                    <!--begin::Input-->
                    <input class="form-control" type="password" placeholder="{{ __("Password") }}" name="password" autocomplete="off"  required/>

                </div>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Confirm Password')}}</label>
                    <!--begin::Input-->
                    <input placeholder="{{ __("Confirm Password") }}" name="password_confirmation" type="password" autocomplete="off" class="form-control"  required/>

                </div>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Business location')}}</label>
                    <!--begin::Input-->
                    <textarea type="text" class="form-control mb-2" id="business_location" name="business_location" placeholder="{{__("Enter location")}}"  required>{{@$business->business_location  }}</textarea>
                </div>
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">
            <button type="submit" id="adsubmit_button" class="btn btn-primary">
                <span class="indicator-label">{{__('Submit')}}</span>
                <span class="indicator-progress">{{__('Please wait...')}}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
    <!--end::Main column-->
</form>
<!--end::Form-->
