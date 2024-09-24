@extends('layouts.users.agent')

@section('title', __("Dashboard"))

@section('header_js')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection
<style>
    .d-flex.flex-column.content-justify-center.flex-row-fluid{width:100%}
    .align-start{align-items: flex-start;}
</style>
@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">


        <!--begin::Row-->
        <div class="row g-5 gx-xl-10 mb-5 mb-xl-10 align-start">

            <!--begin::Col-->
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <!--begin::List widget 4-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">{{__('Highlights')}}</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">{{__('30 days financials')}}</span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-5">
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <div class="text-gray-700 fw-semibold fs-6 me-2">{{__('Debit (cash in)')}}</div>
                            <!--end::Section-->
                            <!--begin::Statistics-->
                            <div class="d-flex align-items-senter">
                                <!--begin::Number-->
                                <span class="text-gray-900 fw-bolder fs-6">{{session('currency').' '.$stats['highlights']['income']}}</span>
                            </div>
                            <!--end::Statistics-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <div class="text-gray-700 fw-semibold fs-6 me-2">{{__('Credit (cash out)')}}</div>
                            <!--end::Section-->
                            <!--begin::Statistics-->
                            <div class="d-flex align-items-senter">
                                <!--begin::Number-->
                                <span class="text-gray-900 fw-bolder fs-6">{{session('currency').' '.$stats['highlights']['expense']}}</span>
                                <!--end::Number-->
                            </div>
                            <!--end::Statistics-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <div class="text-gray-700 fw-semibold fs-6 me-2">{{__('Referrals')}}</div>
                            <!--end::Section-->
                            <!--begin::Statistics-->
                            <div class="d-flex align-items-senter">
                                <!--begin::Number-->
                                <span class="text-gray-900 fw-bolder fs-6">{{$stats['highlights']['referrals']}}</span>
                                <!--end::Number-->
                            </div>
                            <!--end::Statistics-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::LIst widget 4-->
                <!--begin::Card widget 1-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold me-2 lh-1 ls-n2">{{$stats['networks']}}</span>
                            <!--end::Amount-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-400 pt-1 fw-semibold fs-6">{{__('Network Tills')}}</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body d-flex align-items-end pt-0">
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                            <div class="d-flex justify-content-between fw-bold fs-6 w-100 mt-auto mb-2">
                                <span>{{$stats['open_shifts']}} {{__('Open Shifts')}}</span>
                            </div>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 1-->
                
                <!--begin::Card widget 2-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{$stats['awarded_vas']}}</span>
                            <!--end::Amount-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-400 pt-1 fw-semibold fs-6">{{__('Awarded VAS')}}</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body d-flex align-items-end pt-0">
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                            <div class="d-flex justify-content-between fw-bold fs-6 w-100 mt-auto mb-2">
                                <span>{{$stats['pending_exchange']}} {{__('Pending Exchange')}}</span>
                            </div>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 2-->
                
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <!--begin::Card widget 3-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Currency-->
                                {{-- <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">{{session('currency')}}</span> --}}
                                <!--end::Currency-->
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{$stats['total_transaction']}}</span>
                                <!--end::Amount-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-400 pt-1 fw-semibold fs-6">{{__('Total Transaction')}}</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                        <!--begin::Chart-->
                        <div class="d-flex flex-center me-5 pt-2">
                            <div id="kt_card_widget_17_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
                        </div>
                        <!--end::Chart-->
                        <!--begin::Labels-->
                        <div class="d-flex flex-column content-justify-center flex-row-fluid">
                            <!--begin::Label-->
                            <div class="d-flex fw-semibold align-items-center">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                <!--end::Bullet-->
                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">{{__('Deposit')}}</div>
                                <!--end::Label-->
                                <!--begin::Stats-->
                                <div class="fw-bolder text-gray-700 text-xxl-end">{{session('currency').' '.$stats['deposit_transaction']}}</div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fw-semibold align-items-center my-3">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                <!--end::Bullet-->
                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">{{__('Withdraw')}}</div>
                                <!--end::Label-->
                                <!--begin::Stats-->
                                <div class="fw-bolder text-gray-700 text-xxl-end">{{session('currency').' '.$stats['withdraw_transaction']}}</div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Labels-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 3-->
                <!--begin::Card widget 3-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Currency-->
                                <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">{{session('currency')}}</span>
                                <!--end::Currency-->
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{$stats['total_location_balance']}}</span>
                                <!--end::Amount-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-400 pt-1 fw-semibold fs-6">{{__('Total Balance')}}</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                        <!--begin::Chart-->
                        <div class="d-flex flex-center me-5 pt-2">
                            <div id="kt_card_widget_17_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
                        </div>
                        <!--end::Chart-->
                        <!--begin::Labels-->
                        <div class="d-flex flex-column content-justify-center flex-row-fluid">
                            <!--begin::Label-->
                            <div class="d-flex fw-semibold align-items-center">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                <!--end::Bullet-->
                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">{{__('Cash')}}</div>
                                <!--end::Label-->
                                <!--begin::Stats-->
                                <div class="fw-bolder text-gray-700 text-xxl-end">{{session('currency').' '.$stats['cash_balance']}}</div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fw-semibold align-items-center my-3">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                <!--end::Bullet-->
                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">{{__('Network Tills')}}</div>
                                <!--end::Label-->
                                <!--begin::Stats-->
                                <div class="fw-bolder text-gray-700 text-xxl-end">{{session('currency').' '.$stats['till_balance']}}</div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fw-semibold align-items-center my-3">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                <!--end::Bullet-->
                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">{{__('Loan Balance')}}</div>
                                <!--end::Label-->
                                <!--begin::Stats-->
                                <div class="fw-bolder text-gray-700 text-xxl-end">{{session('currency').' '.$stats['loan_balance']}}</div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fw-semibold align-items-center my-3">
                                <div class="m-0">
                                    <a href="{{ route('agent.report') }}" class="btn btn-sm btn-primary mb-2">See More</a>
                                </div>
                            </div>
                            <!--end::Label-->
                            
                        </div>
                        <!--end::Labels-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 3-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-xxl-6">
                <!--begin::Engage widget 10-->
                <div class="card card-flush h-md-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0" >
                        <!--begin::Wrapper-->
                        <div class="mb-10">
                            <!--begin::Title-->
                            <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                                                    <span class="me-2">Welcome to the leading
                                                    <br />
                                                    <span class="position-relative d-inline-block text-danger">
                                                        <!--begin::Separator-->
                                                        <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                                        <!--end::Separator-->
                                                    </span></span>Agency Management</div>
                            <!--end::Title-->
                            <!--begin::Action-->
                            <div class="text-center">
                                @if(!hasOpenShift())
                                    <a href="{{route('agency.shift.open.index')}}" class="btn btn-sm btn-dark fw-bold m-1">{{__('Open Shift')}}</a>
                                @else
                                    @php
                                        $shift = getOpenShift();
                                    @endphp
                                    <a href="{{route('agency.shift.show',$shift->id)}}" class="btn btn-sm btn-dark fw-bold m-1">{{__('View Open Shift')}}</a>
                                @endif
                                <a href="{{route('exchange.ads')}}" class="btn btn-sm btn-dark fw-bold m-1">{{__('Exchange Float')}}</a>
                                <a href="{{route('agent.tasks')}}" class="btn btn-sm btn-dark fw-bold m-1">{{__('View Opportunities')}}</a>
                            </div>
                        </div>
                        <!--begin::Wrapper-->
                        <!--begin::Illustration-->
                        <img class="mx-auto h-150px h-lg-200px theme-light-show" src="{{asset('assets/media/illustrations/misc/upgrade.svg')}}" alt="" />
                        <img class="mx-auto h-150px h-lg-200px theme-dark-show" src="{{asset('assets/media/illustrations/misc/upgrade-dark.svg')}}" alt="" />
                        <!--end::Illustration-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Engage widget 10-->
            </div>
            <!--end::Col-->

        </div>
        <!--end::Row-->

        <!--begin::Row-->
        <div class="row g-5 gx-xl-10 mb-5 mb-xl-10 align-start">
            <!--begin::Table widget 1-->
            <div class="card card-flush mb-xxl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Summary</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Tab Content-->
                    <div class="tab-content">
                        <!--begin::Tap pane-->
                        <div class="tab-pane fade show active">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle gs-0 gy-4 my-0">
                                    <!--begin::Table head-->
                                    <thead>
                                        @foreach ($stats['bussiness_summary'] as $key => $branch)
                                        <tr>
                                            <td>
                                                <span class="text-gray-800 fs-7 fw-bold">{!! $branch['name'] !!}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fs-7 fw-bold">{{session('currency').' '.number_format($branch['physical_balance'],2)}}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fs-7 fw-bold">{{session('currency').' '.number_format($branch['credit'],2)}}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fs-7 fw-bold">{{session('currency').' '.number_format($branch['debit'],2)}}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fs-7 fw-bold">{{session('currency').' '.number_format($branch['expense'],2)}}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fs-7 fw-bold">{{session('currency').' '.number_format($branch['total_balance'],2)}}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fs-7 fw-bold">{{session('currency').' '.number_format($branch['capital'],2)}}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fs-7 fw-bold">{{session('currency').' '.number_format($branch['differ'],2)}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                        <tr class="fs-7 fw-bold text-gray-500">
                                            <th class="pe-0 min-w-120px pt-3">Branch Name</th>
                                            <th class="pe-0 min-w-120px pt-3">Physical Balance (Cash + Till)</th>
                                            <th class="pe-0 min-w-120px pt-3">Credit (Money In)</th>
                                            <th class="pe-0 min-w-120px pt-3">Debit (Money Out)</th>
                                            <th class="pe-0 min-w-120px pt-3">Expense</th>
                                            <th class="pe-0 min-w-120px pt-3">Total Balance</th>
                                            <th class="pe-0 min-w-120px pt-3">Captial</th>
                                            <th class="pe-0 min-w-120px pt-3">Differ</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @foreach ($stats['branch_summary'] as $key => $branch)
                                            <tr>
                                                <td>
                                                    <span class="text-gray-800 fs-7">{!! $branch['name'] !!}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fs-7">{{session('currency').' '.number_format($branch['physical_balance'],2)}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fs-7">{{session('currency').' '.number_format($branch['credit'],2)}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fs-7">{{session('currency').' '.number_format($branch['debit'],2)}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fs-7">{{session('currency').' '.number_format($branch['expense'],2)}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fs-7">{{session('currency').' '.number_format($branch['total_balance'],2)}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fs-7">{{session('currency').' '.number_format($branch['capital'],2)}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fs-7">{{session('currency').' '.number_format($branch['differ'],2)}}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Tap pane-->
                    </div>
                    <!--end::Tab Content-->
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Table widget 1-->
        </div>
        <!--end::Row-->



        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-xl-12">
                <!--begin::Table widget 14-->
                <div class="card card-flush h-md-100">
                    <!--begin::Header-->
                    <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">{{__('Recent Transactions')}}</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <a href="{{route('agency.transactions')}}" class="btn btn-sm btn-light">{{__('View Transactions')}}</a>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-6">
                        <!--begin::Table container-->
                        {!! $dataTableHtml->table(['class' => 'table table-striped table-row-bordered gy-5 gs-7'],true) !!}
                        <!--end::Table-->
                    </div>
                    <!--end: Card Body-->
                </div>
                <!--end::Table widget 14-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
@endsection
