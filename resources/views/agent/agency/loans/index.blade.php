@extends('layouts.users.agent')

@section('title', "Loans")

@push('styles')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')


    <div id="kt_app_content_container" class="app-container  container-xxl ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">


            <!--begin::Content-->
            <div class="flex-lg-row-fluid px-lg-4">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">


                    <div class="px-lg-4">




                    </div>


                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                        <!--begin::Table-->
                        <div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">


                                {!! $datatableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4' , 'id' => 'loans-table']) !!}


                            </div>

                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>




    @push('js')


        <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>
        <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
                type="text/javascript"></script>
        {{ $datatableHtml->scripts()  }}

        <script>


            $(document).ready(function () {

                window.LaravelDataTables['loans-table'].on('draw', function () {
                    KTMenu.createInstances();
                })
            })


            // // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            // dt.on('draw', function () {
            //     KTMenu.createInstances();
            // });
        </script>

    @endpush
@endsection
