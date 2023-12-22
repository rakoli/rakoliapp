<script>
    function regionChanged(regionElement) {
        removeAllOptions('ad_town');
        updateTownList(regionElement.value, 'ad_town');
        removeAllOptions('ad_area');
    }

    function townChanged(townElement) {
        removeAllOptions('ad_area');
        updateAreaList(townElement.value, 'ad_area');
    }


    function updateTownList(regionCode, townlistElementId){

        console.log("UPDATE TOWN LIST");

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        @if(auth()->user()->type == \App\Utils\Enums\UserTypeEnum::ADMIN->value)
            var url = "{{route('admin.exchange.post.townlistAjax')}}";
        @else
            var url = "{{route('exchange.post.townlistAjax')}}";
        @endif
        url = url + "?region_code="+regionCode;
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                // console.log(responseData.data);
                const regionList = responseData.data;
                regionList.forEach(function(region) {
                    addOption(townlistElementId,region.name,region.code);
                });
            } else {
                // Request encountered an error
                console.error("Request failed with data:", responseData);
            }
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            console.error("Network error occurred");
        };

        // Sending data with the request
        xhr.send();
    }

    function updateAreaList(townCode, arealistElementId){

        console.log("UPDATE AREA LIST");

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        @if(auth()->user()->type == \App\Utils\Enums\UserTypeEnum::ADMIN->value)
            var url = "{{route('admin.exchange.post.arealistAjax')}}";
        @else
            var url = "{{route('exchange.post.arealistAjax')}}";
        @endif
        url = url + "?town_code="+townCode;
        xhr.open("GET", url, true);

        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Set up a function to handle the response
        xhr.onload = function () {

            var responseData = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && responseData.status === 200) {
                // Request was successful, handle the response here
                console.log(responseData.data);
                const areaList = responseData.data;
                areaList.forEach(function(area) {
                    addOption(arealistElementId,area.name,area.code);
                });
            } else {
                // Request encountered an error
                console.error("Request failed with data:", responseData);
            }
        };

        // Set up a function to handle errors
        xhr.onerror = function () {
            console.error("Network error occurred");
        };

        // Sending data with the request
        xhr.send();
    }


    function removeAllOptions(selectElementId) {
        var select = document.getElementById(selectElementId);
        while (select.options.length > 0) {
            select.remove(0);
        }
    }

    function addOption(selectorId, optionText, optionValue) {
        var select = document.getElementById(selectorId);
        var option = document.createElement("option");

        option.text = optionText;
        option.value = optionValue;

        select.add(option);
    }
</script>
