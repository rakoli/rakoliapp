<script>

    new tempusDominus.TempusDominus(document.getElementById("regdate_picker"), {
        display: {
            viewMode: "calendar",
            components: {
                decades: true,
                year: true,
                month: true,
                date: true,
                hours: false,
                minutes: false,
                seconds: false
            }
        }
    });

    function updateBusinessDetails() {
        console.log("UPDATE BUSINESS DETAILS");

        var business_name = document.getElementById('business_name').value;
        var reg_id = document.getElementById('reg_id').value;
        var tax_id = document.getElementById('tax_id').value;
        var regdate_picker_input = document.getElementById('regdate_picker_input').value;

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        var url = "{{route('update.business.details')}}";
        url = url + "?business_name="+business_name +"&reg_id="+reg_id+"&tax_id="+tax_id+"&reg_date="+regdate_picker_input;
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                document.getElementById("business_name").placeholder = "{{__('BUSINESS UPDATED')}}";
                document.getElementById("business_name").classList.add("disabled");
                document.getElementById("business_name").setAttribute('disabled', true);
                document.getElementById("reg_id").placeholder = "{{__('BUSINESS UPDATED')}}";
                document.getElementById("reg_id").setAttribute('disabled', true);
                document.getElementById("reg_id").classList.add("disabled");
                document.getElementById("tax_id").placeholder = "{{__('BUSINESS UPDATED')}}";
                document.getElementById("tax_id").setAttribute('disabled', true);
                document.getElementById("tax_id").classList.add("disabled");
                document.getElementById("regdate_picker_input").placeholder = "{{__('BUSINESS UPDATED')}}";
                document.getElementById("regdate_picker_input").setAttribute('disabled', true);
                document.getElementById("regdate_picker_input").classList.add("disabled");
                toastr.success(responseData.message, "{{__('Update Business Details')}}");

            } else {
                // Request encountered an error
                // console.error("Request failed with status:", responseData);
                toastr.error(responseData.message, "{{__('Update Business Details')}}");
            }

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
