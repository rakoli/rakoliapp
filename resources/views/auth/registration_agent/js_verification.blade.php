<script>
    function requestEmailCode() {
        console.log("REQUESTED EMAIL CODE");
        var request_emailcode_button = document.getElementById("request_emailcode_button");
        request_emailcode_button.classList.add("disabled")

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        xhr.open("GET", "{{route('request.email.code')}}", true);

        xhr.setRequestHeader("Accept", "application/json");

        // Set up a function to handle the response
        xhr.onload = function () {
            var verify_button = document.getElementById("verify_email_button");

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log("Response Data:", responseData);
                toastr.success(responseData.message, "{{__('Send Email Verification')}}");

                if(responseData.message === 'Email already verified'){
                    document.getElementById("email_code").placeholder = "{{__('EMAIL ALREADY VERIFIED')}}";
                    document.getElementById("email_code").setAttribute('disabled', true);
                }else{
                    verify_button.classList.remove("disabled");
                    emailCodeTimer({{\App\Utils\VerifyOTP::$validtime}});
                }

            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "{{__('Send Email Verification')}}");
            }
            request_emailcode_button.classList.remove("disabled");
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Send the GET request
        xhr.send();
    }

    let emailTimerOn = true;
    function emailCodeTimer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('email_timer').innerHTML = "{{__('Time remaining')}}: "+ m + ":" + s;
        remaining -= 1;

        if(remaining >= 0 && emailTimerOn) {
            setTimeout(function() {
                emailCodeTimer(remaining);
            }, 1000);
            return;
        }

        // Do timeout stuff here
        console.log('EMAIL TIMEOUT STAFF:')
        document.getElementById("verify_email_button").classList.add("disabled")
        document.getElementById("request_emailcode_button").classList.remove("disabled")

    }

    function verifyEmailCode() {
        console.log("VERIFYING EMAIL CODE");
        var inputEmailCode = document.getElementById('email_code').value;
        var verify_button = document.getElementById("verify_email_button");
        verify_button.classList.add("disabled")

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        var url = "{{route('verify.email.code')}}";
        url = url + "?email_code="+inputEmailCode;
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log("Response Data:", responseData);
                toastr.success(responseData.message, "{{__('Verify Email Code')}}");
                document.getElementById("request_emailcode_button").classList.add("disabled");
                document.getElementById("email_code").value = "";
                document.getElementById("email_code").placeholder = "{{__('EMAIL VERIFIED')}}";
                document.getElementById("email_code").classList.add("disabled");
                document.getElementById("email_code").setAttribute('disabled', true);

            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "{{__('Verify Email Code')}}");
            }
            verify_button.classList.remove("disabled");
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Sending data with the request
        xhr.send();
    }

    function requestPhoneCode() {
        console.log("REQUESTED PHONE CODE");
        var request_phonecode_button = document.getElementById("request_phonecode_button");
        request_phonecode_button.classList.add("disabled")

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        xhr.open("GET", "{{route('request.phone.code')}}", true);

        xhr.setRequestHeader("Accept", "application/json");

        // Set up a function to handle the response
        xhr.onload = function () {
            var verify_button = document.getElementById("verify_phone_button");

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log("Response Data:", responseData);
                toastr.success(responseData.message, "{{__('Send Phone Verification')}}");
                if(responseData.message === 'Phone already verified'){
                    document.getElementById("phone_code").placeholder = "{{__('PHONE ALREADY VERIFIED')}}";
                    document.getElementById("phone_code").setAttribute('disabled', true);
                }else{
                    verify_button.classList.remove("disabled");
                    phoneCodeTimer({{\App\Utils\VerifyOTP::$validtime}});
                }

            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "{{__('Send Phone Verification')}}");
            }

            request_phonecode_button.classList.remove("disabled");
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Send the GET request
        xhr.send();
    }

    let phoneTimerOn = true;
    function phoneCodeTimer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('phone_timer').innerHTML = "{{__('Time remaining')}}: "+ m + ":" + s;
        remaining -= 1;

        if(remaining >= 0 && phoneTimerOn) {
            setTimeout(function() {
                phoneCodeTimer(remaining);
            }, 1000);
            return;
        }

        // Do timeout stuff here
        console.log('PHONE TIMEOUT STAFF:')
        document.getElementById("verify_phone_button").classList.add("disabled")
        document.getElementById("request_phonecode_button").classList.remove("disabled")

    }

    function verifyPhoneCode() {
        console.log("VERIFYING PHONE CODE");
        var inputPhoneCode = document.getElementById('phone_code').value;
        var verify_button = document.getElementById("verify_phone_button");
        verify_button.classList.add("disabled")

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        var url = "{{route('verify.phone.code')}}";
        url = url + "?phone_code="+inputPhoneCode;
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                toastr.success(responseData.message, "{{__('Verify Phone Code')}}");
                document.getElementById("request_phonecode_button").classList.add("disabled");
                document.getElementById("phone_code").value = "";
                document.getElementById("phone_code").placeholder = "{{__('PHONE VERIFIED')}}";
                document.getElementById("phone_code").classList.add("disabled");
                document.getElementById("phone_code").setAttribute('disabled', true);
            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "{{__('Verify Phone Code')}}");
            }
            verify_button.classList.remove("disabled");
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            toastr.error("Network Error Occurred");
            console.error("Network error occurred");
        };

        // Sending data with the request
        xhr.send();
    }

</script>
