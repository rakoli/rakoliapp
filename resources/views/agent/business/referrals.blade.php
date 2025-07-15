@extends('layouts.users.agent')

@section('title', __('Referrals'))

@section('header_js')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.business._submenu_business')

        <!--begin::Analytics Widgets Row-->
        <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
            <!--begin::Total Referred Users Widget-->
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="card bg-primary hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                                <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                                <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">{{ $stats['total_referred_users'] }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('Total Referred Users') }}</div>
                    </div>
                </div>
            </div>
            <!--end::Total Referred Users Widget-->

            <!--begin::Registration Earnings Widget-->
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="card bg-success hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M21 10H13V11C13 11.6 12.6 12 12 12C11.4 12 11 11.6 11 11V10H3C2.4 10 2 10.4 2 11V13H22V11C22 10.4 21.6 10 21 10Z" fill="currentColor"/>
                                <path opacity="0.3" d="M12 12C11.4 12 11 11.6 11 11V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V11C13 11.6 12.6 12 12 12Z" fill="currentColor"/>
                                <path opacity="0.3" d="M18.1 21H5.9C5.4 21 4.9 20.6 4.8 20.1L3 13H21L19.2 20.1C19.1 20.6 18.6 21 18.1 21Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">{{ session('currency') ?? '$' }}{{ $stats['registration_earnings'] }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('Registration Earnings') }}</div>
                    </div>
                </div>
            </div>
            <!--end::Registration Earnings Widget-->

            <!--begin::Usage Earnings Widget-->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="card bg-warning hoverable card-xl-stretch mb-5 mb-xl-8 h-xl-100">
                    <div class="card-body d-flex flex-column">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M22 7H2V11H22V7Z" fill="currentColor"/>
                                <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 15.1 13.1 16 12 16C10.9 16 10 15.1 10 14C10 12.9 10.9 12 12 12C13.1 12 14 12.9 14 14ZM16 12C16 14.2 14.2 16 12 16C9.8 16 8 14.2 8 12C8 9.8 9.8 8 12 8C14.2 8 16 9.8 16 12Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bolder fs-2 mb-2 mt-auto">{{ session('currency') ?? '$' }}{{ $stats['usage_earnings'] }}</div>
                        <div class="fw-bold text-white opacity-75 fs-6">{{ __('Usage Earnings (2 Weeks)') }}</div>
                    </div>
                </div>
            </div>
            <!--end::Usage Earnings Widget-->
        </div>
        <!--end::Analytics Widgets Row-->

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

    </script>
@endsection
