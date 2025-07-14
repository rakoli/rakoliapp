@extends('layouts.users.agent')

@section('title', __('Referrals'))

@section('header_js')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.business._submenu_business')

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">

                    <!--Begin::Card Footer (Actions)-->
                    <div class="card-body pt-5">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_method_modal">
                            {{__('Refer Customer')}}
                        </button>

                    </div>
                    <!--end::Card Footer (Actions)-->

                    <!--end::Details toggle-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            <div class="py-5 fs-6">

                                <div class="fw-bold mt-5">{{__("Total Number of Referrals")}}</div>
                                <div class="text-gray-600">{{$stats['total_referrals']}}</div>

                                <div class="fw-bold mt-5">{{__("Annual Estimated Commission")}}</div>
                                <div class="text-gray-600">
                                    {{$stats['annual_commission']}}
                                </div>

                                <div class="fw-bold mt-5">{{__("No of Inactive Referral")}}</div>
                                <div class="text-gray-600">
                                    {{$stats['inactive_referrals']}}
                                </div>

                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Referral Link")}}</div>
                                <div class="text-gray-600">
                                    <div class="input-group input-group-solid input-group-sm mb-5">
                                        <input id="kt_clipboard_referrallink" type="text" class="form-control" value="{{route('referral.link', auth()->user()->business_code)}}" readonly/>
                                        <button class="btn btn-primary" data-clipboard-target="#kt_clipboard_referrallink">Copy</button>
                                    </div>
                                </div>
                                <!--end::Details item-->
                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>

                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!--begin::Earnings Dashboard-->
                <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
                    <!--begin::Earnings Overview Card-->
                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">{{ __('Earnings Dashboard') }}</span>
                                    <span class="text-muted mt-1 fw-semibold fs-7">{{ __('Complete referral earnings breakdown') }}</span>
                                </h3>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" onclick="location.reload();">
                                        <i class="ki-duotone ki-arrows-circle fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <!--begin::Total Earnings Row-->
                                <div class="row mb-8">
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center bg-light-success rounded p-5">
                                            <i class="ki-duotone ki-wallet fs-1 text-success me-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-bold fs-6 d-block">{{ __('Total Earnings') }}</span>
                                                <span class="text-success fw-bold fs-2">{{ number_format($stats['total_earnings']) }} TZS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center bg-light-primary rounded p-5">
                                            <i class="ki-duotone ki-arrow-down fs-1 text-primary me-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-bold fs-6 d-block">{{ __('Paid Earnings') }}</span>
                                                <span class="text-primary fw-bold fs-2">{{ number_format($stats['paid_earnings']) }} TZS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center bg-light-warning rounded p-5">
                                            <i class="ki-duotone ki-time fs-1 text-warning me-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-bold fs-6 d-block">{{ __('Pending Earnings') }}</span>
                                                <span class="text-warning fw-bold fs-2">{{ number_format($stats['pending_earnings']) }} TZS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--begin::Earnings Breakdown-->
                                <div class="separator separator-dashed my-6"></div>
                                <h4 class="fw-bold text-gray-800 mb-5">{{ __('Earnings Breakdown') }}</h4>
                                <div class="row mb-8">
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-5">
                                                <span class="symbol-label bg-light-info">
                                                    <i class="ki-duotone ki-user-tick fs-2 text-info">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-semibold d-block fs-7">{{ __('Registration Bonuses') }}</span>
                                                <span class="text-gray-400 fw-semibold fs-8">{{ $stats['registration_bonus_count'] }} × 500 TZS</span>
                                                <span class="text-gray-800 fw-bold d-block fs-5">{{ number_format($stats['registration_earnings']) }} TZS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-5">
                                                <span class="symbol-label bg-light-success">
                                                    <i class="ki-duotone ki-chart-line-up fs-2 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-semibold d-block fs-7">{{ __('Week 1 Usage Bonuses') }}</span>
                                                <span class="text-gray-400 fw-semibold fs-8">{{ $stats['week1_bonus_count'] }} × 1000 TZS</span>
                                                <span class="text-gray-800 fw-bold d-block fs-5">{{ number_format($stats['week1_earnings']) }} TZS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-5">
                                                <span class="symbol-label bg-light-danger">
                                                    <i class="ki-duotone ki-chart-line-up fs-2 text-danger">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="text-gray-800 fw-semibold d-block fs-7">{{ __('Week 2 Usage Bonuses') }}</span>
                                                <span class="text-gray-400 fw-semibold fs-8">{{ $stats['week2_bonus_count'] }} × 1000 TZS</span>
                                                <span class="text-gray-800 fw-bold d-block fs-5">{{ number_format($stats['week2_earnings']) }} TZS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--begin::Performance Metrics-->
                                <div class="separator separator-dashed my-6"></div>
                                <h4 class="fw-bold text-gray-800 mb-5">{{ __('Performance Metrics') }}</h4>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center justify-content-between bg-light rounded p-4">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up-right fs-2 text-success me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div>
                                                    <span class="text-gray-700 fw-semibold d-block">{{ __('Conversion Rate') }}</span>
                                                    <span class="text-gray-400 fw-semibold fs-7" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Percentage of referred users who completed registration with package purchase') }}">{{ __('Referrals → Registrations') }}</span>
                                                </div>
                                            </div>
                                            <span class="badge badge-light-success fs-6 fw-bold">{{ $stats['conversion_rate'] }}%</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center justify-content-between bg-light rounded p-4">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-chart-pie-simple fs-2 text-primary me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div>
                                                    <span class="text-gray-700 fw-semibold d-block">{{ __('Transaction Success') }}</span>
                                                    <span class="text-gray-400 fw-semibold fs-7" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Percentage of registered businesses that reached 10+ transactions per week') }}">{{ __('Businesses with 10+ transactions') }}</span>
                                                </div>
                                            </div>
                                            <span class="badge badge-light-primary fs-6 fw-bold">{{ $stats['transaction_success_rate'] }}%</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-5">
                                        <div class="d-flex align-items-center justify-content-between bg-light rounded p-4">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-pulse fs-2 text-warning me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div>
                                                    <span class="text-gray-700 fw-semibold d-block">{{ __('Active Referrals') }}</span>
                                                    <span class="text-gray-400 fw-semibold fs-7" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Number of referred businesses still within the 2-week bonus earning period') }}">{{ __('In 2-week bonus period') }}</span>
                                                </div>
                                            </div>
                                            <span class="badge badge-light-warning fs-6 fw-bold">{{ $stats['active_referrals'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Earnings Dashboard-->

                <!--begin::Table-->
                <div class="card card-flush">

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table container-->
                        <div class="table-responsive">

                            {!! $dataTableHtml->table(['class' => 'table table-row-bordered table-row-dashed gy-4'], true) !!}

                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            </div>
            <!--end::Content-->

            <!--begin::ACTION MODULES-->
            <div class="modal fade" tabindex="-1" id="add_method_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{ __('Referring Business') }}</h3>
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                 aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <form class="my-auto pb-5" action="{{ route('business.referrals.referr') }}" method="POST">
                            @csrf
                            <div class="modal-body">

                                <div class="fv-row mb-8">
                                    <div class="d-flex flex-column flex-md-row gap-5">
                                        <div class="fv-row flex-row-fluid">
                                            <input type="text" placeholder="{{ __("First Name") }}" name="fname" autocomplete="off" class="form-control bg-transparent" />
                                        </div>
                                        <div class="fv-row flex-row-fluid">
                                            <input type="text" placeholder="{{ __("Last Name") }}" name="lname" autocomplete="off" class="form-control bg-transparent" />
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="d-flex flex-column flex-md-row gap-5">

                                        <div class="flex-row-fluid" style="max-width: 160px;">
                                            <!--begin::Input-->
                                            <select id="countrySelect" class="form-control bg-transparent" name="country">
                                                <option value="">{{ __('Your Country') }}</option>
                                                @foreach (\App\Models\Country::all() as $country)
                                                    <option value="{{ $country->dialing_code }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <div class="fv-row flex-row-fluid" style="max-width: 70px;">
                                            <!--begin::Input-->
                                            <input id="codeInput" class="form-control bg-transparent"
                                                   placeholder="{{ __('Code') }}" name="country_dial_code" readonly placeholder=""
                                                   value="" />
                                            <!--end::Input-->
                                        </div>
                                        <div class="fv-row flex-row-fluid">
                                            <!--begin::Input-->
                                            <input class="form-control bg-transparent" name="phone" placeholder="07XX..."
                                                   value="" maxlength="10" />
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="{{ __('Email') }}" name="email" autocomplete="off"
                                           class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">{{ __('Referr') }}</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::ACTION MODULES-->

        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
    <script>
        const countrySelect = document.getElementById('countrySelect');
        const codeInput = document.getElementById('codeInput');

        // Add an event listener to the select element
        countrySelect.addEventListener('change', function () {
            // Get the selected option's value
            const selectedCountry = countrySelect.value;

            // Update the code input field with the selected country's value
            codeInput.value = selectedCountry;
        });
    </script>

    <script>

        //REFERRAL LINK - CLIPBOARD
        const targetReferralLink = document.getElementById('kt_clipboard_referrallink');
        const referralLinkButton = targetReferralLink.nextElementSibling;
        var acNameClipboard = new ClipboardJS(referralLinkButton, {
            target: targetReferralLink,
            text: function() {
                return targetReferralLink.value;
            }
        });
        acNameClipboard.on('success', function(e) {
            const currentLabel = referralLinkButton.innerHTML;
            if(referralLinkButton.innerHTML === 'Copied!'){
                return;
            }
            referralLinkButton.innerHTML = 'Copied!';
            setTimeout(function(){
                referralLinkButton.innerHTML = currentLabel;
            }, 3000)
        });
        //END:: REFERRAL LINK - CLIPBOARD

        // Refresh earnings dashboard
        function refreshEarningsDashboard() {
            // Add loading state
            const refreshBtn = document.querySelector('.btn-sm.btn-icon');
            const originalHtml = refreshBtn.innerHTML;
            refreshBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            // Reload the page to get updated stats
            setTimeout(() => {
                location.reload();
            }, 1000);
        }

        // Add click handler to refresh button
        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.querySelector('.btn-sm.btn-icon[onclick="location.reload();"]');
            if (refreshBtn) {
                refreshBtn.removeAttribute('onclick');
                refreshBtn.addEventListener('click', refreshEarningsDashboard);
            }

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

    </script>
@endsection
