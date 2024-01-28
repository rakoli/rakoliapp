@extends('layouts.users.agent')

@section('title', __("Create Contract Submission"))

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.submissions._submenu')

        @include('agent.submissions._form', ['submitUrl'=>route('contracts.submissions.store',array($contract->id)),'isEdit'=>false])

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
<script>
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var idUploads = new Dropzone("#attachment", {
            url: "{{ route('contracts.submissions.upload',array($contract->id)) }}", // Set the url for your upload script location
            paramName: "submission_attachment", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 1,
            params: {
                _token: csrfToken,
                attachment: "submission_attachment",
            },
        });


        idUploads.on("success", function (file, response) {
            toastr.success('File uploaded successfully', 'Success', { timeOut: 3000 });
        });

        // Event handler for when an error occurs during file upload
        idUploads.on("error", function (file, errorMessage) {
            console.error("Error uploading file", errorMessage);
            this.removeFile(file);
            toastr.error('Error uploading file: ' + errorMessage, 'Error', { timeOut: 3000 });
        });

        idUploads.on("addedfile", function (file) {
            console.log(file);
        });
</script>
@endsection
