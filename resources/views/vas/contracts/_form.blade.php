<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('vas.contracts.index')}}" action="{{$submitUrl}}" method="post">

    @csrf

    @if($isEdit)
        @method('patch')
        <input type="hidden" name="task_id" value="{{$contract->id}}">
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
                        @if($contract->status == 'active')
                            bg-success
                        @elseif($contract->status == 'disabled')
                            bg-danger
                        @elseif($contract->status == 'deleted')
                            bg-gray-600
                        @elseif($contract->status == 'pending')
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
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="{{__('Select Statusss')}}" id="status" name="status">
                        @foreach(\App\Utils\Enums\VascontractstatusEnum::userViewable() as $availableStatus)
                            <option value="{{$availableStatus}}"
                                @if($contract->status == $availableStatus)
                                    selected
                                @endif
                            >{{strtoupper($availableStatus)}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">{{__('Change Task Status')}}</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
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
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Vas Tasks')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Region")}}" id="region_code" name="region_code" onchange="regionChanged(this)">
                    @if($isEdit)
                        <option value="">{{__('ALL')}}</option>
                        @foreach($vas_tasks as $vas_task)
                            <option value="{{$vas_task->code}}"
                                    @if($contract->vas_task_code == $vas_task->code)
                                        selected
                                    @endif
                            >{{$vas_task->name}}</option>
                        @endforeach
                    @else
                        <option value="">{{__('ALL')}}</option>
                        @foreach($vas_tasks as $vas_task)
                            <option value="{{$vas_task->code}}">{{$vas_task->name}}</option>
                        @endforeach
                    @endif

                </select>
                <!--End::Input group-->
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Applied Agent')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Town")}}" id="town_code" name="town_code" onchange="townChanged(this)">
                    @if($isEdit)
                        <option value="">{{__('ALL')}}</option>
                        @foreach($agents as $agent)
                            <option value="{{$agent->business_code}}"
                                @if(in_array($agent->business_code,[]))
                                    selected
                                @endif
                            >{{strtoupper($agent->fname)}} {{ strtoupper($agent->lname)}}</option>
                        @endforeach
                    @else
                        <option value="">{{__('ALL')}}</option>
                    @endif
                </select>
                <!--End::Input group-->
            </div>
            <!--end::Card body-->
        </div>
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
                    <h2>{{__("Contract Detail")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__('Title')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="title" class="form-control" placeholder="{{__('Title')}}" value="@if($isEdit){{$contract->title	}}@endif" />
                    <!--end::Input-->
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="d-flex flex-wrap gap-5 mb-5">
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{__("Start Time")}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="datetime-local" name="time_start" class="form-control" placeholder="{{__('Start Time')}}" value="@if($isEdit){{$contract->time_start}}@endif" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{__("End Time")}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="datetime-local" name="time_end" class="form-control" placeholder="{{__('End Time')}}" value="@if($isEdit){{$contract->time_end	}}@endif" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--End::Input group-->
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">

            <!--begin::Button-->
            <a href="{{route('vas.contracts.index')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a>
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
