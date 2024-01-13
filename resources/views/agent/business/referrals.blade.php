@extends('layouts.users.agent')

@section('title', __('Referrals'))

@section('header_js')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('agent.business._submenu_business')

        <!--begin::Table-->
        <div class="card card-flush mt-6 mt-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-5">
                <!--begin::Card toolbar-->
                <div class="card-toolbar my-1">
                    <button type="button" class="btn btn-primary m-5" data-bs-toggle="modal"
                        data-bs-target="#add_method_modal">
                        {{ __('Referr') }}
                    </button>
                </div>
                <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->

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
    <!--end::Container-->

    <!--begin::Modal group-->
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
    <!--end::Modal group-->

@endsection

@section('footer_js')
    <script></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    {!! $dataTableHtml->scripts() !!}
    {{-- {!!  GoogleReCaptchaV3::init() !!} --}}
    <script src="{{ asset('assets/js/custom/authentication/sign-up/general.js') }}"></script>
@endsection
