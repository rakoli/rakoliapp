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
