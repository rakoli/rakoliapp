<div class="" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-10 pb-lg-12">
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">{{ __('Upload business verification document') }}</h2>
            <!--end::Title-->
            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">If you need more info, please check out
                <a href="#" class="link-primary fw-bold">Help Page</a>.
            </div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->

        <div class=" gap-4 d-flex">
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <x-label
                    for="tax_certificate_no"
                    label="TAX Identification"
                />

                <x-input
                    id="tax_certificate_no"
                    placeholder="{{ __('Enter TAX Identification') }}"
                    value="{{ auth()->user()->business?->tax_id }}"
                    name="tax_certificate_no"
                />

            </div>


            <!--begin::Input group-->
            <div class="fv-row w-300px">
                <!--begin::Dropzone-->
                <div class="dropzone" id="tax_certificate_no_file">
                    <!--begin::Message-->
                    <div class="dz-message needsclick">
                        <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                                class="path2"></span></i>

                        <!--begin::Info-->
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">{{ __('Drop Tax Certificate here or click to upload') }}</h3>

                        </div>
                        <!--end::Info-->
                    </div>
                </div>
                <!--end::Dropzone-->
            </div>
            <!--end::Input group-->
        </div>

        <div class="d-flex w-100  gap-4 mt-4">
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <x-label
                    for="registration_no"
                    label="Registration Identification"
                />
                <!--end::Label-->

                <!--begin::Input-->
                <x-input id="registration_no"
                         placeholder="{{ __('Enter Registrar Identification') }}"
                         value="{{ auth()->user()->business?->business_regno }}"
                         name="registration_no"/>
                <!--end::Input-->
            </div>


            <!--begin::Input group-->
            <div class="fv-row w-300px">
                <!--begin::Dropzone-->
                <div class="dropzone" id="registration_no_file">
                    <!--begin::Message-->
                    <div class="dz-message needsclick">
                        <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                                class="path2"></span></i>

                        <!--begin::Info-->
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">{{ __('Drop Registration Certificate here or click to upload') }}</h3>

                        </div>
                        <!--end::Info-->
                    </div>
                </div>
                <!--end::Dropzone-->
            </div>
            <!--end::Input group-->
        </div>

        <div class="d-flex gap-4 mt-4">
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <x-label
                    for="contact_person"
                    label="Name as it a appears on ID CARD"
                />
                <!--end::Label-->

                <!--begin::Input-->
                <x-input id="contact_person" name="contact_person" value="{{ auth()->user()->full_name }}"/>
                <!--end::Input-->
            </div>

            <div class="fv-row mb-10">
                <!--begin::Label-->
                <x-label
                    for="document_type"
                    label="ID Card Type"
                />
                <x-select2 id="nat_id" placeholder="Select an ID Card type">
                    <option></option>
                    @foreach(\App\Utils\Enums\IDCardType::cases() as $cardType)
                        <option value="{{ $cardType->value }}">{{ $cardType->label() }}</option>

                    @endforeach
                </x-select2>
            </div>
        </div>

        <!--begin::Input group-->
        <div class="d-flex gap-4 mb-10">
            <!--begin::Dropzone-->
            <div class="dropzone" id="id_front_path">
                <!--begin::Message-->
                <div class="dz-message needsclick">
                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                            class="path2"></span></i>

                    <!--begin::Info-->
                    <div class="ms-4">
                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">{{ __('Drop ID CARD here or click to upload') }}</h3>

                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Dropzone-->

        </div>



        <button id="verify_phone_button" type="button" class="btn btn-primary" onclick="updateBusinessUploadsDetails()">
            {{__('Update Business Details')}}
        </button>

    </div>
    <!--end::Wrapper-->


</div>

