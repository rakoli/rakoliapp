<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{ route('business.users') }}"
    action="{{ $submitUrl }}" method="post">

    @csrf
    <!--begin::Aside column-->
    {{-- <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10"> --}}

        @if ($isEdit)
        <input type="hidden" name="users_id" value="{{$users->id}}">
       @endif
        @if ($isEdit)

        @endif

    {{-- </div> --}}
    <!--end::Aside column-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Pricing-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>{{$formTitle}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">


                <div class="d-flex flex-wrap gap-5 mb-5">
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{ __('First name') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control mb-2" id="name" name="fname"
                            value="@if($isEdit){{ $users->fname }}@endif"
                            placeholder="{{ __('Enter Name') }}">
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{ __('Last name') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control mb-2" id="name" name="lname"
                            value="@if($isEdit){{ $users->lname }}@endif"
                            placeholder="{{ __('Enter Name') }}">
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="d-flex flex-wrap gap-5 mb-5">
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{ __('Email') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="email" class="form-control mb-2" id="email" name="email"
                            value="@if($isEdit){{ $users->email }}@endif"
                            placeholder="{{ __('Enter Email') }}">
                        <!--end::Input-->
                    </div>

                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{ __('Phone') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="tel" class="form-control mb-2" id="phone" name="phone"
                            value="@if($isEdit){{ $users->phone }}@endif"
                            placeholder="{{ __('Enter Phone Number') }}">
                        <!--end::Input-->
                    </div>

                    <!--end::Input group-->
                </div>

                <div class="d-flex flex-wrap gap-5 mb-5">
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{ __('Password') }}</label>
                        <!--end::Label-->
                        <input type="password" class="form-control mb-2" id="password" name="password"
                            placeholder="{{ __('Enter Password') }}" value="">
                        <!--end::Input-->
                    </div>

                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <label class="form-label">{{ __('Branches') }}</label>
                        <!--begin::Input-->
                        <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select Sell branches")}}" id="branches" name="branches[]" data-allow-clear="true" multiple="multiple" data-close-on-select="false">
                            <option></option>
                            @foreach($branches as $branche)
                            <option value="{{ $branche->code }}" @if ($isEdit && $locationdata->pluck('location_code')->contains($branche->code)) selected @endif>{{ $branche->name }}</option>
                            {{-- <option value="{{$branche->code}}" @if ($isEdit && $branche->code == $locationdata->location_code) selected @endif>{{ $branche->name }}>{{$branche->name}}</option> --}}
                            @endforeach
                        </select>
                    </div>

                    <!--end::Input group-->
                </div>

                <div class="d-flex flex-wrap gap-5 mb-5">
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                            <!--end::Label-->
                            <label class="form-label">{{ __('Roles') }}</label>
                            <!--begin::Input-->
                            <select class="form-control mb-2" id="roles" name="roles">
                                <option value="" selected disabled>{{ __('Select roles') }}</option>
                                @foreach ($businessRole as $role)
                                    <option value="{{ $role->code }}" @if ($isEdit && $role->business_code) selected @endif>{{ $role->name }}</option>
                                    {{-- <option value="{{ $branche->code }}" @if ($isEdit && $locationdata->pluck('location_code')->contains($branche->code)) selected @endif>{{ $branche->name }}</option> --}}
                                    @endforeach
                            </select>

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">

                    </div>

                    <!--end::Input group-->
                </div>


            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">

            <!--begin::Button-->
            <a href="{{ route('business.users') }}" class="btn btn-secondary me-5">{{ __('Cancel') }}</a>
            <!--begin::Button-->
            <button type="submit" id="adsubmit_button" class="btn btn-primary">
                <span class="indicator-label">{{ __('Submit') }}</span>
                <span class="indicator-progress">{{ __('Please wait...') }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
        </div>
    </div>
    <!--end::Main column-->
</form>
<!--end::Form-->
