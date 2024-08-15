@use(Illuminate\Support\Number)
<div class="card mb-5 mb-xl-8">

    <div class="card-body pt-5 pb-5">
        <div class="d-flex flex-center flex-column">
            <div class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{__("Total Balance")}}</div>
            <div class="fs-5 text-gray-600 fw-bold">{{ number_format($totalBalance , 2) }} {{currencyCode()}}</div>
        </div>
    </div>

    @if($shift->status == \App\Utils\Enums\ShiftStatusEnum::OPEN)
        <!--end::Details toggle-->
        <div class="separator separator-dashed"></div>
        <!--begin::Details content-->

        <div class="card-body pt-5 pb-5">

            <x-back :route="route('agency.shift')" class="py-md-4"/>

            <x-modal_with_button
                targetId="add-transaction"
                label="Add Till Transaction"
                modalTitle="Fill the form below record a transaction"
                btnClass="btn btn-facebook m-1"
            >
            @include('agent.agency.transaction.add-transaction')
            </x-modal_with_button>

            <x-modal_with_button
                targetId="add-expenses"
                label="Add Cash Out"
                modalTitle="Fill the form below record a Cash Out"
                btnClass="btn btn-youtube m-1"
            >
            @include('agent.agency.transaction.add-expense')
            </x-modal_with_button>

            <x-modal_with_button
                btnClass="btn btn-primary m-1"
                targetId="add-income"
                label="Add Cash In"
                modalTitle="Fill the form below record a Cash in"
            >
            @include('agent.agency.transaction.add-income')
            </x-modal_with_button>

            <x-modal_with_button
                btnClass="btn btn-instagram m-1"
                targetId="add-loan"
                label="Add Loan"
                modalTitle="Fill the form below record a Loan"
            >
            @include('agent.agency.loans.add-loan')
            </x-modal_with_button>

            <x-modal_with_button
                btnClass="btn btn-facebook m-1"
                targetId="transfer-balance"
                label="Transfer Balance"
                modalTitle="Fill the form below to transfer till balance"
            >
            @include('agent.agency.transaction.transfer-balance')
            </x-modal_with_button>

            <x-a-button class="btn btn-outline-danger btn-google text-white m-1" route="{{ route('agency.shift.close', $shift) }}">Close Shift</x-a-button>

        </div>
    @endif

    <!--end::Details toggle-->
    <div class="separator separator-dashed"></div>
    <!--begin::Details content-->


    <!--begin::Card body-->
    <div class="card-body">

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


                <div class="fs-6">
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
    <div class="card-body">

        <!--begin::Details toggle-->
        <div class="d-flex flex-stack fs-4 py-3">
            <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                 href="#networks_details" role="button" aria-expanded="false"
                 aria-controls="networks_details">
                {{__('Total Balance Summary')}}
            </div>
        </div>
        <!--end::Details toggle-->

        <div class="separator separator-dashed my-3"></div>

        <!--begin::Details content-->
        <div id="networks_details" class="collapse show">
            <div class="py-5 fs-6">

                <div class="d-flex flex-row mt-5 border-bottom-2 gap-14 justify-content-lg-between">
                    <div class="fw-bold border-primary">Cash In Hand</div>
                    <div class="text-gray-600">
                        <span>{{  money(amount: $cashAtHand , convert: true, currency: currencyCode()) }}</span>
                    </div>
                </div>
                <div class="d-flex flex-row mt-5 border-bottom-2 gap-14 justify-content-lg-between">
                    <div class="fw-bold border-primary">Loan Balance</div>
                    <div class="text-gray-600">
                        <span>{{  money(amount: $loanBalances , convert: true, currency: currencyCode()) }}</span>
                    </div>
                </div>

                @foreach($networks as $name =>  $network )
                    <!--begin::Details item-->

                    <div class="d-flex flex-row mt-5 border-bottom-2 gap-14 justify-content-lg-between">
                        <div class="fw-bold border-primary">{{ $name  }}</div>
                        <div class="text-gray-600">
                            <span>{{  money(amount: $network['balance'] , convert: true, currency: currencyCode()) }}</span>
                        </div>
                    </div>
                    <!--begin::Details item-->
                @endforeach
                <div
                    class="text-gray-600 mt-15 fw-bold text-lg-end  border-bottom-3 border-dashed py-lg-2 px-lg-3 border-primary">
                    <span>{{ money(amount: $totalBalance , convert: true, currency: currencyCode()) }}</span>
                </div>
            </div>
        </div>
        <!--end::Details content-->
    </div>
    <!--end::Card body-->
</div>


