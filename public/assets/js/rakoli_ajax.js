function submitForm(formId, url, redirect = null) {

    var formData = new FormData(formId[0])

    window.axios.post(url, formData)
        .then(response => {
            SwalAlert(
                "success",
                response.data.message
            );


            setTimeout(function () {
                window.location.reload()
            }, 1000);


        })
        .catch(error => {
            SwalAlert(
                "warning",
                error.response.data.message
            );
        })

}
