<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('vas.tasks.index')}}" action="{{$submitUrl}}" method="post">
    @csrf
    @if($isEdit)
        @method('patch')
        <input type="hidden" name="task_id" value="{{$task->id}}">
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
                        @if($task->status == 'active')
                            bg-success
                        @elseif($task->status == 'disabled')
                            bg-danger
                        @elseif($task->status == 'deleted')
                            bg-gray-600
                        @elseif($task->status == 'pending')
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
                        @foreach(\App\Utils\Enums\VasTaskStatusEnum::userViewable() as $availableStatus)
                            <option value="{{$availableStatus}}"
                                @if($task->status == $availableStatus)
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
                <label class="form-label">{{__('Region')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Region")}}" id="region_code" name="region_code" onchange="regionChanged(this)">
                    @if($isEdit)
                        <option value="">{{__('ALL')}}</option>
                        @foreach($regions as $region)
                            <option value="{{$region->code}}"
                                    @if($task->region_code == $region->code)
                                        selected
                                    @endif
                            >{{$region->name}}</option>
                        @endforeach
                    @else
                        <option value="">{{__('ALL')}}</option>
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
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select a Town")}}" id="town_code" name="town_code" onchange="townChanged(this)">
                    @if($isEdit)
                        <option value="">{{__('ALL')}}</option>
                        @if($task->region_code != null)
                            @foreach($towns as $town)
                                <option value="{{$town->code}}"
                                    @if($task->town_code == $town->code)
                                            selected
                                    @endif
                                >{{$town->name}}</option>
                            @endforeach
                        @endif
                    @else
                        <option value="">{{__('ALL')}}</option>
                    @endif
                </select>
                <!--End::Input group-->
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">{{__('Area')}}</label>
                <!--end::Label-->
                <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select an Area")}}" id="area_code" name="area_code">
                    @if($isEdit)
                        <option value="">{{__('ALL')}}</option>
                        @if($task->town_code != null)
                            @foreach($areas as $area)
                                <option value="{{$area->code}}"
                                        @if($task->area_code == $area->code)
                                            selected
                                    @endif
                                >{{$area->name}}</option>
                            @endforeach
                        @endif
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
                    <h2>{{__("Task Detail")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__('Task Type')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select Task Type")}}" id="task_type" name="task_type">
                        <option></option>
                        @foreach(\App\Utils\Enums\TaskTypeEnum::toArray() as $type)
                            <option value="{{$type}}"
                                @if($task->task_type == $type)
                                    selected
                                @endif
                            >{{strtoupper($type)}}</option>
                        @endforeach
                    </select>
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
                        <input type="datetime-local" name="time_start" class="form-control" placeholder="{{__('Start Time')}}" value="@if($isEdit){{$task->time_start}}@endif" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row w-100 flex-md-root">
                        <!--begin::Label-->
                        <label class="form-label">{{__("End Time")}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="datetime-local" name="time_end" class="form-control" placeholder="{{__('End Time')}}" value="@if($isEdit){{$task->time_end	}}@endif" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__("Agents")}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" name="no_of_agents" class="form-control" placeholder="{{__('No of Agents')}}" value="@if($isEdit){{$task->no_of_agents	}}@endif" />
                    <!--end::Input-->
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-check form-check-inline">
                        <input type="hidden" name="is_public" value="1">
                        <input class="form-check-input" type="checkbox" name="is_public" value="0" onclick="privateTaskChanged()" @if($isEdit){{!$task->is_public ? 'checked' : ''}}@endif/>
                        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">{{ __("Click to Make it") }}
                                                <a href="#" class="ms-1 link-primary">{{ __("Private") }}</a></span>
                    </label>
                    <!--end::Label-->
                </div>
                <!--End::Input group-->

                <!--begin::Input group-->
                <div class="mb-5 fv-row" id="private_agents_list" style="display: @if($isEdit){{!$task->is_public ? 'block' : 'none'}} @else 'none' @endif">
                    <!--begin::Label-->
                    <label class="form-label">{{__('Task Agent')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-placeholder="{{__("Select Task Agent")}}" multiple="multiple"  id="private_agents" name="private_agents[]">
                    </select>
                    <!--end::Input-->
                </div>
                <!--End::Input group-->



                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__("Description")}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" id="description" name="description">@if($isEdit){{$task->description}}@endif</textarea>
                    <!--end::Input-->
                    <div class="text-muted fs-7">{{__('Maximum of 200 characters')}}</div>
                </div>
                <!--End::Input group-->

            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">

            <!--begin::Button-->
            <a href="{{route('vas.tasks.index')}}" class="btn btn-secondary me-5">{{__('Cancel')}}</a>
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
