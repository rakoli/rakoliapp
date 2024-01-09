<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('business.branches')}}" action="{{$submitUrl}}" method="post">

    @csrf
    <!--begin::Aside column-->
    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

        @if($isEdit)
        <input type="hidden" name="branches_id" value="{{$branches->id}}">
       @endif
        @if($isEdit)

        @endif

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
                <!--end::Details toggle-->
                <div class="separator separator-dashed mt-3 mb-3"></div>
                <!--begin::Details content-->

                {{-- <div class="mb-5 text-gray-600 text-center">
                    {{__('Access Area')}}
                </div> --}}

                <!--begin::Input group-->
                <div class="mb-2 fv-row">

                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Region')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Region")}}" id="ad_region" name="ad_region" onchange="regionChanged(this)">
                    @if($isEdit)
                        <option value="all">{{__('ALL')}}</option>
                        @foreach($regions as $region)
                            <option value="{{$region->code}}"
                                    @if($branches->region_code == $region->code)
                                        selected
                                    @endif
                            >{{$region->name}}</option>
                        @endforeach
                    @else
                        <option value="all">{{__('ALL')}}</option>
                        @foreach($regions as $region)
                            <option value="{{$region->code}}">{{$region->name}}</option>
                        @endforeach
                    @endif

                </select>
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Town')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Town")}}" id="ad_town" name="ad_town" onchange="townChanged(this)">
                    @if($isEdit)
                        <option value="all">{{__('ALL')}}</option>
                        @if($branches->region_code != null)
                            @foreach($towns as $town)
                                <option value="{{$town->code}}"
                                    @if($branches->town_code == $town->code)
                                            selected
                                    @endif
                                >{{$town->name}}</option>
                            @endforeach
                        @endif
                    @else
                        <option value="all">{{__('ALL')}}</option>
                    @endif
                </select>
                <!--End::Input group-->
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Area')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select an Area")}}" id="ad_area" name="ad_area">
                    @if($isEdit)
                        <option value="all">{{__('ALL')}}</option>
                        @if($branches->town_code != null)
                            @foreach($areas as $area)
                                <option value="{{$area->code}}"
                                        @if($branches->area_code == $area->code)
                                            selected
                                    @endif
                                >{{$area->name}}</option>
                            @endforeach
                        @endif
                    @else
                        <option value="all">{{__('ALL')}}</option>
                    @endif
                </select>
                <!--End::Input group-->

            </div>
            <!--end::Card body-->
        </div>

    </div>
    <!--end::Aside column-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Pricing-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>{{__("Branches")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Name')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="name" name="name" value="@if($isEdit){{$branches->name}}@endif" placeholder="{{__("Enter Name")}}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Balance')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="balance" name="balance"value="@if($isEdit){{$branches->balance}}@endif" placeholder="{{__("Enter Balance")}}">

                </div>
                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Balance Currency ')}}</label>
                    <!--begin::Input-->
                    <input type="text" class="form-control mb-2" id="balance_currency " name="balance_currency" value="@if($isEdit){{$branches->balance_currency}}@endif" placeholder="{{__("Enter Balance Currency")}}">

                </div>
                <div class="mb-5 fv-row">
                    <label class="form-label">{{__("Availability Description")}}</label>
                    <textarea class="form-control form-control-solid" id="availability_desc" name="availability_desc">@if($isEdit){{$branches->description}}@endif</textarea>
                </div>

            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">

            <!--begin::Button-->
                <a href="{{route('business.branches')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a>
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
