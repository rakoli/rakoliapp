@extends('layouts.users.vas')

@section('title', __("Contract Detail"))

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

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

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bold">{{__("Submission Details")}}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">{{__("Attachment")}}</div>
                        <div class="text-gray-600">{{$submission->attachment}}</div>
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">{{__("Description")}}</div>
                        <div class="text-gray-600">{{$submission->description}}</div>
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">{{__("Status")}}</div>
                        <div class="text-gray-600">{{$submission->status}}</div>
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">{{__("Note")}}</div>
                        <div class="text-gray-600">{{$submission->note}}</div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->

        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->
@endsection

@section('footer_js')
@endsection
