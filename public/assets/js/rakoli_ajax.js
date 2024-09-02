var submitFormAction = function submitForm(form, url, submitButton, redirect_url, method = 'post') {

    var formData = new FormData(form)

    var request = window.axios;

    if (method === 'delete') {
        request = request.delete(url, formData)
    } else {
        request = request.post(url, formData)
    }


    request.then(response => {

        submitButton.removeAttribute('data-kt-indicator');

        // Enable button
        submitButton.disabled = false;

        SwalAlert(
            "success",
            response.data.message
        );


        setTimeout(function () {
            location.href = redirect_url;
        }, 1000);


    })
        .catch(error => {
            submitButton.removeAttribute('data-kt-indicator');

            // Enable button
            submitButton.disabled = false;
            var error_msg = "Something went wrong, please try again.";
            var error_html = "";
            if ('error' in error.response.data){
                error_msg = error.response.data.error.message;
                $.each(error.response.data.error.fields, function(i,msg){
                    error_html = error_html + msg + "<br>";
                });
            } else if('message' in error.response.data) {
                error_msg = error.response.data.message;
            }

            SwalAlert(
                "warning",
                error_msg,
                error_html
            );
        })
        .finally(() => {
            submitButton.removeAttribute('data-kt-indicator');

            // Enable button
            submitButton.disabled = false;
        })


}


function lakoriValidation(validation, form, submitButton, formMethod, url, redirect_url= "",trigger_btn=false) {

    var validationsArray = [];

    validation.forEach((field_name, index) => {
        var name = field_name.name;
        var customValidators = field_name.validators;
        var validationObject = {};
        let validators;
        validationObject[name] = {
            validators: {
                customValidators,
                notEmpty: {
                    message: field_name.error
                }
            }
        };
        validationsArray.push(validationObject);
    });

    const validationsObject = Object.assign({}, ...validationsArray);

    var validator = window.FormValidation.formValidation(
        form,
        {
            fields: validationsObject,

            plugins: {
                trigger: new window.FormValidation.plugins.Trigger(),
                bootstrap: new window.FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }).on('plugins.message.displayed', function(e) {
            const messages = [].slice.call(form.querySelectorAll('[data-field="' + e.field + '"][data-validator]'));
            messages.forEach((messageEle,i) => {
                const validator = messageEle.getAttribute('data-validator');
                if(i > 0){
                    messageEle.style.display = 'none';
                }
            }); 
        });

    if(trigger_btn){
        if (validator) {

            validator.validate().then(function (status) {

                if (status === 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    submitFormAction(
                        form,
                        url,
                        submitButton,
                        redirect_url
                    );

                }
            });
        }
    } else {
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();
            // Validate form before submit
            if (validator) {
    
                validator.validate().then(function (status) {
    
                    if (status === 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');
    
                        // Disable button to avoid multiple click
                        submitButton.disabled = true;
    
                        submitFormAction(
                            form,
                            url,
                            submitButton,
                            redirect_url
                        );
    
                    }
                });
            }
        });
    }
}
