@extends('layouts.users.agent')

@section('title', __('general.LBL_LOANS'))


@section('breadcrumb')
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
    <!--end::Separator-->
    <!--begin::Description-->
    <small class="text-muted fs-7 fw-semibold my-1 ms-1">Loans</small>
    <!--end::Description-->
@endsection

@section('content')


    <div id="kt_app_content_container" class="app-container  container-xxl ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-50 w-xl-300px">

                @include('agent.agency.shift._user_card')

            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid px-lg-4">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>{{ __('Loans') }}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->


                    <div class="px-lg-4">


                            <div class="d-flex flex-lg-row gap-4 py-md-6">
                                @if($shift->status == \App\Utils\Enums\ShiftStatusEnum::OPEN)

                                <x-a-button
                                    class="btn btn-outline-danger btn-google text-white"
                                    route="{{ route('agency.shift.close', $shift) }}">
                                    Close Shift
                                </x-a-button>
                                @endif


                                <x-a-button
                                    route="#"
                                    class="btn-light-success btn-active-color-dark"
                                    label="Loan Amount: {{ money($loan->amount , currencyCode(), true)  }}">

                                </x-a-button>

                                <x-a-button
                                    route="#"
                                    class="btn-light-primary btn-active-color-dark"
                                    label="Loan Balance: {{ money($loan->balance , currencyCode(), true)  }}">

                                </x-a-button>


                                @if($loan->balance)
                                        <x-modal_with_button
                                            btnClass="btn btn-light-facebook"
                                            targetId="receive-loan-payment"
                                            label="Receive Payment"
                                            modalTitle="Fill the form below record Loan payment"
                                            isStacked="true"
                                        >

                                            @include('agent.agency.shift.pay-loan')


                                        </x-modal_with_button>
                                @endif

                                <x-back
                                    :route="route('agency.shift.show', $shift->id)"
                                    />


                    </div>

                        <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-8 text-gray-700">
                            <div class="d-flex flex-lg-row gap-lg-4 pb-md-8 pb-sm-6">


                            </div>


                            {!! $datatableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4 align-middle fw-bold' , 'id' => 'loans-payment-table']) !!}


                        </div>
                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>




    @push('js')

        <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"
                type="text/javascript"></script>
        {{ $datatableHtml->scripts()  }}

        <script>
            $(document).ready(function () {
                window.LaravelDataTables['loans-payment-table'].on('draw', function () {
                    KTMenu.createInstances();
                })
            })
        </script>

    @endpush

@endsection
