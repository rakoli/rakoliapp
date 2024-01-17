@extends('layouts.users.vas')

@section('title', __("Task Detail"))

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
                                <div class="text-gray-600">{{$task->business->business_name}}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Duration")}}</div>
                                <div class="text-gray-600">
                                    <div class="text-gray-600">
                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $task->time_start)->format('d.m.Y h:i a') }}
                                        @if(!empty($task->time_end))
                                         To {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $task->time_end)->format('d.m.Y h:i a') }}
                                        @endif
                                    </div>
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Address")}}</div>
                                <div class="text-gray-600">
                                    @if(!empty($task->region_code))
                                        Region:{{$task->region->name}}
                                    @endif
                                    @if(!empty($task->town_code))
                                        | Town:{{$task->town->name}}
                                    @endif
                                    @if(!empty($task->area_code))
                                        | Area:{{$task->area->name}}
                                    @endif
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__('Task Type')}}</div>
                                <div class="text-gray-600">
                                    {!! $task->task_type !!}
                                </div>
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Status")}}</div>
                                <div class="text-gray-600">{{$task->status}}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Note")}}</div>
                                <div class="text-gray-600">{{$task->note}}</div>
                                <!--begin::Details item-->
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
                            <h2 class="fw-bold">{{__("Task")}}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="fs-6 fw-normal mb-10">{{$task->description}}</div>
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
