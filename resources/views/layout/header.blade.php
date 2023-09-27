<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="../../"/>
		<title>RAKOLI DASHBOARD</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
				<div id="kt_aside" class="aside overflow-visible pb-5 pt-5 pt-lg-0" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80px', '300px': '100px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
					<!--begin::Brand-->
					<div class="aside-logo py-8" id="kt_aside_logo">
						<!--begin::Logo-->
						<a href="index.html" class="d-flex align-items-center">
							<img alt="Logo" src="favicon.ico" class="h-45px logo" />
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
					<div class="aside-menu flex-column-fluid" id="kt_aside_menu">
						<!--begin::Aside Menu-->
						<div class="hover-scroll-y my-2 my-lg-5 scroll-ms" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
							<!--begin::Menu-->
							<div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold" id="#kt_aside_menu" data-kt-menu="true">
								<!--begin:Menu item-->
								@if(session('type') == 'admin')
									@include('menus.admin')
								@elseif(session('type') == 'vas')
									@include('menus.vas')
								@elseif(session('type') == 'agent')
									@include('menus.agent')
								@endif
								<!--end:Menu item-->
								 
							</div>
							<!--end::Menu-->
						</div>
						<!--end::Aside Menu-->
					</div>
					<!--end::Aside menu-->
					
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" style="" class="header align-items-stretch">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Aside mobile toggle-->
							<div class="d-flex align-items-center d-lg-none ms-n1 me-2" title="Show aside menu">
								<div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
									<i class="ki-outline ki-abstract-14 fs-1"></i>
								</div>
							</div>
							<!--end::Aside mobile toggle-->
							<!--begin::Mobile logo-->
							<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
								<a href="index.html" class="d-lg-none">
									<img alt="Logo" src="assets/media/logos/demo6.svg" class="h-25px" />
								</a>
							</div>
							<!--end::Mobile logo-->
							<!--begin::Wrapper-->
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
								<!--begin::Navbar-->
								<div class="d-flex align-items-stretch" id="kt_header_nav">
									<!--begin::Menu wrapper-->
									<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
										<!--begin::Menu-->
										<div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-state-primary menu-title-gray-700 menu-arrow-gray-400 fw-semibold my-5 my-lg-0 px-2 px-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
											<!--begin:Menu item-->
											<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
												<!--begin:Menu link-->
												<span class="menu-link py-3">
													<span class="menu-title">Dashboard</span>
													<span class="menu-arrow d-lg-none"></span>
												</span>
												<!--end:Menu link-->												
											</div>
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Menu wrapper-->
								</div>
								<!--end::Navbar-->
								<!--begin::Toolbar wrapper-->
								<div class="d-flex align-items-stretch flex-shrink-0">
									<!--begin::Search-->
									<div class="d-flex align-items-stretch ms-1 ms-lg-3">
										<!--begin::Search-->
										<div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
											<!--begin::Search toggle-->
											<div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
												<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px">
													<i class="ki-outline ki-magnifier fs-1"></i>
												</div>
											</div>
											<!--end::Search toggle-->
											<!--begin::Menu-->
											<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
												<!--begin::Wrapper-->
												<div data-kt-search-element="wrapper">
													<!--begin::Form-->
													<form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
														<!--begin::Icon-->
														<i class="ki-outline ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-0"></i>
														<!--end::Icon-->
														<!--begin::Input-->
														<input type="text" class="search-input form-control form-control-flush ps-10" name="search" value="" placeholder="Search..." data-kt-search-element="input" />
														<!--end::Input-->
														<!--begin::Spinner-->
														<span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
															<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
														</span>
														<!--end::Spinner-->
														<!--begin::Reset-->
														<span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none" data-kt-search-element="clear">
															<i class="ki-outline ki-cross fs-2 fs-lg-1 me-0"></i>
														</span>
														<!--end::Reset-->
														<!--begin::Toolbar-->
														<div class="position-absolute top-50 end-0 translate-middle-y" data-kt-search-element="toolbar">
															<!--begin::Preferences toggle-->
															<div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-1" data-bs-toggle="tooltip" title="Show search preferences">
																<i class="ki-outline ki-setting-2 fs-2"></i>
															</div>
															<!--end::Preferences toggle-->
															<!--begin::Advanced search toggle-->
															<div data-kt-search-element="advanced-options-form-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary" data-bs-toggle="tooltip" title="Show more search options">
																<i class="ki-outline ki-down fs-2"></i>
															</div>
															<!--end::Advanced search toggle-->
														</div>
														<!--end::Toolbar-->
													</form>
													<!--end::Form-->
													<!--begin::Separator-->
													<div class="separator border-gray-200 mb-6"></div>
													<!--end::Separator-->
													<!--begin::Recently viewed-->
													<div data-kt-search-element="results" class="d-none">
														<!--begin::Items-->
														<div class="scroll-y mh-200px mh-lg-350px">
															<!--begin::Category title-->
															<h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">Users</h3>
															<!--end::Category title-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<img src="assets/media/avatars/300-6.jpg" alt="" />
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Karina Clark</span>
																	<span class="fs-7 fw-semibold text-muted">Marketing Manager</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<img src="assets/media/avatars/300-2.jpg" alt="" />
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Olivia Bold</span>
																	<span class="fs-7 fw-semibold text-muted">Software Engineer</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<img src="assets/media/avatars/300-9.jpg" alt="" />
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Ana Clark</span>
																	<span class="fs-7 fw-semibold text-muted">UI/UX Designer</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<img src="assets/media/avatars/300-14.jpg" alt="" />
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Nick Pitola</span>
																	<span class="fs-7 fw-semibold text-muted">Art Director</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<img src="assets/media/avatars/300-11.jpg" alt="" />
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Edward Kulnic</span>
																	<span class="fs-7 fw-semibold text-muted">System Administrator</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Category title-->
															<h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Customers</h3>
															<!--end::Category title-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<img class="w-20px h-20px" src="assets/media/svg/brand-logos/volicity-9.svg" alt="" />
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Company Rbranding</span>
																	<span class="fs-7 fw-semibold text-muted">UI Design</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<img class="w-20px h-20px" src="assets/media/svg/brand-logos/tvit.svg" alt="" />
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Company Re-branding</span>
																	<span class="fs-7 fw-semibold text-muted">Web Development</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<img class="w-20px h-20px" src="assets/media/svg/misc/infography.svg" alt="" />
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Business Analytics App</span>
																	<span class="fs-7 fw-semibold text-muted">Administration</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<img class="w-20px h-20px" src="assets/media/svg/brand-logos/leaf.svg" alt="" />
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">EcoLeaf App Launch</span>
																	<span class="fs-7 fw-semibold text-muted">Marketing</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<img class="w-20px h-20px" src="assets/media/svg/brand-logos/tower.svg" alt="" />
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column justify-content-start fw-semibold">
																	<span class="fs-6 fw-semibold">Tower Group Website</span>
																	<span class="fs-7 fw-semibold text-muted">Google Adwords</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Category title-->
															<h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Projects</h3>
															<!--end::Category title-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-notepad fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<span class="fs-6 fw-semibold">Si-Fi Project by AU Themes</span>
																	<span class="fs-7 fw-semibold text-muted">#45670</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-frame fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<span class="fs-6 fw-semibold">Shopix Mobile App Planning</span>
																	<span class="fs-7 fw-semibold text-muted">#45690</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-message-text-2 fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<span class="fs-6 fw-semibold">Finance Monitoring SAAS Discussion</span>
																	<span class="fs-7 fw-semibold text-muted">#21090</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
															<!--begin::Item-->
															<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-profile-circle fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<span class="fs-6 fw-semibold">Dashboard Analitics Launch</span>
																	<span class="fs-7 fw-semibold text-muted">#34560</span>
																</div>
																<!--end::Title-->
															</a>
															<!--end::Item-->
														</div>
														<!--end::Items-->
													</div>
													<!--end::Recently viewed-->
													<!--begin::Recently viewed-->
													<div class="mb-5" data-kt-search-element="main">
														<!--begin::Heading-->
														<div class="d-flex flex-stack fw-semibold mb-4">
															<!--begin::Label-->
															<span class="text-muted fs-6 me-2">Recently Searched:</span>
															<!--end::Label-->
														</div>
														<!--end::Heading-->
														<!--begin::Items-->
														<div class="scroll-y mh-200px mh-lg-325px">
															<!--begin::Item-->
															<div class="d-flex align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-laptop fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">BoomApp by Keenthemes</a>
																	<span class="fs-7 text-muted fw-semibold">#45789</span>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="d-flex align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-chart-simple fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Kept API Project Meeting</a>
																	<span class="fs-7 text-muted fw-semibold">#84050</span>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="d-flex align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-chart fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"KPI Monitoring App Launch</a>
																	<span class="fs-7 text-muted fw-semibold">#84250</span>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="d-flex align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-chart-line-down fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">Project Reference FAQ</a>
																	<span class="fs-7 text-muted fw-semibold">#67945</span>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="d-flex align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-sms fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"FitPro App Development</a>
																	<span class="fs-7 text-muted fw-semibold">#84250</span>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="d-flex align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-bank fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">Shopix Mobile App</a>
																	<span class="fs-7 text-muted fw-semibold">#45690</span>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="d-flex align-items-center mb-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-40px me-4">
																	<span class="symbol-label bg-light">
																		<i class="ki-outline ki-chart-line-down fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="d-flex flex-column">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Landing UI Design" Launch</a>
																	<span class="fs-7 text-muted fw-semibold">#24005</span>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Item-->
														</div>
														<!--end::Items-->
													</div>
													<!--end::Recently viewed-->
													<!--begin::Empty-->
													<div data-kt-search-element="empty" class="text-center d-none">
														<!--begin::Icon-->
														<div class="pt-10 pb-10">
															<i class="ki-outline ki-search-list fs-4x opacity-50"></i>
														</div>
														<!--end::Icon-->
														<!--begin::Message-->
														<div class="pb-15 fw-semibold">
															<h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
															<div class="text-muted fs-7">Please try again with a different query</div>
														</div>
														<!--end::Message-->
													</div>
													<!--end::Empty-->
												</div>
												<!--end::Wrapper-->
												<!--begin::Preferences-->
												<form data-kt-search-element="advanced-options-form" class="pt-1 d-none">
													<!--begin::Heading-->
													<h3 class="fw-semibold text-dark mb-7">Advanced Search</h3>
													<!--end::Heading-->
													<!--begin::Input group-->
													<div class="mb-5">
														<input type="text" class="form-control form-control-sm form-control-solid" placeholder="Contains the word" name="query" />
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-5">
														<!--begin::Radio group-->
														<div class="nav-group nav-group-fluid">
															<!--begin::Option-->
															<label>
																<input type="radio" class="btn-check" name="type" value="has" checked="checked" />
																<span class="btn btn-sm btn-color-muted btn-active btn-active-primary">All</span>
															</label>
															<!--end::Option-->
															<!--begin::Option-->
															<label>
																<input type="radio" class="btn-check" name="type" value="users" />
																<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Users</span>
															</label>
															<!--end::Option-->
															<!--begin::Option-->
															<label>
																<input type="radio" class="btn-check" name="type" value="orders" />
																<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Orders</span>
															</label>
															<!--end::Option-->
															<!--begin::Option-->
															<label>
																<input type="radio" class="btn-check" name="type" value="projects" />
																<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Projects</span>
															</label>
															<!--end::Option-->
														</div>
														<!--end::Radio group-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-5">
														<input type="text" name="assignedto" class="form-control form-control-sm form-control-solid" placeholder="Assigned to" value="" />
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-5">
														<input type="text" name="collaborators" class="form-control form-control-sm form-control-solid" placeholder="Collaborators" value="" />
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-5">
														<!--begin::Radio group-->
														<div class="nav-group nav-group-fluid">
															<!--begin::Option-->
															<label>
																<input type="radio" class="btn-check" name="attachment" value="has" checked="checked" />
																<span class="btn btn-sm btn-color-muted btn-active btn-active-primary">Has attachment</span>
															</label>
															<!--end::Option-->
															<!--begin::Option-->
															<label>
																<input type="radio" class="btn-check" name="attachment" value="any" />
																<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Any</span>
															</label>
															<!--end::Option-->
														</div>
														<!--end::Radio group-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-5">
														<select name="timezone" aria-label="Select a Timezone" data-control="select2" data-dropdown-parent="#kt_header_search" data-placeholder="date_period" class="form-select form-select-sm form-select-solid">
															<option value="next">Within the next</option>
															<option value="last">Within the last</option>
															<option value="between">Between</option>
															<option value="on">On</option>
														</select>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-8">
														<!--begin::Col-->
														<div class="col-6">
															<input type="number" name="date_number" class="form-control form-control-sm form-control-solid" placeholder="Lenght" value="" />
														</div>
														<!--end::Col-->
														<!--begin::Col-->
														<div class="col-6">
															<select name="date_typer" aria-label="Select a Timezone" data-control="select2" data-dropdown-parent="#kt_header_search" data-placeholder="Period" class="form-select form-select-sm form-select-solid">
																<option value="days">Days</option>
																<option value="weeks">Weeks</option>
																<option value="months">Months</option>
																<option value="years">Years</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Actions-->
													<div class="d-flex justify-content-end">
														<button type="reset" class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2" data-kt-search-element="advanced-options-form-cancel">Cancel</button>
														<a href="pages/search/horizontal.html" class="btn btn-sm fw-bold btn-primary" data-kt-search-element="advanced-options-form-search">Search</a>
													</div>
													<!--end::Actions-->
												</form>
												<!--end::Preferences-->
												<!--begin::Preferences-->
												<form data-kt-search-element="preferences" class="pt-1 d-none">
													<!--begin::Heading-->
													<h3 class="fw-semibold text-dark mb-7">Search Preferences</h3>
													<!--end::Heading-->
													<!--begin::Input group-->
													<div class="pb-4 border-bottom">
														<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
															<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Projects</span>
															<input class="form-check-input" type="checkbox" value="1" checked="checked" />
														</label>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="py-4 border-bottom">
														<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
															<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Targets</span>
															<input class="form-check-input" type="checkbox" value="1" checked="checked" />
														</label>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="py-4 border-bottom">
														<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
															<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Affiliate Programs</span>
															<input class="form-check-input" type="checkbox" value="1" />
														</label>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="py-4 border-bottom">
														<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
															<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Referrals</span>
															<input class="form-check-input" type="checkbox" value="1" checked="checked" />
														</label>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="py-4 border-bottom">
														<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
															<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Users</span>
															<input class="form-check-input" type="checkbox" value="1" />
														</label>
													</div>
													<!--end::Input group-->
													<!--begin::Actions-->
													<div class="d-flex justify-content-end pt-7">
														<button type="reset" class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2" data-kt-search-element="preferences-dismiss">Cancel</button>
														<button type="submit" class="btn btn-sm fw-bold btn-primary">Save Changes</button>
													</div>
													<!--end::Actions-->
												</form>
												<!--end::Preferences-->
											</div>
											<!--end::Menu-->
										</div>
										<!--end::Search-->
									</div>
									<!--end::Search-->
									<!--begin::Activities-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Drawer toggle-->
										<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_activities_toggle">
											<i class="ki-outline ki-notification-bing fs-1"></i>
										</div>
										<!--end::Drawer toggle-->
									</div>
									<!--end::Activities-->
									<!--begin::Quick links-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Menu wrapper-->
										<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<i class="ki-outline ki-tablet-ok fs-1"></i>
										</div>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
											<!--begin::Heading-->
											<div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
												<!--begin::Title-->
												<h3 class="text-white fw-semibold mb-3">Quick Links</h3>
												<!--end::Title-->
												<!--begin::Status-->
												<span class="badge bg-primary text-inverse-primary py-2 px-3">25 pending tasks</span>
												<!--end::Status-->
											</div>
											<!--end::Heading-->
											<!--begin:Nav-->
											<div class="row g-0">
												<!--begin:Item-->
												<div class="col-6">
													<a href="apps/projects/budget.html" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
														<i class="ki-outline ki-dollar fs-3x text-primary mb-2"></i>
														<span class="fs-5 fw-semibold text-gray-800 mb-0">Accounting</span>
														<span class="fs-7 text-gray-400">eCommerce</span>
													</a>
												</div>
												<!--end:Item-->
												<!--begin:Item-->
												<div class="col-6">
													<a href="apps/projects/settings.html" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-bottom">
														<i class="ki-outline ki-sms fs-3x text-primary mb-2"></i>
														<span class="fs-5 fw-semibold text-gray-800 mb-0">Administration</span>
														<span class="fs-7 text-gray-400">Console</span>
													</a>
												</div>
												<!--end:Item-->
												<!--begin:Item-->
												<div class="col-6">
													<a href="apps/projects/list.html" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
														<i class="ki-outline ki-abstract-41 fs-3x text-primary mb-2"></i>
														<span class="fs-5 fw-semibold text-gray-800 mb-0">Projects</span>
														<span class="fs-7 text-gray-400">Pending Tasks</span>
													</a>
												</div>
												<!--end:Item-->
												<!--begin:Item-->
												<div class="col-6">
													<a href="apps/projects/users.html" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light">
														<i class="ki-outline ki-briefcase fs-3x text-primary mb-2"></i>
														<span class="fs-5 fw-semibold text-gray-800 mb-0">Customers</span>
														<span class="fs-7 text-gray-400">Latest cases</span>
													</a>
												</div>
												<!--end:Item-->
											</div>
											<!--end:Nav-->
											<!--begin::View more-->
											<div class="py-2 text-center border-top">
												<a href="pages/user-profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">View All
												<i class="ki-outline ki-arrow-right fs-5"></i></a>
											</div>
											<!--end::View more-->
										</div>
										<!--end::Menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::Quick links-->
									<!--begin::Chat-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Menu wrapper-->
										<div class="btn btn-icon btn-active-light-primary position-relative btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px pulse pulse-success" id="kt_drawer_chat_toggle">
											<i class="ki-outline ki-notification-2 fs-1"></i>
											<span class="pulse-ring w-45px h-45px"></span>
										</div>
										<!--end::Menu wrapper-->
									</div>
									<!--end::Chat-->
									<!--begin::Notifications-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Menu- wrapper-->
										<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px position-relative" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<i class="ki-outline ki-element-11 fs-1"></i>
										</div>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
											<!--begin::Heading-->
											<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
												<!--begin::Title-->
												<h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
												<span class="fs-8 opacity-75 ps-3">24 reports</span></h3>
												<!--end::Title-->
												<!--begin::Tabs-->
												<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
													<li class="nav-item">
														<a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alerts</a>
													</li>
													<li class="nav-item">
														<a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_2">Updates</a>
													</li>
													<li class="nav-item">
														<a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a>
													</li>
												</ul>
												<!--end::Tabs-->
											</div>
											<!--end::Heading-->
											<!--begin::Tab content-->
											<div class="tab-content">
												<!--begin::Tab panel-->
												<div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
													<!--begin::Items-->
													<div class="scroll-y mh-325px my-5 px-8">
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center">
																<!--begin::Symbol-->
																<div class="symbol symbol-35px me-4">
																	<span class="symbol-label bg-light-primary">
																		<i class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="mb-0 me-2">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Alice</a>
																	<div class="text-gray-400 fs-7">Phase 1 development</div>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">1 hr</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center">
																<!--begin::Symbol-->
																<div class="symbol symbol-35px me-4">
																	<span class="symbol-label bg-light-danger">
																		<i class="ki-outline ki-information fs-2 text-danger"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="mb-0 me-2">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">HR Confidential</a>
																	<div class="text-gray-400 fs-7">Confidential staff documents</div>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">2 hrs</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center">
																<!--begin::Symbol-->
																<div class="symbol symbol-35px me-4">
																	<span class="symbol-label bg-light-warning">
																		<i class="ki-outline ki-briefcase fs-2 text-warning"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="mb-0 me-2">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Company HR</a>
																	<div class="text-gray-400 fs-7">Corporeate staff profiles</div>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">5 hrs</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center">
																<!--begin::Symbol-->
																<div class="symbol symbol-35px me-4">
																	<span class="symbol-label bg-light-success">
																		<i class="ki-outline ki-abstract-12 fs-2 text-success"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="mb-0 me-2">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Redux</a>
																	<div class="text-gray-400 fs-7">New frontend admin theme</div>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">2 days</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center">
																<!--begin::Symbol-->
																<div class="symbol symbol-35px me-4">
																	<span class="symbol-label bg-light-primary">
																		<i class="ki-outline ki-colors-square fs-2 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="mb-0 me-2">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Breafing</a>
																	<div class="text-gray-400 fs-7">Product launch status update</div>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">21 Jan</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center">
																<!--begin::Symbol-->
																<div class="symbol symbol-35px me-4">
																	<span class="symbol-label bg-light-info">
																		<i class="ki-outline ki-picture fs-2 text-info"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="mb-0 me-2">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Banner Assets</a>
																	<div class="text-gray-400 fs-7">Collection of banner images</div>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">21 Jan</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center">
																<!--begin::Symbol-->
																<div class="symbol symbol-35px me-4">
																	<span class="symbol-label bg-light-warning">
																		<i class="ki-outline ki-color-swatch fs-2 text-warning"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Title-->
																<div class="mb-0 me-2">
																	<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Icon Assets</a>
																	<div class="text-gray-400 fs-7">Collection of SVG icons</div>
																</div>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">20 March</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Items-->
													<!--begin::View more-->
													<div class="py-3 text-center border-top">
														<a href="pages/user-profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">View All
														<i class="ki-outline ki-arrow-right fs-5"></i></a>
													</div>
													<!--end::View more-->
												</div>
												<!--end::Tab panel-->
												<!--begin::Tab panel-->
												<div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
													<!--begin::Wrapper-->
													<div class="d-flex flex-column px-9">
														<!--begin::Section-->
														<div class="pt-10 pb-0">
															<!--begin::Title-->
															<h3 class="text-dark text-center fw-bold">Get Pro Access</h3>
															<!--end::Title-->
															<!--begin::Text-->
															<div class="text-center text-gray-600 fw-semibold pt-1">Outlines keep you honest. They stoping you from amazing poorly about drive</div>
															<!--end::Text-->
															<!--begin::Action-->
															<div class="text-center mt-5 mb-9">
																<a href="#" class="btn btn-sm btn-primary px-6" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">Upgrade</a>
															</div>
															<!--end::Action-->
														</div>
														<!--end::Section-->
														<!--begin::Illustration-->
														<div class="text-center px-4">
															<img class="mw-100 mh-200px" alt="image" src="assets/media/illustrations/sketchy-1/1.png" />
														</div>
														<!--end::Illustration-->
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Tab panel-->
												<!--begin::Tab panel-->
												<div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
													<!--begin::Items-->
													<div class="scroll-y mh-325px my-5 px-8">
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-success me-4">200 OK</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">New order</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">Just now</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-danger me-4">500 ERR</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">New customer</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">2 hrs</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-success me-4">200 OK</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">Payment process</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">5 hrs</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-warning me-4">300 WRN</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">Search query</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">2 days</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-success me-4">200 OK</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">API connection</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">1 week</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-success me-4">200 OK</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">Database restore</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">Mar 5</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-warning me-4">300 WRN</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">System update</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">May 15</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-warning me-4">300 WRN</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">Server OS update</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">Apr 3</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-warning me-4">300 WRN</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">API rollback</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">Jun 30</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-danger me-4">500 ERR</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">Refund process</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">Jul 10</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-danger me-4">500 ERR</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">Withdrawal process</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">Sep 10</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex flex-stack py-4">
															<!--begin::Section-->
															<div class="d-flex align-items-center me-2">
																<!--begin::Code-->
																<span class="w-70px badge badge-light-danger me-4">500 ERR</span>
																<!--end::Code-->
																<!--begin::Title-->
																<a href="#" class="text-gray-800 text-hover-primary fw-semibold">Mail tasks</a>
																<!--end::Title-->
															</div>
															<!--end::Section-->
															<!--begin::Label-->
															<span class="badge badge-light fs-8">Dec 10</span>
															<!--end::Label-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Items-->
													<!--begin::View more-->
													<div class="py-3 text-center border-top">
														<a href="pages/user-profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">View All
														<i class="ki-outline ki-arrow-right fs-5"></i></a>
													</div>
													<!--end::View more-->
												</div>
												<!--end::Tab panel-->
											</div>
											<!--end::Tab content-->
										</div>
										<!--end::Menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::Notifications-->
									<!--begin::Theme mode-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Menu toggle-->
										<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<i class="ki-outline ki-night-day theme-light-show fs-1"></i>
											<i class="ki-outline ki-moon theme-dark-show fs-1"></i>
										</a>
										<!--begin::Menu toggle-->
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-night-day fs-2"></i>
													</span>
													<span class="menu-title">Light</span>
												</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-moon fs-2"></i>
													</span>
													<span class="menu-title">Dark</span>
												</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-screen fs-2"></i>
													</span>
													<span class="menu-title">System</span>
												</a>
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Theme mode-->
									<!--begin::User menu-->
									<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
										<!--begin::Menu wrapper-->
										<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<img src="assets/media/avatars/300-1.jpg" alt="image" />
										</div>
										<!--begin::User account menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<div class="menu-content d-flex align-items-center px-3">
													<!--begin::Avatar-->
													<div class="symbol symbol-50px me-5">
														<img alt="Logo" src="assets/media/avatars/300-1.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Username-->
													<div class="d-flex flex-column">
														<div class="fw-bold d-flex align-items-center fs-5"> {{ Session::get('name')}}
														<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ Str::ucfirst(Session::get('type'))}}</span></div>
														<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Session::get('email')}}</a>
													</div>
													<!--end::Username-->
												</div>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="account/overview.html" class="menu-link px-5">My Profile</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="apps/projects/list.html" class="menu-link px-5">
													<span class="menu-text">My Projects</span>
													<span class="menu-badge">
														<span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
													</span>
												</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
												<a href="#" class="menu-link px-5">
													<span class="menu-title">My Subscription</span>
													<span class="menu-arrow"></span>
												</a>
												<!--begin::Menu sub-->
												<div class="menu-sub menu-sub-dropdown w-175px py-4">
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="account/referrals.html" class="menu-link px-5">Referrals</a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="account/billing.html" class="menu-link px-5">Billing</a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="account/statements.html" class="menu-link px-5">Payments</a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="account/statements.html" class="menu-link d-flex flex-stack px-5">Statements
														<span class="ms-2 lh-0" data-bs-toggle="tooltip" title="View your statements">
															<i class="ki-outline ki-information-5 fs-5"></i>
														</span></a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu separator-->
													<div class="separator my-2"></div>
													<!--end::Menu separator-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<div class="menu-content px-3">
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
																<span class="form-check-label text-muted fs-7">Notifications</span>
															</label>
														</div>
													</div>
													<!--end::Menu item-->
												</div>
												<!--end::Menu sub-->
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="account/statements.html" class="menu-link px-5">My Statements</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->
											<!--begin::Menu item-->
											<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
												<a href="#" class="menu-link px-5">
													<span class="menu-title position-relative">Language
													<span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">{{ $translator("Swahili", "Kiswahili") }}
													<img class="w-15px h-15px rounded-1 ms-2" src="assets/media/flags/{{ Session::get('lang', 1) == 1 ? 'united-states.svg':'tanzania.svg' }}" alt="" /></span></span>
												</a>
												<!--begin::Menu sub-->
												<div class="menu-sub menu-sub-dropdown w-175px py-4">
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a data-kt-lang="English" href="#" class="menu-link d-flex px-5 active">
														<span class="symbol symbol-20px me-4">
															<img class="rounded-1" src="assets/media/flags/united-states.svg" alt="" />
														</span>English</a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a data-kt-lang="Swahili" href="#" class="menu-link d-flex px-5">
														<span class="symbol symbol-20px me-4">
															<img class="rounded-1" src="assets/media/flags/tanzania.svg" alt="" />
														</span>Swahili</a>
													</div>
													<!--end::Menu item-->
													
												</div>
												<!--end::Menu sub-->
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5 my-1">
												<a href="account/settings.html" class="menu-link px-5">Account Settings</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="logout" class="menu-link px-5">Sign Out</a>
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::User account menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::User menu-->
									<!--begin::Heaeder menu toggle-->
									<div class="d-flex align-items-center d-lg-none ms-2 me-n2" title="Show header menu">
										<div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
											<i class="ki-outline ki-burger-menu-2 fs-1"></i>
										</div>
									</div>
									<!--end::Heaeder menu toggle-->
								</div>
								<!--end::Toolbar wrapper-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					 
					