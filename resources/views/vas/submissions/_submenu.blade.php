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
                       href="{{route('vas.tasks.index')}}">{{__('Tasks')}}</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 {{returnActiveSubMenuStyle('ads')}}"
                       href="{{route('vas.contracts.index')}}">{{__('Contracts')}}</a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--end::Nav-->
        </div>
        <!--end::Hero nav-->
    </div>
    <!--end::Hero body-->
</div>
<!--end::Hero card-->
