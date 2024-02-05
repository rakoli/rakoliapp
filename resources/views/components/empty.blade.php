@props([
    'heading' => null,
    'subheading' => null
])


<div class="card">
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Heading-->
        <div class="card-px text-center pt-15 pb-15">
            <!--begin::Title-->
            <h2 class="fs-2x fw-bold mb-0">{{ $heading }}</h2>
            <!--end::Title-->

            <!--begin::Description-->
            <p class="text-gray-500 fs-4 fw-semibold py-7">
                {{ $subheading }}
            </p>
            <!--end::Description-->

            {{ $slot }}
            <!--end::Action-->
        </div>
        <!--end::Heading-->

        <!--end::Illustration-->
    </div>
    <!--end::Card body-->
</div>

