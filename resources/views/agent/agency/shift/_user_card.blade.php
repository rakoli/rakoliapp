@use(Illuminate\Support\Number)
<div class="card mb-5 mb-xl-8">


    <div class="flex-grow-1 px-lg-4 px-sm-3 py-sm-4 ">
        <!--begin::Title-->
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
            <!--begin::User-->
            <div class="d-flex flex-column">
                <!--begin::Name-->
                <div class="d-flex align-items-center mb-2">
                    <a href="#"
                       class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $shift->user->full_name }}</a>
                    <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span
                                class="path2">

                            </span>
                        </i>
                    </a>
                </div>
                <!--end::Name-->
            </div>
            <!--end::User-->

        </div>
        <!--end::Title-->

        <!--begin::Stats-->
        <div class="d-flex flex-wrap flex-stack">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-grow-1 pe-12">
                <!--begin::Stats-->
                <div class="d-flex flex-wrap">


                    <!--begin::Stat-->
                    <div class="min-w-xl-125px py-3 px-4 me-6 mb-3">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center  ">

                            <div class="fw-bolder counted fs-2qx text-primary" data-kt-countup="true"
                                 data-kt-countup-value="{{ number_format($totalBalance , 2) }}"
                                 data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">
                                {{ Illuminate\Support\Number::currency($totalBalance, currencyCode()) }}
                            </div>
                        </div>
                        <!--end::Number-->

                        <!--begin::Label-->
                        <div class="fw-semibold fs-6 text-gray-500">{{ __('Total Balances') }}</div>
                        <!--end::Label-->
                    </div>
                    <!--end::Stat-->

                    <!--begin::Stat-->
                    <div class="border border-gray-300 border-dashed rounded min-w-xl-125px py-3 px-4 me-6 mb-3">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center  ">

                            <div class="fw-semibold counted  fs-xl-1 text-primary" data-kt-countup="true"
                                 data-kt-countup-value="{{ number_format($totalBalance  - $shift->cash_end , 2) }}"
                                 data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">
                                {{ Illuminate\Support\Number::currency($totalBalance - $shift->cash_end, currencyCode()) }}
                            </div>
                        </div>
                        <!--end::Number-->

                        <!--begin::Label-->
                        <div class="fw-semibold fs-6 text-gray-500">{{ __('Total Till Balances') }}</div>
                        <!--end::Label-->
                    </div>
                    <!--end::Stat-->

                    <!--begin::Stat-->
                    <div class="border border-gray-300 border-dashed rounded min-w-225px py-3 px-4 me-6 mb-3">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center">

                            <div class="fs-2 fw-semibold fs-10 counted" data-kt-countup="true"
                                 data-kt-countup-value="{{ number_format($shift->cash_end , 2) }}"
                                 data-kt-countup-prefix="{{ currencyCode() }}" data-kt-initialized="1">
                                {{ Illuminate\Support\Number::currency($shift->cash_end , currencyCode()) }}
                            </div>
                        </div>
                        <!--end::Number-->

                        <!--begin::Label-->
                        <div class="fw-semibold fs-6 text-gray-500">{{ __('Cash at Hand') }}</div>
                        <!--end::Label-->
                    </div>
                    <!--end::Stat-->


                </div>
                <!--end::Stats-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Stats-->
    </div>


    <!--begin::Card body-->
    <div class="card-body">


        <!--begin::Details toggle-->
        <div class="d-flex flex-stack fs-4 py-3">
            <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                 href="#kt_customer_view_details" role="button" aria-expanded="false"
                 aria-controls="kt_customer_view_details">
                Details
                <span class="ms-2 rotate-180">

                    <i class="ki-duotone ki-down fs-3"></i>
                </span>
            </div>
        </div>
        <!--end::Details toggle-->

        <div class="separator separator-dashed my-3"></div>

        <!--begin::Details content-->
        <div id="kt_customer_view_details" class="collapse show">
            <div class="py-5 fs-6">


                <!--begin::Details item-->

                <div class="d-flex flex-row mt-5 border-bottom-2 gap-14 justify-content-lg-between">
                    <div class="fw-bold border-primary">Status</div>
                    <div class="text-gray-600">
                        <span class="{{ $shift->status->color() }}">{{ $shift->status->label() }}</span>
                    </div>
                </div>
                <!--begin::Details item-->

                <!--begin::Details item-->
                <div class="fw-bold mt-5 d-flex between gap-14 justify-content-lg-between">Date :
                    <span> {{ $shift->created_at->format('Y-m-d')  }} </span>

                </div>


                <div class="fw-bold mt-5 d-flex between gap-14 justify-content-lg-between">Shift's No:
                    <span>   {{ $shift->no  }}  </span></div>


                <div class="pb-5 fs-6">
                    <!--begin::Details item-->
                    <div class="d-flex flex-row gap-14 mt-5 justify-content-lg-between">
                        <div class="fw-bold">User:</div>
                        <div class="text-gray-600">{{ $shift->user->full_name }}</div>
                    </div>
                </div>

            </div>
        </div>
        <!--end::Details content-->
    </div>
    <!--end::Card body-->
</div>


<div class="card mb-5 mb-xl-8">
    <div class="card-body pt-15">


        <!--begin::Details toggle-->
        <div class="d-flex flex-stack fs-4 py-3">
            <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                 href="#networks_details" role="button" aria-expanded="false"
                 aria-controls="networks_details">
                Networks
                <span class="ms-2 rotate-180">

                    <i class="ki-duotone ki-down fs-3"></i>
                </span>
            </div>
        </div>
        <!--end::Details toggle-->

        <div class="separator separator-dashed my-3"></div>

        <!--begin::Details content-->
        <div id="networks_details" class="collapse show">
            <div class="py-5 fs-6">


                @foreach($tills as $network)
                    <!--begin::Details item-->

                    <div class="d-flex flex-row mt-5 border-bottom-2 gap-14 justify-content-lg-between">
                        <div class="fw-bold border-primary">{{ $network->network ->agency->name}}</div>
                        <div class="text-gray-600">
                            <span>{{  money(amount: $network->balance_new , convert: true, currency: currencyCode()) }}</span>
                        </div>
                    </div>
                    <!--begin::Details item-->
                @endforeach
                <div
                    class="text-gray-600 mt-15 fw-bold text-lg-end  border-bottom-3 border-dashed py-lg-2 px-lg-3 border-primary">
                    <span>{{ money(amount: $tills->sum('balance_new') , convert: true, currency: currencyCode()) }}</span>
                </div>
            </div>
        </div>
        <!--end::Details content-->
    </div>
    <!--end::Card body-->
</div>


