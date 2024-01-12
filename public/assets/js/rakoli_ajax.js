function submitForm(formId, url, redirect = null) {

    var formData = new FormData(formId[0])

    window.axios.post(url, formData)
        .then(response => {
            SwalAlert(
                "success",
                response.data.message
            );




        })
        .catch(error => {
            SwalAlert(
                "warning",
                error.response.data.message
            );
        })

}
