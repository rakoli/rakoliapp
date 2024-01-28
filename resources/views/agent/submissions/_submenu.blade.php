<!--begin::Hero card-->
<div class="card mb-12">
    <!--begin::Hero body-->
    <div class="card-body flex-column">
        <!--begin::Hero nav-->
        <div class="card-rounded d-flex flex-stack flex-wrap">
            <!--begin::Nav-->
            <ul class="nav flex-wrap border-transparent fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('ads')}}"
                       href="{{route('contracts.index')}}">{{__('Contracts')}}</a>
                </li>
                <!--end::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('ads')}}"
                       href="{{route('contracts.submissions.index',array($contract->id))}}">{{__('Submissions')}}</a>
                </li>
                <!--end::Nav item-->

            </ul>
            <!--end::Nav-->
                            <!--begin::Action-->
                            <a href="{{route('contracts.submissions.create',array($contract->id))}}" class="btn btn-primary fw-bold fs-8 fs-lg-base">{{__('Create Submission')}}</a>
                            <!--end::Action-->

        </div>
        <!--end::Hero nav-->
    </div>
    <!--end::Hero body-->
</div>
<!--end::Hero card-->
