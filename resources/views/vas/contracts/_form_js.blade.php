<script>
    function regionChanged(regionElement) {
        removeAllOptions('town_code');
        updateTownList(regionElement.value, 'town_code');
        removeAllOptions('area_code');
    }

    function townChanged(townElement) {
        removeAllOptions('area_code');
        updateAreaList(townElement.value, 'area_code');
    }

    function privateTaskChanged() {
        var ele = document.getElementById('private_agents_list');
        if (ele.style.display === "none") {
            ele.style.display = "block";
        } else {
            ele.style.display = "none";
        }

    }



    function updateTownList(regionCode, townlistElementId){

        console.log("UPDATE TOWN LIST");

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the GET request
        var url = "{{route('get.towns')}}";
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
        var url = "{{route('get.areas')}}";
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
