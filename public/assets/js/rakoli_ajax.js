function submitForm(formId, url, method = 'post') {

    var formData = new FormData(formId[0])

    var request =  window.axios;

    if (method === 'delete')
    {
        request = request.delete(url, formData)
    }
    else
    {
        request = request.post(url, formData)
    }


        request.then(response => {

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