@push('js')
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // add tax
        const taxCertificate = new Dropzone("#tax_certificate_no_file", {
            url: "{{ route('registration.vas.uploads') }}", // Set the url for your upload script location
            paramName: "tax_certificate_no_file", // The name that will be used to transfer the file
            maxFiles: 1,
            params: {
                _token: csrfToken,
                column_name: "tax_id",
                document_name: "tax_certificate_no_file",
                document_type: "{{ \App\Utils\Enums\BusinessUploadDocumentTypeEnums::TAX_ID->value }}"
            },
            maxFilesize: 1, // MB

        });

        // Event handler for when a file is successfully uploaded


        taxCertificate.on("success", function (file, response) {
            document.getElementById("tax_certificate_no").setAttribute('disabled', true);
            document.getElementById("tax_certificate_no").classList.add("disabled");
            document.getElementById("tax_certificate_no").placeholder = "{{__('BUSINESS UPDATED')}}";
            toastr.success('File uploaded successfully', 'Success', { timeOut: 3000 });
        });

        // Event handler for when an error occurs during file upload
        taxCertificate.on("error", function (file, errorMessage) {
            console.error("Error uploading file", errorMessage);
            this.removeFile(file);
            toastr.error('Error uploading file: ' + errorMessage, 'Error', { timeOut: 3000 });
        });

        taxCertificate.on("addedfile", function (file) {
            var tax_certificate_no = document.getElementById('tax_certificate_no').value;


            if (!tax_certificate_no || tax_certificate_no.length === 0) {
                // If the fields are not filled, remove the file from the dropzone
                this.removeFile(file);
                toastr.warning('Please fill in to tax Certificate No to proceed uploading.', "{{__('Tax Certificate is required')}}");
            }
            else {
                taxCertificate.options.params.column_value = tax_certificate_no;

            }
        })



        // add registartion
        const registartionFile = new Dropzone("#registration_no_file", {
            url: "{{ route('registration.vas.uploads') }}", // Set the url for your upload script location
            paramName: "registration_no_file", // The name that will be used to transfer the file
            maxFiles: 1,
            params: {
                _token: csrfToken,
                document_name: "registration_no_file",
                column_name: "business_regno",
                document_type: "{{ \App\Utils\Enums\BusinessUploadDocumentTypeEnums::REGISTRATION->value }}"
            },
            maxFilesize: 1, // MB
        });

        // Event handler for when a file is successfully uploaded


        registartionFile.on("success", function (file, response) {
            document.getElementById("registration_no").setAttribute('disabled', true);
            document.getElementById("registration_no").classList.add("disabled");
            document.getElementById("registration_no").placeholder = "{{__('BUSINESS UPDATED')}}";

            toastr.success('File uploaded successfully', 'Success', { timeOut: 3000 });
        });

        // Event handler for when an error occurs during file upload
        registartionFile.on("error", function (file, errorMessage) {
            console.error("Error uploading file", errorMessage);
            this.removeFile(file);
            toastr.error('Error uploading file: ' + errorMessage, 'Error', { timeOut: 3000 });
        });

        registartionFile.on("addedfile", function (file) {
            var registration_no = document.getElementById('registration_no').value;


            if (!registration_no || registration_no.length === 0) {
                // If the fields are not filled, remove the file from the dropzone
                this.removeFile(file);
                toastr.warning('Please fill in to Registration Certificate No to proceed uploading.', "{{__('Business Registration Certificate is required')}}");
            }
            else{
                registartionFile.options.params.column_value = registration_no;

            }
        })

        // add  identification DOCUMENT
        var idUploads = new Dropzone("#id_front_path", {
            url: "{{ route('registration.vas.uploads') }}",
            paramName: "id_front_path",
            maxFiles: 1,
            params: {
                _token: csrfToken,
                document_name: "id_front_path",
                document_type: "{{ \App\Utils\Enums\BusinessUploadDocumentTypeEnums::NAT->value }}"
            },
            maxFilesize: 1,
        });


        idUploads.on("success", function (file, response) {
            document.getElementById("contact_person").setAttribute('disabled', true);
            document.getElementById("contact_person").classList.add("disabled");
            document.getElementById("contact_person").placeholder = "{{__('BUSINESS UPDATED')}}";
            document.getElementById("nat_id").setAttribute('disabled', true);
            document.getElementById("nat_id").classList.add("disabled");
            document.getElementById("nat_id").placeholder = "{{__('BUSINESS UPDATED')}}";
            toastr.success('File uploaded successfully', 'Success', { timeOut: 3000 });
        });

        // Event handler for when an error occurs during file upload
        idUploads.on("error", function (file, errorMessage) {
            console.error("Error uploading file", errorMessage);
            this.removeFile(file);
            toastr.error('Error uploading file: ' + errorMessage, 'Error', { timeOut: 3000 });
        });

        idUploads.on("addedfile", function (file) {
            var nameInput = document.getElementById('contact_person').value;
            var natIdSelect = $('#nat_id').select2().text;

            if (!nameInput || !natIdSelect || natIdSelect.length === 0) {
                // If the fields are not filled, remove the file from the dropzone
                this.removeFile(file);
                toastr.warning('Please fill in both name and select a nationality ID before uploading.', "{{__('document type and Name is required')}}");
            }
            else{

            }
        });

        function updateBusinessUploadsDetails(){
            var xhr = new XMLHttpRequest();

            // Configure the GET request
            var url = "{{ route('registration.vas.finish') }}";

            xhr.open("POST", url, true);

            xhr.setRequestHeader("Accept", "application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);

            // Set up a function to handle the response
            xhr.onload = function () {

                var responseData = JSON.parse(xhr.responseText);
                if (xhr.status === 200 && responseData.status === 200) {
                    toastr.success(responseData.message, "{{ __('Update Business Details') }}");

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
@endpush
