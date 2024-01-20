<div class="card mb-5 mb-xl-8">

    <h3 class="card-title align-items-start flex-column px-6 py-6">


        <!--begin::Statistics-->
        <div class="d-flex align-items-center mb-2">
            <!--begin::Currency-->
            <span
                class="fs-3 fw-semibold text-gray-500 align-self-start me-1">{{ currencyCode() }}</span>
            <!--end::Currency-->

            <!--begin::Value-->
            <span
                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format($totalBalance, 2) }}</span>
            <!--end::Value-->


            <!--end::Label-->
        </div>
        <!--end::Statistics-->

        <!--begin::Description-->
        <span class="fs-6 fw-semibold text-gray-500">Total Balance</span>
        <!--end::Description-->
    </h3>
    <!--begin::Card body-->
    <div class="card-body pt-15">


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

                <div class="d-flex flex-row mt-5 border-bottom-2 gap-14">
                    <div class="fw-bold border-primary">Status</div>
                    <div class="text-gray-600">
                        <span class="{{ $shift->status->color() }}">{{ $shift->status->label() }}</span>
                    </div>
                </div>
                <!--begin::Details item-->

                <!--begin::Details item-->
                <div class="fw-bold mt-5 d-flex between gap-14">Date :  <span> {{ $shift->created_at->format('Y-m-d')  }} </span>

                    </div>


                <div class="fw-bold mt-5 d-flex between gap-14">Shift's No: <span>   {{ $shift->no  }}  </span></div>



                <div class="pb-5 fs-6">
                    <!--begin::Details item-->
                   <div class="d-flex flex-row gap-14 mt-5">
                       <div class="fw-bold">User:  </div>
                       <div class="text-gray-600">{{ $shift->user->full_name }}</div>
                   </div>
                </div>

            </div>
        </div>
        <!--end::Details content-->
    </div>
    <!--end::Card body-->
</div>


