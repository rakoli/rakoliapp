@extends('layouts.app')

@section('content')

	<!--begin::Stats-->
	<div class="row gx-6 gx-xl-9">
		<div class="col-lg-6 col-xxl-4">
			<!--begin::Card-->
			<div class="card h-100">
				<!--begin::Card body-->
				<div class="card-body p-9">
					<!--begin::Heading-->
					<div class="fs-2hx fw-bold">237</div>
					<div class="fs-4 fw-semibold text-gray-400 mb-7">Current Projects</div>
					<!--end::Heading-->
					<!--begin::Wrapper-->
					<div class="d-flex flex-wrap">
						<!--begin::Chart-->
						<div class="d-flex flex-center h-100px w-100px me-9 mb-5">
							<canvas id="kt_project_list_chart"></canvas>
						</div>
						<!--end::Chart-->
						<!--begin::Labels-->
						<div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
							<!--begin::Label-->
							<div class="d-flex fs-6 fw-semibold align-items-center mb-3">
								<div class="bullet bg-primary me-3"></div>
								<div class="text-gray-400">Active</div>
								<div class="ms-auto fw-bold text-gray-700">30</div>
							</div>
							<!--end::Label-->
							<!--begin::Label-->
							<div class="d-flex fs-6 fw-semibold align-items-center mb-3">
								<div class="bullet bg-success me-3"></div>
								<div class="text-gray-400">Completed</div>
								<div class="ms-auto fw-bold text-gray-700">45</div>
							</div>
							<!--end::Label-->
							<!--begin::Label-->
							<div class="d-flex fs-6 fw-semibold align-items-center">
								<div class="bullet bg-gray-300 me-3"></div>
								<div class="text-gray-400">Yet to start</div>
								<div class="ms-auto fw-bold text-gray-700">25</div>
							</div>
							<!--end::Label-->
						</div>
						<!--end::Labels-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Card body-->
			</div>
			<!--end::Card-->
		</div>
		<div class="col-lg-6 col-xxl-4">
			<!--begin::Budget-->
			<div class="card h-100">
				<div class="card-body p-9">
					<div class="fs-2hx fw-bold">$3,290.00</div>
					<div class="fs-4 fw-semibold text-gray-400 mb-7">Project Finance</div>
					<div class="fs-6 d-flex justify-content-between mb-4">
						<div class="fw-semibold">Avg. Project Budget</div>
						<div class="d-flex fw-bold">
						<i class="ki-outline ki-arrow-up-right fs-3 me-1 text-success"></i>$6,570</div>
					</div>
					<div class="separator separator-dashed"></div>
					<div class="fs-6 d-flex justify-content-between my-4">
						<div class="fw-semibold">Lowest Project Check</div>
						<div class="d-flex fw-bold">
						<i class="ki-outline ki-arrow-down-left fs-3 me-1 text-danger"></i>$408</div>
					</div>
					<div class="separator separator-dashed"></div>
					<div class="fs-6 d-flex justify-content-between mt-4">
						<div class="fw-semibold">Ambassador Page</div>
						<div class="d-flex fw-bold">
						<i class="ki-outline ki-arrow-up-right fs-3 me-1 text-success"></i>$920</div>
					</div>
				</div>
			</div>
			<!--end::Budget-->
		</div>
		<div class="col-lg-6 col-xxl-4">
			<!--begin::Clients-->
			<div class="card h-100">
				<div class="card-body p-9">
					<!--begin::Heading-->
					<div class="fs-2hx fw-bold">49</div>
					<div class="fs-4 fw-semibold text-gray-400 mb-7">Our Clients</div>
					<!--end::Heading-->
					<!--begin::Users group-->
					<div class="symbol-group symbol-hover mb-9">
						<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
							<span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
						</div>
						<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
							<img alt="Pic" src="assets/media/avatars/300-11.jpg" />
						</div>
						<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michelle Swanston">
							<img alt="Pic" src="assets/media/avatars/300-7.jpg" />
						</div>
						<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Francis Mitcham">
							<img alt="Pic" src="assets/media/avatars/300-20.jpg" />
						</div>
						<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
							<span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
						</div>
						<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
							<img alt="Pic" src="assets/media/avatars/300-2.jpg" />
						</div>
						<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
							<span class="symbol-label bg-info text-inverse-info fw-bold">P</span>
						</div>
						<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Barry Walter">
							<img alt="Pic" src="assets/media/avatars/300-12.jpg" />
						</div>
						<a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
							<span class="symbol-label bg-dark text-gray-300 fs-8 fw-bold">+42</span>
						</a>
					</div>
					<!--end::Users group-->
					<!--begin::Actions-->
					<div class="d-flex">
						<a href="#" class="btn btn-primary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">All Clients</a>
						<a href="#" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_users_search">Invite New</a>
					</div>
					<!--end::Actions-->
				</div>
			</div>
			<!--end::Clients-->
		</div>
	</div>
	<!--end::Stats-->
	<!--begin::Toolbar-->
	<div class="d-flex flex-wrap flex-stack my-5">
		<!--begin::Heading-->
		<h2 class="fs-2 fw-semibold my-2">Projects
		<span class="fs-6 text-gray-400 ms-1">by Status</span></h2>
		<!--end::Heading-->
		<!--begin::Controls-->
		<div class="d-flex flex-wrap my-1">
			<!--begin::Select wrapper-->
			<div class="m-0">
				<!--begin::Select-->
				<select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-sm bg-body border-body fw-bold w-125px">
					<option value="Active" selected="selected">Active</option>
					<option value="Approved">In Progress</option>
					<option value="Declined">To Do</option>
					<option value="In Progress">Completed</option>
				</select>
				<!--end::Select-->
			</div>
			<!--end::Select wrapper-->
		</div>
		<!--end::Controls-->
	</div>
	<!--end::Toolbar-->
	
	
@endsection
