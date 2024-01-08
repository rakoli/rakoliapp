<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('exchange.role')}}" action="{{$submitUrl}}" method="post">

    @csrf

    @if($isEdit)
        <input type="hidden" name="exchange_id" value="{{$exchangeAd->id}}">
    @endif

    <!--begin::Aside column-->
    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

        @if($isEdit)
            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>{{__('Status')}}</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="rounded-circle
                        @if($exchangeAd->status == 'active')
                            bg-success
                        @elseif($exchangeAd->status == 'disabled')
                            bg-danger
                        @elseif($exchangeAd->status == 'deleted')
                            bg-gray-600
                        @elseif($exchangeAd->status == 'pending')
                            bg-warning
                        @endif
                        w-15px h-15px" id="#"></div>
                    </div>
                    <!--begin::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="{{__('Change Ad Status')}}" id="ad_status" name="ad_status">
                        @if(auth()->user()->type == \App\Utils\Enums\UserTypeEnum::ADMIN->value)
                            @foreach(\App\Utils\Enums\ExchangeStatusEnum::toArray() as $availableStatus)
                                <option value="{{$availableStatus}}"
                                        @if($exchangeAd->status == $availableStatus)
                                            selected
                                    @endif
                                >{{strtoupper($availableStatus)}}</option>
                            @endforeach
                        @elseif(in_array($exchangeAd->status, \App\Utils\Enums\ExchangeStatusEnum::userCantSeeArray()))
                            <option value="{{$exchangeAd->status}}" selected>{{strtoupper($exchangeAd->status)}}</option>
                        @else
                            @foreach(\App\Utils\Enums\ExchangeStatusEnum::userViewable() as $availableStatus)
                                <option value="{{$availableStatus}}"
                                    @if($exchangeAd->status == $availableStatus)
                                        selected
                                    @endif
                                >{{strtoupper($availableStatus)}}</option>
                            @endforeach
                        @endif
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">{{__('Change Ad Status')}}</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
        @endif

        <!--begin::Category & tags-->
        {{-- <div class="card card-flush py-4">
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
                        <option value="{{$branch->code}}"
                            @if($isEdit)
                                @if($exchangeAd->location_code == $branch->code)
                                    selected
                                @endif
                            @endif
                        >{{$branch->name}}</option>
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
                    <textarea class="form-control form-control-solid" id="availability_desc" name="availability_desc">@if($isEdit){{$exchangeAd->availability_desc}}@endif</textarea>
                    <!--end::Input-->
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
                                    @if($exchangeAd->region_code == $region->code)
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
                <!--End::Input group-->
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Town')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Town")}}" id="ad_town" name="ad_town" onchange="townChanged(this)">
                    @if($isEdit)
                        <option value="all">{{__('ALL')}}</option>
                        @if($exchangeAd->region_code != null)
                            @foreach($towns as $town)
                                <option value="{{$town->code}}"
                                    @if($exchangeAd->town_code == $town->code)
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
                        @if($exchangeAd->town_code != null)
                            @foreach($areas as $area)
                                <option value="{{$area->code}}"
                                        @if($exchangeAd->area_code == $area->code)
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
        </div> --}}
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
                    <input type="text" class="form-control mb-2" id="name" name="name" value="" placeholder="{{__("Enter Role Name")}}">

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
                <a href="{{route('exchange.posts')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a>
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
