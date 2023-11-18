<script>

    "use strict";

    var KTCreateAccount = function() {

        var options = {startIndex: {{$step}} };

        var modalElement = document.querySelector("#kt_modal_create_account");
        var stepperElement = document.querySelector("#kt_create_account_stepper");
        var formElement = stepperElement.querySelector("#kt_create_account_form");
        var submitButton = stepperElement.querySelector('[data-kt-stepper-action="submit"]');
        var nextButton = stepperElement.querySelector('[data-kt-stepper-action="next"]');
        var stepper = new KTStepper(stepperElement, options);

        return {
            init: function() {
                if (modalElement) {
                    new bootstrap.Modal(modalElement);
                }

                if (stepperElement) {
                    stepper.on("kt.stepper.changed", function(e) {
                        if (stepper.getCurrentStepIndex() === 4) {
                            submitButton.classList.remove("d-none");
                            submitButton.classList.add("d-inline-block");
                            nextButton.classList.add("d-none");
                        } else if (stepper.getCurrentStepIndex() === 5) {
                            submitButton.classList.add("d-none");
                            nextButton.classList.add("d-none");
                        } else {
                            submitButton.classList.remove("d-inline-block");
                            submitButton.classList.remove("d-none");
                            nextButton.classList.remove("d-none");
                        }
                    });

                    stepper.on("kt.stepper.next", function(e) {

                        moveToStep(stepper)

                    });

                    stepper.on("kt.stepper.previous", function(e) {
                        stepper.goPrevious();
                        KTUtil.scrollTop();
                    });
                }
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTCreateAccount.init();

        @if(\App\Utils\VerifyOTP::hasActiveEmailOTP(auth()->user()))
        emailCodeTimer({{\App\Utils\VerifyOTP::emailOTPTimeRemaining(auth()->user())}})
        @endif

        @if(\App\Utils\VerifyOTP::hasActivePhoneOTP(auth()->user()))
        phoneCodeTimer({{\App\Utils\VerifyOTP::phoneOTPTimeRemaining(auth()->user())}})
        @endif

    });

    //START:: STEP MOVEMENT CONFIRMATION
    function moveToStep(stepperInstance) {
        console.log("CONFIRM STEP MOVEMENT");

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        var url = "{{route('registration.step.confirmation')}}";
        url = url + "?next_step="+stepperInstance.getNextStepIndex();
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log("Response Data:", responseData);
                stepperInstance.goNext();
                KTUtil.scrollTop();
                toastr.success(responseData.message, "{{__('Registration Step')}}");
            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "{{__('Registration Step')}}");
            }

        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Send the GET request
        xhr.send();
    }

    function moveToComplete() {
        console.log("COMPLETE REGISTRATION");

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        var url = "{{route('registration.step.confirmation')}}";
        url = url + "?next_step="+5;
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log("Response Data:", responseData);

                window.location.reload();
            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "{{__('Registration Step')}}");
            }

        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Send the GET request
        xhr.send();
    }
    //END:: STEP MOVEMENT CONFIRMATION

</script>
