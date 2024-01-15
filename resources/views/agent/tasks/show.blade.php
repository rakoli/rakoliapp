@extends('layouts.users.agent')

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

                        <!--begin::Form-->
                        <form class="form" data-kt-redirect-url="{{route('agent.task.show',array($task->id))}}" action="{{route('agent.task.apply')}}" method="post" id="kt_form">
                            <input type="hidden" name="task_id" value="{{$task->id}}">
                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <div class="col-md-3 text-md-end">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        {{__("Comment")}}
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control form-control-solid" id="comment" name="comment"></textarea>
                                </div>
                            </div>
                            <!--end::Input group-->



                            <!--begin::Action buttons-->
                            <div class="row py-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <!--begin::Button-->
                                        <a href="{{route('agent.tasks')}}" class="btn btn-light me-3">{{__("Cancel")}}</a>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-primary" id="kt_submit">
                                            <span class="indicator-label">{{__("Apply")}}</span>
                                            <span class="indicator-progress">{{__("Please wait...")}}
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Action buttons-->
                        </form>
                        <!--end::Form-->


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
    <script>
        "use strict";

        // Class definition
        var KTFormGeneral = function () {
            // Elements
            var form;
            var submitButton;
            var validator;

            // Handle form validation
            var handleValidation = function (e) {
                // Init form validation rules. For more info check the FormValidation plugin's official documentation: https://formvalidation.io/
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'action_select': {
                                validators: {
                                    notEmpty: {
                                        message: 'The Action is required'
                                    }
                                }
                            },
                            'action_method_select': {
                                validators: {
                                    notEmpty: {
                                        message: 'The Action Payment Method is required'
                                    }
                                }
                            },
                            'action_for_select': {
                                validators: {
                                    notEmpty: {
                                        message: 'The Action For is required'
                                    }
                                }
                            },
                            'amount': {
                                validators: {
                                    min: 10000,
                                    max: 40000,
                                    message: 'The Amount is required'
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',  // comment to enable invalid state icons
                                eleValidClass: '' // comment to enable valid state icons
                            })
                        }
                    }
                );
            }

            // Handle form submission via AJAX
            var handleSubmitAjax = function (e) {
                // Handle form submit
                submitButton.addEventListener('click', function (e) {
                    // Prevent button default action
                    e.preventDefault();

                    // Validate form
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple clicks
                            submitButton.disabled = true;

                            // Check axios library docs: https://axios-http.com/docs/intro
                            axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {

                                if (response) {

                                    if(response.data.success == true){
                                        form.reset();
                                        Swal.fire({
                                            text: "Applied",
                                            icon: "success",
                                        });
                                    }else Swal.fire({
                                        text: response.data.resultExplanation,
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    })
                                } else Swal.fire({
                                    text: "Sorry, errors trying to submit, please try again or contact support",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })


                            }).catch(function (error) {
                                // Show error message
                                Swal.fire({
                                    text: "Error! " + error.response.data.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }).then(() => {
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                            });
                        } else {
                            // Show validation error message
                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                });
            }

            // Function to check if a string is a valid URL
            var isValidUrl = function (url) {
                try {
                    new URL(url);
                    return true;
                } catch (e) {
                    return false;
                }
            }

            // Public functions
            return {
                // Initialization
                init: function () {
                    // Get form and submit button elements
                    form = document.querySelector('#kt_form');
                    submitButton = document.querySelector('#kt_submit');

                    // Get help block element
                    document.querySelector('.fv-help-block');

                    // Initialize form validation
                    handleValidation();

                    // Handle form submission via AJAX
                    handleSubmitAjax();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTFormGeneral.init();
        });

    </script>
@endsection
