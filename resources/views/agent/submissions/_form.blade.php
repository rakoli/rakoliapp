<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('vas.contracts.index')}}" action="{{$submitUrl}}" method="post">

    @csrf

    @if($isEdit)
        @method('patch')
        <input type="hidden" name="task_id" value="{{$contract->id}}">
    @endif


    <!--begin::Sidebar-->
    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
        <!--begin::Card-->
        <div class="card mb-5 mb-xl-8">
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <!--begin::Details content-->
                <div class="collapse show">
                    <div class="py-5 fs-6">

                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">{{__("Business")}}</div>
                        <div class="text-gray-600">{{$contract->business->business_name}}</div>
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">{{__("Agent")}}</div>
                        <div class="text-gray-600">{{$contract->agent->business_name}}</div>
                        <div class="fw-bold mt-5">{{__("Title")}}</div>
                        <div class="text-gray-600">{{$contract->title}}</div>
                        <div class="fw-bold mt-5">{{__("Task Code")}}</div>
                        <div class="text-gray-600">{{$contract->vas_task_code}}</div>
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">{{__("Duration")}}</div>
                        <div class="text-gray-600">
                            <div class="text-gray-600">
                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $contract->time_start)->format('d.m.Y h:i a') }}
                                @if(!empty($contract->time_end))
                                    To {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $contract->time_end)->format('d.m.Y h:i a') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Details content-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Sidebar-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Pricing-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>{{__("Contract Submission")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Input group-->
                <div class="fv-row w-300px">
                    <!--begin::Dropzone-->
                    <div class="dropzone" id="attachment">
                        <!--begin::Message-->
                        <div class="dz-message needsclick">
                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                                    class="path2"></span></i>

                            <!--begin::Info-->
                            <div class="ms-4">
                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">{{ __('Drop Attachment here or click to upload') }}</h3>

                            </div>
                            <!--end::Info-->
                        </div>
                    </div>
                    <!--end::Dropzone-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="form-label">{{__('Description')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" id="description" name="description">@if($isEdit){{$task->description}}@endif</textarea>
                    <!--end::Input-->
                    <div class="text-muted fs-7">{{__('Maximum of 200 characters')}}</div>
                    <!--end::Input-->
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
