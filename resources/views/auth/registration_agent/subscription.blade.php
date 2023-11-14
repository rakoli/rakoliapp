<div class="" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-800">
        <!--begin::Heading-->
        <div>
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">Select Package</h2>
            <!--end::Title-->
            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">Choose a subscription package that fits your business needs.</div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->
        <!--begin::Plans-->
        <div class="d-flex flex-column">

            <!--begin::Row-->
            <div class="row">
                @foreach(\App\Models\Package::where('country_code', auth()->user()->country_code)->get() as $package )

                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <div class="d-flex h-100 align-items-center">
                            <!--begin::Option-->
                            <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                <!--begin::Heading-->
                                <div class="mb-7 text-center">
                                    <!--begin::Title-->
                                    <h1 class="text-dark mb-5 fw-bolder">{{strtoupper($package->name)}}</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-gray-600 fw-semibold mb-5">{{$package->description}}</div>
                                    <!--end::Description-->
                                    <!--begin::Price-->
                                    <div class="text-center">
                                        <span class="mb-2 text-primary">{{strtoupper($package->price_currency)}}</span>
                                        <span class="fs-3x fw-bold text-primary">{{number_format_short($package->price)}}</span>
                                        <span class="fs-7 fw-semibold opacity-50">/
																<span data-kt-element="period">{{$package->package_interval_days}} days</span></span>
                                    </div>
                                    <!--end::Price-->
                                </div>
                                <!--end::Heading-->
                                <!--begin::Features-->
                                <div class="w-100 mb-5">
                                    @foreach(\App\Models\PackageFeature::where("package_code", $package->code)->get() as $packageFeature)
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-5">
                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{$packageFeature->feature->name}}
                                                @if($packageFeature->feature->name == 'tills')
                                                    per branch
                                                @endif
                                                @if($packageFeature->feature_value != null)
                                                    ({{$packageFeature->feature_value}})
                                                @endif
                                            </span>
                                            <i class="ki-outline
                                            @if($packageFeature->available == true)
                                                ki-check-circle fs-1 text-success
                                            @else
                                                ki-cross-circle fs-1
                                            @endif"></i>
                                        </div>
                                        <!--end::Item-->
                                    @endforeach
                                </div>
                                <!--end::Features-->

                                <!--begin::Select-->
                                <a href="#" class="btn btn-sm btn-primary">Select</a>
                                <!--end::Select-->
                            </div>
                            <!--end::Option-->
                        </div>
                    </div>
                    <!--end::Col-->
                @endforeach

            </div>
            <!--end::Row-->
        </div>
        <!--end::Plans-->
    </div>
    <!--end::Wrapper-->

</div>
