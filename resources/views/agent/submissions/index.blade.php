@extends('layouts.users.agent')

@section('title', __("Tasks"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.submissions._submenu')

        <!--begin::Table-->
        <div class="card card-flush mt-6 mt-xl-9">

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table container-->
                <div class="table-responsive">

                    {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4'],true) !!}

                </div>
                <!--end::Table container-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->


    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    <script>
        function deleteClicked(trnId){
            console.log(trnId);
            Swal.fire({
                // title: 'Your Title',
                text: '{{__('You cannot reverse this action')}}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{__('Ok')}}',
                cancelButtonText: '{{__('Cancel')}}',
                allowOutsideClick: false,
                showCloseButton: true,
                customClass: {
                    cancelButton: 'btn btn-danger',
                    confirmButton: 'btn btn-success',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = jQuery('<form />').attr('method', 'post').attr('action', '{{route('vas.tasks.destroy','')}}'+'/'+ trnId);
                    jQuery('<input />').attr('type', 'hidden').attr('name', '_method').attr('value', 'delete').appendTo(form);
                    jQuery('<input />').attr('type', 'hidden').attr('name', '_token').attr('value', '{{ csrf_token() }}').appendTo(form);
                    jQuery('body').append(form);
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancel button click
                    console.log('Cancelled');
                }
            });
        }
    </script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
@endsection

