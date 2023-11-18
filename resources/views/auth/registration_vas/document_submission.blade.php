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
                        label="Tax Certificate No"
                    />

                    <x-input
                        id="tax_certificate_no"

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
                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">{{ __('Drop Tax Certificate here or click to upload') }}
                                    .</h3>

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

                        label="Registration Certificate No"
                    />
                    <!--end::Label-->

                    <!--begin::Input-->
                    <x-input id="registration_no"
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
                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">{{ __('Drop Registration Certificate here or click to upload') }}
                                    .</h3>

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
                    <x-select2 placeholder="Select an ID Card type">
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
                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">{{ __('Drop ID CARD here or click to upload.') }}</h3>

                        </div>
                        <!--end::Info-->
                    </div>
                </div>
                <!--end::Dropzone-->

            </div>
            <!--end::Input group-->
        <button id="verify_phone_button" type="button" class="btn btn-primary" onclick="uploadDocuments()">
            {{__('Upload Business Documents')}}
        </button>

    </div>
    <!--end::Wrapper-->


</div>

@push('js')
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        var myDropzone = new Dropzone("#tax_certificate_no_file", {
            url: "{{ route('registration.vas.uploads', ['user' => auth()->user()->code]) }}", // Set the url for your upload script location
            paramName: "tax_certificate_no_file", // The name that will be used to transfer the file
            maxFiles: 1,
            params: {
                _token: csrfToken
            },
            maxFilesize: 1, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        });
    </script>
@endpush
