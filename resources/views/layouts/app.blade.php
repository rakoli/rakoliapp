<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <base href="../../" />
    <title>RAKOLI DASHBOARD</title>
    <meta charset="utf-8" />
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="The mos" />
    <meta name="keywords"  content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
    <div id="app">
        <script>
            var defaultThemeMode = "light";
            var themeMode;
            if (document.documentElement) {
                if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if (localStorage.getItem("data-bs-theme") !== null) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else {
                        themeMode = defaultThemeMode;
                    }
                }
                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }
                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <div id="kt_aside" class="aside overflow-visible pb-5 pt-5 pt-lg-0" data-kt-drawer="true"
                    data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}"
                    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80px', '300px': '100px'}"
                    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
                    <div class="aside-logo py-8" id="kt_aside_logo">
                        <a href="index.html" class="d-flex align-items-center">
                            <img alt="Logo" src="favicon.ico" class="h-45px logo" />
                        </a>
                    </div>
                    <div class="aside-menu flex-column-fluid" id="kt_aside_menu">
                        <div class="hover-scroll-y my-2 my-lg-5 scroll-ms" id="kt_aside_menu_wrapper"
                            data-kt-scroll="true" data-kt-scroll-height="auto"
                            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
                            data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
                            <div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold"
                                id="#kt_aside_menu" data-kt-menu="true">
                                @if (session('type') == 'admin')
                                    @include('menus.admin')
                                @elseif(session('type') == 'vas')
                                    @include('menus.vas')
                                @elseif(session('type') == 'agent')
                                    @include('menus.agent')
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <div id="kt_header" style="" class="header align-items-stretch">
                        <div class="container-fluid d-flex align-items-stretch justify-content-between">
                            <div class="d-flex align-items-center d-lg-none ms-n1 me-2" title="Show aside menu">
                                <div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                                    id="kt_aside_mobile_toggle">
                                    <i class="ki-outline ki-abstract-14 fs-1"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                                <a href="index.html" class="d-lg-none">
                                    <img alt="Logo" src="assets/media/logos/demo6.svg" class="h-25px" />
                                </a>
                            </div>
                            <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                                <div class="d-flex align-items-stretch" id="kt_header_nav">
                                    <div class="header-menu align-items-stretch" data-kt-drawer="true"
                                        data-kt-drawer-name="header-menu"
                                        data-kt-drawer-activate="{default: true, lg: false}"
                                        data-kt-drawer-overlay="true"
                                        data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                                        data-kt-drawer-direction="end"
                                        data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                                        data-kt-swapper-mode="prepend"
                                        data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                        <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-state-primary menu-title-gray-700 menu-arrow-gray-400 fw-semibold my-5 my-lg-0 px-2 px-lg-0 align-items-stretch"
                                            id="#kt_header_menu" data-kt-menu="true">
                                            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                data-kt-menu-placement="bottom-start"
                                                class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                                <span class="menu-link py-3">
                                                    <span class="menu-title">Dashboard</span>
                                                    <span class="menu-arrow d-lg-none"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-stretch flex-shrink-0">
                                    <div class="d-flex align-items-stretch ms-1 ms-lg-3">
                                        <div id="kt_header_search" class="header-search d-flex align-items-stretch"
                                            data-kt-search-keypress="true" data-kt-search-min-length="2"
                                            data-kt-search-enter="enter" data-kt-search-layout="menu"
                                            data-kt-menu-trigger="auto" data-kt-menu-overflow="false"
                                            data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                                            <div class="d-flex align-items-center" data-kt-search-element="toggle"
                                                id="kt_header_search_toggle">
                                                <div
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px">
                                                    <i class="ki-outline ki-magnifier fs-1"></i>
                                                </div>
                                            </div>
                                            <div data-kt-search-element="content"
                                                class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
                                                <div data-kt-search-element="wrapper">
                                                    <form data-kt-search-element="form"
                                                        class="w-100 position-relative mb-3" autocomplete="off">
                                                        <i
                                                            class="ki-outline ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-0"></i>
                                                        <input type="text"
                                                            class="search-input form-control form-control-flush ps-10"
                                                            name="search" value="" placeholder="Search..."
                                                            data-kt-search-element="input" />
                                                        <span
                                                            class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1"
                                                            data-kt-search-element="spinner">
                                                            <span
                                                                class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                                                        </span>
                                                        <span
                                                            class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none"
                                                            data-kt-search-element="clear">
                                                            <i class="ki-outline ki-cross fs-2 fs-lg-1 me-0"></i>
                                                        </span>
                                                        <div class="position-absolute top-50 end-0 translate-middle-y"
                                                            data-kt-search-element="toolbar">
                                                            <div data-kt-search-element="preferences-show"
                                                                class="btn btn-icon w-20px btn-sm btn-active-color-primary me-1"
                                                                data-bs-toggle="tooltip"
                                                                title="Show search preferences">
                                                                <i class="ki-outline ki-setting-2 fs-2"></i>
                                                            </div>
                                                            <div data-kt-search-element="advanced-options-form-show"
                                                                class="btn btn-icon w-20px btn-sm btn-active-color-primary"
                                                                data-bs-toggle="tooltip"
                                                                title="Show more search options">
                                                                <i class="ki-outline ki-down fs-2"></i>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="separator border-gray-200 mb-6"></div>
                                                    <div data-kt-search-element="results" class="d-none">
                                                        <div class="scroll-y mh-200px mh-lg-350px">
                                                            <h3 class="fs-5 text-muted m-0 pb-5"
                                                                data-kt-search-element="category-title">Users</h3>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="assets/media/avatars/300-6.jpg"
                                                                        alt="" />
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Karina Clark</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Marketing
                                                                        Manager</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="assets/media/avatars/300-2.jpg"
                                                                        alt="" />
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Olivia Bold</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Software
                                                                        Engineer</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="assets/media/avatars/300-9.jpg"
                                                                        alt="" />
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Ana Clark</span>
                                                                    <span class="fs-7 fw-semibold text-muted">UI/UX
                                                                        Designer</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="assets/media/avatars/300-14.jpg"
                                                                        alt="" />
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Nick Pitola</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Art
                                                                        Director</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="assets/media/avatars/300-11.jpg"
                                                                        alt="" />
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Edward Kulnic</span>
                                                                    <span class="fs-7 fw-semibold text-muted">System
                                                                        Administrator</span>
                                                                </div>
                                                            </a>
                                                            <h3 class="fs-5 text-muted m-0 pt-5 pb-5"
                                                                data-kt-search-element="category-title">Customers</h3>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="assets/media/svg/brand-logos/volicity-9.svg"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Company
                                                                        Rbranding</span>
                                                                    <span class="fs-7 fw-semibold text-muted">UI
                                                                        Design</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="assets/media/svg/brand-logos/tvit.svg"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Company
                                                                        Re-branding</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Web
                                                                        Development</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="assets/media/svg/misc/infography.svg"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Business Analytics
                                                                        App</span>
                                                                    <span
                                                                        class="fs-7 fw-semibold text-muted">Administration</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="assets/media/svg/brand-logos/leaf.svg"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">EcoLeaf App
                                                                        Launch</span>
                                                                    <span
                                                                        class="fs-7 fw-semibold text-muted">Marketing</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="assets/media/svg/brand-logos/tower.svg"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Tower Group
                                                                        Website</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Google
                                                                        Adwords</span>
                                                                </div>
                                                            </a>
                                                            <h3 class="fs-5 text-muted m-0 pt-5 pb-5"
                                                                data-kt-search-element="category-title">Projects</h3>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-notepad fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <span class="fs-6 fw-semibold">Si-Fi Project by AU
                                                                        Themes</span>
                                                                    <span
                                                                        class="fs-7 fw-semibold text-muted">#45670</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-frame fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <span class="fs-6 fw-semibold">Shopix Mobile App
                                                                        Planning</span>
                                                                    <span
                                                                        class="fs-7 fw-semibold text-muted">#45690</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-message-text-2 fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <span class="fs-6 fw-semibold">Finance Monitoring
                                                                        SAAS Discussion</span>
                                                                    <span
                                                                        class="fs-7 fw-semibold text-muted">#21090</span>
                                                                </div>
                                                            </a>
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-profile-circle fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <span class="fs-6 fw-semibold">Dashboard Analitics
                                                                        Launch</span>
                                                                    <span
                                                                        class="fs-7 fw-semibold text-muted">#34560</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="mb-5" data-kt-search-element="main">
                                                        <div class="d-flex flex-stack fw-semibold mb-4">
                                                            <span class="text-muted fs-6 me-2">Recently
                                                                Searched:</span>
                                                        </div>
                                                        <div class="scroll-y mh-200px mh-lg-325px">
                                                            <div class="d-flex align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-laptop fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">BoomApp
                                                                        by Keenthemes</a>
                                                                    <span
                                                                        class="fs-7 text-muted fw-semibold">#45789</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-chart-simple fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Kept
                                                                        API Project Meeting</a>
                                                                    <span
                                                                        class="fs-7 text-muted fw-semibold">#84050</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-chart fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">"KPI
                                                                        Monitoring App Launch</a>
                                                                    <span
                                                                        class="fs-7 text-muted fw-semibold">#84250</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-chart-line-down fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">Project
                                                                        Reference FAQ</a>
                                                                    <span
                                                                        class="fs-7 text-muted fw-semibold">#67945</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-sms fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">"FitPro
                                                                        App Development</a>
                                                                    <span
                                                                        class="fs-7 text-muted fw-semibold">#84250</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-bank fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">Shopix
                                                                        Mobile App</a>
                                                                    <span
                                                                        class="fs-7 text-muted fw-semibold">#45690</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-5">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-outline ki-chart-line-down fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Landing
                                                                        UI Design" Launch</a>
                                                                    <span
                                                                        class="fs-7 text-muted fw-semibold">#24005</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div data-kt-search-element="empty" class="text-center d-none">
                                                        <div class="pt-10 pb-10">
                                                            <i class="ki-outline ki-search-list fs-4x opacity-50"></i>
                                                        </div>
                                                        <div class="pb-15 fw-semibold">
                                                            <h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
                                                            <div class="text-muted fs-7">Please try again with a
                                                                different query</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form data-kt-search-element="advanced-options-form"
                                                    class="pt-1 d-none">
                                                    <h3 class="fw-semibold text-dark mb-7">Advanced Search</h3>
                                                    <div class="mb-5">
                                                        <input type="text"
                                                            class="form-control form-control-sm form-control-solid"
                                                            placeholder="Contains the word" name="query" />
                                                    </div>
                                                    <div class="mb-5">
                                                        <div class="nav-group nav-group-fluid">
                                                            <label>
                                                                <input type="radio" class="btn-check"
                                                                    name="type" value="has"
                                                                    checked="checked" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary">All</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" class="btn-check"
                                                                    name="type" value="users" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Users</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" class="btn-check"
                                                                    name="type" value="orders" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Orders</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" class="btn-check"
                                                                    name="type" value="projects" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Projects</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-5">
                                                        <input type="text" name="assignedto"
                                                            class="form-control form-control-sm form-control-solid"
                                                            placeholder="Assigned to" value="" />
                                                    </div>
                                                    <div class="mb-5">
                                                        <input type="text" name="collaborators"
                                                            class="form-control form-control-sm form-control-solid"
                                                            placeholder="Collaborators" value="" />
                                                    </div>
                                                    <div class="mb-5">
                                                        <div class="nav-group nav-group-fluid">
                                                            <label>
                                                                <input type="radio" class="btn-check"
                                                                    name="attachment" value="has"
                                                                    checked="checked" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary">Has
                                                                    attachment</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" class="btn-check"
                                                                    name="attachment" value="any" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Any</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-5">
                                                        <select name="timezone" aria-label="Select a Timezone"
                                                            data-control="select2"
                                                            data-dropdown-parent="#kt_header_search"
                                                            data-placeholder="date_period"
                                                            class="form-select form-select-sm form-select-solid">
                                                            <option value="next">Within the next</option>
                                                            <option value="last">Within the last</option>
                                                            <option value="between">Between</option>
                                                            <option value="on">On</option>
                                                        </select>
                                                    </div>
                                                    <div class="row mb-8">
                                                        <div class="col-6">
                                                            <input type="number" name="date_number"
                                                                class="form-control form-control-sm form-control-solid"
                                                                placeholder="Lenght" value="" />
                                                        </div>
                                                        <div class="col-6">
                                                            <select name="date_typer" aria-label="Select a Timezone"
                                                                data-control="select2"
                                                                data-dropdown-parent="#kt_header_search"
                                                                data-placeholder="Period"
                                                                class="form-select form-select-sm form-select-solid">
                                                                <option value="days">Days</option>
                                                                <option value="weeks">Weeks</option>
                                                                <option value="months">Months</option>
                                                                <option value="years">Years</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="reset"
                                                            class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2"
                                                            data-kt-search-element="advanced-options-form-cancel">Cancel</button>
                                                        <a href="pages/search/horizontal.html"
                                                            class="btn btn-sm fw-bold btn-primary"
                                                            data-kt-search-element="advanced-options-form-search">Search</a>
                                                    </div>
                                                </form>
                                                <form data-kt-search-element="preferences" class="pt-1 d-none">
                                                    <h3 class="fw-semibold text-dark mb-7">Search Preferences</h3>
                                                    <div class="pb-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Projects</span>
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" checked="checked" />
                                                        </label>
                                                    </div>
                                                    <div class="py-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Targets</span>
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" checked="checked" />
                                                        </label>
                                                    </div>
                                                    <div class="py-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Affiliate
                                                                Programs</span>
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" />
                                                        </label>
                                                    </div>
                                                    <div class="py-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Referrals</span>
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" checked="checked" />
                                                        </label>
                                                    </div>
                                                    <div class="py-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Users</span>
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" />
                                                        </label>
                                                    </div>
                                                    <div class="d-flex justify-content-end pt-7">
                                                        <button type="reset"
                                                            class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2"
                                                            data-kt-search-element="preferences-dismiss">Cancel</button>
                                                        <button type="submit"
                                                            class="btn btn-sm fw-bold btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                                        <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                                            id="kt_activities_toggle">
                                            <i class="ki-outline ki-notification-bing fs-1"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                                        <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                            data-kt-menu-placement="bottom-end">
                                            <i class="ki-outline ki-tablet-ok fs-1"></i>
                                        </div>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px"
                                            data-kt-menu="true">
                                            <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10"
                                                style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                                                <h3 class="text-white fw-semibold mb-3">Quick Links</h3>
                                                <span class="badge bg-primary text-inverse-primary py-2 px-3">25
                                                    pending tasks</span>
                                            </div>
                                            <div class="row g-0">
                                                <div class="col-6">
                                                    <a href="apps/projects/budget.html"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                                        <i class="ki-outline ki-dollar fs-3x text-primary mb-2"></i>
                                                        <span
                                                            class="fs-5 fw-semibold text-gray-800 mb-0">Accounting</span>
                                                        <span class="fs-7 text-gray-400">eCommerce</span>
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="apps/projects/settings.html"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-bottom">
                                                        <i class="ki-outline ki-sms fs-3x text-primary mb-2"></i>
                                                        <span
                                                            class="fs-5 fw-semibold text-gray-800 mb-0">Administration</span>
                                                        <span class="fs-7 text-gray-400">Console</span>
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="apps/projects/list.html"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
                                                        <i
                                                            class="ki-outline ki-abstract-41 fs-3x text-primary mb-2"></i>
                                                        <span
                                                            class="fs-5 fw-semibold text-gray-800 mb-0">Projects</span>
                                                        <span class="fs-7 text-gray-400">Pending Tasks</span>
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="apps/projects/users.html"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light">
                                                        <i class="ki-outline ki-briefcase fs-3x text-primary mb-2"></i>
                                                        <span
                                                            class="fs-5 fw-semibold text-gray-800 mb-0">Customers</span>
                                                        <span class="fs-7 text-gray-400">Latest cases</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="py-2 text-center border-top">
                                                <a href="pages/user-profile/activity.html"
                                                    class="btn btn-color-gray-600 btn-active-color-primary">View All
                                                    <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                                        <div class="btn btn-icon btn-active-light-primary position-relative btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px pulse pulse-success"
                                            id="kt_drawer_chat_toggle">
                                            <i class="ki-outline ki-notification-2 fs-1"></i>
                                            <span class="pulse-ring w-45px h-45px"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                                        <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px position-relative"
                                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                            data-kt-menu-placement="bottom-end">
                                            <i class="ki-outline ki-element-11 fs-1"></i>
                                        </div>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
                                            data-kt-menu="true" id="kt_menu_notifications">
                                            <div class="d-flex flex-column bgi-no-repeat rounded-top"
                                                style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                                                <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
                                                    <span class="fs-8 opacity-75 ps-3">24 reports</span>
                                                </h3>
                                                <ul
                                                    class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                                                    <li class="nav-item">
                                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
                                                            data-bs-toggle="tab"
                                                            href="#kt_topbar_notifications_1">Alerts</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                                                            data-bs-toggle="tab"
                                                            href="#kt_topbar_notifications_2">Updates</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
                                                            data-bs-toggle="tab"
                                                            href="#kt_topbar_notifications_3">Logs</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade" id="kt_topbar_notifications_1"
                                                    role="tabpanel">
                                                    <div class="scroll-y mh-325px my-5 px-8">
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-35px me-4">
                                                                    <span class="symbol-label bg-light-primary">
                                                                        <i
                                                                            class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="mb-0 me-2">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">Project
                                                                        Alice</a>
                                                                    <div class="text-gray-400 fs-7">Phase 1 development
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light fs-8">1 hr</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-35px me-4">
                                                                    <span class="symbol-label bg-light-danger">
                                                                        <i
                                                                            class="ki-outline ki-information fs-2 text-danger"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="mb-0 me-2">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">HR
                                                                        Confidential</a>
                                                                    <div class="text-gray-400 fs-7">Confidential staff
                                                                        documents</div>
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light fs-8">2 hrs</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-35px me-4">
                                                                    <span class="symbol-label bg-light-warning">
                                                                        <i
                                                                            class="ki-outline ki-briefcase fs-2 text-warning"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="mb-0 me-2">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">Company
                                                                        HR</a>
                                                                    <div class="text-gray-400 fs-7">Corporeate staff
                                                                        profiles</div>
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light fs-8">5 hrs</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-35px me-4">
                                                                    <span class="symbol-label bg-light-success">
                                                                        <i
                                                                            class="ki-outline ki-abstract-12 fs-2 text-success"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="mb-0 me-2">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">Project
                                                                        Redux</a>
                                                                    <div class="text-gray-400 fs-7">New frontend admin
                                                                        theme</div>
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light fs-8">2 days</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-35px me-4">
                                                                    <span class="symbol-label bg-light-primary">
                                                                        <i
                                                                            class="ki-outline ki-colors-square fs-2 text-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="mb-0 me-2">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">Project
                                                                        Breafing</a>
                                                                    <div class="text-gray-400 fs-7">Product launch
                                                                        status update</div>
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light fs-8">21 Jan</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-35px me-4">
                                                                    <span class="symbol-label bg-light-info">
                                                                        <i
                                                                            class="ki-outline ki-picture fs-2 text-info"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="mb-0 me-2">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">Banner
                                                                        Assets</a>
                                                                    <div class="text-gray-400 fs-7">Collection of
                                                                        banner images</div>
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light fs-8">21 Jan</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-35px me-4">
                                                                    <span class="symbol-label bg-light-warning">
                                                                        <i
                                                                            class="ki-outline ki-color-swatch fs-2 text-warning"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="mb-0 me-2">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">Icon
                                                                        Assets</a>
                                                                    <div class="text-gray-400 fs-7">Collection of SVG
                                                                        icons</div>
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light fs-8">20 March</span>
                                                        </div>
                                                    </div>
                                                    <div class="py-3 text-center border-top">
                                                        <a href="pages/user-profile/activity.html"
                                                            class="btn btn-color-gray-600 btn-active-color-primary">View
                                                            All
                                                            <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade show active" id="kt_topbar_notifications_2"
                                                    role="tabpanel">
                                                    <div class="d-flex flex-column px-9">
                                                        <div class="pt-10 pb-0">
                                                            <h3 class="text-dark text-center fw-bold">Get Pro Access
                                                            </h3>
                                                            <div class="text-center text-gray-600 fw-semibold pt-1">
                                                                Outlines keep you honest. They stoping you from amazing
                                                                poorly about drive</div>
                                                            <div class="text-center mt-5 mb-9">
                                                                <a href="#" class="btn btn-sm btn-primary px-6"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_upgrade_plan">Upgrade</a>
                                                            </div>
                                                        </div>
                                                        <div class="text-center px-4">
                                                            <img class="mw-100 mh-200px" alt="image"
                                                                src="assets/media/illustrations/sketchy-1/1.png" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="kt_topbar_notifications_3"
                                                    role="tabpanel">
                                                    <div class="scroll-y mh-325px my-5 px-8">
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-success me-4">200
                                                                    OK</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">New
                                                                    order</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">Just now</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-danger me-4">500
                                                                    ERR</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">New
                                                                    customer</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">2 hrs</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-success me-4">200
                                                                    OK</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">Payment
                                                                    process</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">5 hrs</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-warning me-4">300
                                                                    WRN</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">Search
                                                                    query</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">2 days</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-success me-4">200
                                                                    OK</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">API
                                                                    connection</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">1 week</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-success me-4">200
                                                                    OK</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">Database
                                                                    restore</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">Mar 5</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-warning me-4">300
                                                                    WRN</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">System
                                                                    update</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">May 15</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-warning me-4">300
                                                                    WRN</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">Server
                                                                    OS update</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">Apr 3</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-warning me-4">300
                                                                    WRN</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">API
                                                                    rollback</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">Jun 30</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-danger me-4">500
                                                                    ERR</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">Refund
                                                                    process</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">Jul 10</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-danger me-4">500
                                                                    ERR</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">Withdrawal
                                                                    process</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">Sep 10</span>
                                                        </div>
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-danger me-4">500
                                                                    ERR</span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary fw-semibold">Mail
                                                                    tasks</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">Dec 10</span>
                                                        </div>
                                                    </div>
                                                    <div class="py-3 text-center border-top">
                                                        <a href="pages/user-profile/activity.html"
                                                            class="btn btn-color-gray-600 btn-active-color-primary">View
                                                            All
                                                            <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                                        <a href="#"
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                                            data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                                            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                            <i class="ki-outline ki-night-day theme-light-show fs-1"></i>
                                            <i class="ki-outline ki-moon theme-dark-show fs-1"></i>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                            data-kt-menu="true" data-kt-element="theme-mode-menu">
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                    data-kt-value="light">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <i class="ki-outline ki-night-day fs-2"></i>
                                                    </span>
                                                    <span class="menu-title">Light</span>
                                                </a>
                                            </div>
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                    data-kt-value="dark">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <i class="ki-outline ki-moon fs-2"></i>
                                                    </span>
                                                    <span class="menu-title">Dark</span>
                                                </a>
                                            </div>
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                    data-kt-value="system">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <i class="ki-outline ki-screen fs-2"></i>
                                                    </span>
                                                    <span class="menu-title">System</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-1 ms-lg-3"
                                        id="kt_header_user_menu_toggle">
                                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                            data-kt-menu-placement="bottom-end">
                                            <img src="assets/media/avatars/300-1.jpg" alt="image" />
                                        </div>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <div class="symbol symbol-50px me-5">
                                                        <img alt="Logo" src="assets/media/avatars/300-1.jpg" />
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bold d-flex align-items-center fs-5">
                                                            {{ Session::get('name') }}
                                                            <span
                                                                class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ Str::ucfirst(Session::get('type')) }}</span>
                                                        </div>
                                                        <a href="#"
                                                            class="fw-semibold text-muted text-hover-primary fs-7">{{ Session::get('email') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="separator my-2"></div>
                                            <div class="menu-item px-5">
                                                <a href="account/overview.html" class="menu-link px-5">My Profile</a>
                                            </div>
                                            <div class="menu-item px-5">
                                                <a href="apps/projects/list.html" class="menu-link px-5">
                                                    <span class="menu-text">My Projects</span>
                                                    <span class="menu-badge">
                                                        <span
                                                            class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="menu-item px-5"
                                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-title">My Subscription</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <div class="menu-item px-3">
                                                        <a href="account/referrals.html"
                                                            class="menu-link px-5">Referrals</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="account/billing.html"
                                                            class="menu-link px-5">Billing</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="account/statements.html"
                                                            class="menu-link px-5">Payments</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="account/statements.html"
                                                            class="menu-link d-flex flex-stack px-5">Statements
                                                            <span class="ms-2 lh-0" data-bs-toggle="tooltip"
                                                                title="View your statements">
                                                                <i class="ki-outline ki-information-5 fs-5"></i>
                                                            </span></a>
                                                    </div>
                                                    <div class="separator my-2"></div>
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content px-3">
                                                            <label
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input w-30px h-20px"
                                                                    type="checkbox" value="1" checked="checked"
                                                                    name="notifications" />
                                                                <span
                                                                    class="form-check-label text-muted fs-7">Notifications</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="menu-item px-5">
                                                <a href="account/statements.html" class="menu-link px-5">My
                                                    Statements</a>
                                            </div>
                                            <div class="separator my-2"></div>
                                            <div class="menu-item px-5"
                                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-title position-relative">Language
                                                        <span
                                                            class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">{{ $translator('Swahili', 'Kiswahili') }}
                                                            <img class="w-15px h-15px rounded-1 ms-2"
                                                                src="assets/media/flags/{{ Session::get('lang', 1) == 1 ? 'united-states.svg' : 'tanzania.svg' }}"
                                                                alt="" /></span></span>
                                                </a>
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <div class="menu-item px-3">
                                                        <a data-kt-lang="English" href="#"
                                                            class="menu-link d-flex px-5 active">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="assets/media/flags/united-states.svg"
                                                                    alt="" />
                                                            </span>English</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a data-kt-lang="Swahili" href="#"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="assets/media/flags/tanzania.svg"
                                                                    alt="" />
                                                            </span>Swahili</a>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="menu-item px-5 my-1">
                                                <a href="account/settings.html" class="menu-link px-5">Account
                                                    Settings</a>
                                            </div>
                                            <div class="menu-item px-5">
                                                <form id="logout-form" action="{{ url('logout') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <button style="width: 100%" class="menu-link px-5"
                                                        type="submit">Sign Out</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center d-lg-none ms-2 me-n2"
                                        title="Show header menu">
                                        <div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                                            id="kt_header_menu_mobile_toggle">
                                            <i class="ki-outline ki-burger-menu-2 fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <main class="py-4">
                        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                            <div id="kt_content_container" class="container-xxl">

                                @yield('content')

                            </div>
                        </div>
                    </main>


                    <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                        <div
                            class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">2023&copy;</span>
                                <a href="https://keenthemes.com" target="_blank"
                                    class="text-gray-800 text-hover-primary">Keenthemes</a>
                            </div>
                            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                <li class="menu-item">
                                    <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                                </li>
                                <li class="menu-item">
                                    <a href="https://devs.keenthemes.com" target="_blank"
                                        class="menu-link px-2">Support</a>
                                </li>
                                <li class="menu-item">
                                    <a href="https://1.envato.market/EA4JP" target="_blank"
                                        class="menu-link px-2">Purchase</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_activities" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
        data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'300px', 'lg': '900px'}" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_activities_toggle" data-kt-drawer-close="#kt_activities_close">
        <div class="card shadow-none border-0 rounded-0">
            <div class="card-header" id="kt_activities_header">
                <h3 class="card-title fw-bold text-dark">Activity Logs</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                        id="kt_activities_close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
            </div>
            <div class="card-body position-relative" id="kt_activities_body">
                <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
                    data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                    data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                    data-kt-scroll-offset="5px">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                <div class="symbol-label bg-light">
                                    <i class="ki-outline ki-message-text-2 fs-2 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="fs-5 fw-semibold mb-2">There are 2 new tasks for you in “AirPlus Mobile
                                        App” project:</div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7">Added at 4:23 PM by</div>
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="Nina Nilson">
                                            <img src="assets/media/avatars/300-14.jpg" alt="img" />
                                        </div>
                                    </div>
                                </div>
                                <div class="overflow-auto pb-5">
                                    <div
                                        class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
                                        <a href="../../demo6/dist/apps/projects/project.html"
                                            class="fs-5 text-dark text-hover-primary fw-semibold w-375px min-w-200px">Meeting
                                            with customer</a>
                                        <div class="min-w-175px pe-2">
                                            <span class="badge badge-light text-muted">Application Design</span>
                                        </div>
                                        <div
                                            class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px pe-2">
                                            <div class="symbol symbol-circle symbol-25px">
                                                <img src="assets/media/avatars/300-2.jpg" alt="img" />
                                            </div>
                                            <div class="symbol symbol-circle symbol-25px">
                                                <img src="assets/media/avatars/300-14.jpg" alt="img" />
                                            </div>
                                            <div class="symbol symbol-circle symbol-25px">
                                                <div
                                                    class="symbol-label fs-8 fw-semibold bg-primary text-inverse-primary">
                                                    A</div>
                                            </div>
                                        </div>
                                        <div class="min-w-125px pe-2">
                                            <span class="badge badge-light-primary">In Progress</span>
                                        </div>
                                        <a href="../../demo6/dist/apps/projects/project.html"
                                            class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                    </div>
                                    <div
                                        class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-0">
                                        <a href="../../demo6/dist/apps/projects/project.html"
                                            class="fs-5 text-dark text-hover-primary fw-semibold w-375px min-w-200px">Project
                                            Delivery Preparation</a>
                                        <div class="min-w-175px">
                                            <span class="badge badge-light text-muted">CRM System Development</span>
                                        </div>
                                        <div class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px">
                                            <div class="symbol symbol-circle symbol-25px">
                                                <img src="assets/media/avatars/300-20.jpg" alt="img" />
                                            </div>
                                            <div class="symbol symbol-circle symbol-25px">
                                                <div
                                                    class="symbol-label fs-8 fw-semibold bg-success text-inverse-primary">
                                                    B</div>
                                            </div>
                                        </div>
                                        <div class="min-w-125px">
                                            <span class="badge badge-light-success">Completed</span>
                                        </div>
                                        <a href="../../demo6/dist/apps/projects/project.html"
                                            class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-outline ki-flag fs-2 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n2">
                                <div class="overflow-auto pe-3">
                                    <div class="fs-5 fw-semibold mb-2">Invitation for crafting engaging designs that
                                        speak human workshop</div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7">Sent at 4:23 PM by</div>
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="Alan Nilson">
                                            <img src="assets/media/avatars/300-1.jpg" alt="img" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-outline ki-disconnect fs-2 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="mb-5 pe-3">
                                    <a href="#"
                                        class="fs-5 fw-semibold text-gray-800 text-hover-primary mb-2">3 New Incoming
                                        Project Files:</a>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7">Sent at 10:30 PM by</div>
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="Jan Hummer">
                                            <img src="assets/media/avatars/300-23.jpg" alt="img" />
                                        </div>
                                    </div>
                                </div>
                                <div class="overflow-auto pb-5">
                                    <div
                                        class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-700px p-5">
                                        <div class="d-flex flex-aligns-center pe-10 pe-lg-20">
                                            <img alt="" class="w-30px me-3"
                                                src="assets/media/svg/files/pdf.svg" />
                                            <div class="ms-1 fw-semibold">
                                                <a href="../../demo6/dist/apps/projects/project.html"
                                                    class="fs-6 text-hover-primary fw-bold">Finance KPI App
                                                    Guidelines</a>
                                                <div class="text-gray-400">1.9mb</div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-aligns-center pe-10 pe-lg-20">
                                            <img alt="../../demo6/dist/apps/projects/project.html"
                                                class="w-30px me-3" src="assets/media/svg/files/doc.svg" />
                                            <div class="ms-1 fw-semibold">
                                                <a href="#" class="fs-6 text-hover-primary fw-bold">Client UAT
                                                    Testing Results</a>
                                                <div class="text-gray-400">18kb</div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-aligns-center">
                                            <img alt="../../demo6/dist/apps/projects/project.html"
                                                class="w-30px me-3" src="assets/media/svg/files/css.svg" />
                                            <div class="ms-1 fw-semibold">
                                                <a href="#" class="fs-6 text-hover-primary fw-bold">Finance
                                                    Reports</a>
                                                <div class="text-gray-400">20mb</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-outline ki-abstract-26 fs-2 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="fs-5 fw-semibold mb-2">Task
                                        <a href="#" class="text-primary fw-bold me-1">#45890</a>merged with
                                        <a href="#" class="text-primary fw-bold me-1">#45890</a>in “Ads Pro
                                        Admin Dashboard project:
                                    </div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7">Initiated at 4:23 PM by</div>
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="Nina Nilson">
                                            <img src="assets/media/avatars/300-14.jpg" alt="img" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-outline ki-pencil fs-2 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="fs-5 fw-semibold mb-2">3 new application design concepts added:</div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7">Created at 4:23 PM by</div>
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top"
                                            title="Marcus Dotson">
                                            <img src="assets/media/avatars/300-2.jpg" alt="img" />
                                        </div>
                                    </div>
                                </div>
                                <div class="overflow-auto pb-5">
                                    <div
                                        class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-700px p-7">
                                        <div class="overlay me-10">
                                            <div class="overlay-wrapper">
                                                <img alt="img" class="rounded w-150px"
                                                    src="assets/media/stock/600x400/img-29.jpg" />
                                            </div>
                                            <div class="overlay-layer bg-dark bg-opacity-10 rounded">
                                                <a href="#"
                                                    class="btn btn-sm btn-primary btn-shadow">Explore</a>
                                            </div>
                                        </div>
                                        <div class="overlay me-10">
                                            <div class="overlay-wrapper">
                                                <img alt="img" class="rounded w-150px"
                                                    src="assets/media/stock/600x400/img-31.jpg" />
                                            </div>
                                            <div class="overlay-layer bg-dark bg-opacity-10 rounded">
                                                <a href="#"
                                                    class="btn btn-sm btn-primary btn-shadow">Explore</a>
                                            </div>
                                        </div>
                                        <div class="overlay">
                                            <div class="overlay-wrapper">
                                                <img alt="img" class="rounded w-150px"
                                                    src="assets/media/stock/600x400/img-40.jpg" />
                                            </div>
                                            <div class="overlay-layer bg-dark bg-opacity-10 rounded">
                                                <a href="#"
                                                    class="btn btn-sm btn-primary btn-shadow">Explore</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-outline ki-sms fs-2 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="fs-5 fw-semibold mb-2">New case
                                        <a href="#" class="text-primary fw-bold me-1">#67890</a>is assigned to
                                        you in Multi-platform Database Design project
                                    </div>
                                    <div class="overflow-auto pb-5">
                                        <div class="d-flex align-items-center mt-1 fs-6">
                                            <div class="text-muted me-2 fs-7">Added at 4:23 PM by</div>
                                            <a href="#" class="text-primary fw-bold me-1">Alice Tan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-outline ki-pencil fs-2 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="fs-5 fw-semibold mb-2">You have received a new order:</div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7">Placed at 5:05 AM by</div>
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="Robert Rich">
                                            <img src="assets/media/avatars/300-4.jpg" alt="img" />
                                        </div>
                                    </div>
                                </div>
                                <div class="overflow-auto pb-5">
                                    <div
                                        class="notice d-flex bg-light-primary rounded border-primary border border-dashed min-w-lg-600px flex-shrink-0 p-6">
                                        <i class="ki-outline ki-devices-2 fs-2tx text-primary me-4"></i>
                                        <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                            <div class="mb-3 mb-md-0 fw-semibold">
                                                <h4 class="text-gray-900 fw-bold">Database Backup Process Completed!
                                                </h4>
                                                <div class="fs-6 text-gray-700 pe-7">Login into Admin Dashboard to
                                                    make sure the data integrity is OK</div>
                                            </div>
                                            <a href="#"
                                                class="btn btn-primary px-6 align-self-center text-nowrap">Proceed</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-outline ki-basket fs-2 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="timeline-content mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="fs-5 fw-semibold mb-2">New order
                                        <a href="#" class="text-primary fw-bold me-1">#67890</a>is placed for
                                        Workshow Planning & Budget Estimation
                                    </div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7">Placed at 4:23 PM by</div>
                                        <a href="#" class="text-primary fw-bold me-1">Jimmy Bold</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer py-5 text-center" id="kt_activities_footer">
                <a href="../../demo6/dist/pages/user-profile/activity.html"
                    class="btn btn-bg-body text-primary">View All Activities
                    <i class="ki-outline ki-arrow-right fs-3 text-primary"></i></a>
            </div>
        </div>
    </div>
    <div id="kt_drawer_chat" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat"
        data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">
        <div class="card w-100 border-0 rounded-0" id="kt_drawer_chat_messenger">
            <div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">Brian
                            Cox</a>
                        <div class="mb-0 lh-1">
                            <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                            <span class="fs-7 fw-semibold text-muted">Active</span>
                        </div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="me-0">
                        <button class="btn btn-sm btn-icon btn-active-color-primary" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-dots-square fs-2"></i>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                            data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Contacts</div>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_users_search">Add Contact</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link flex-stack px-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_invite_friends">Invite Contacts
                                    <span class="ms-2" data-bs-toggle="tooltip"
                                        title="Specify a contact email to send an invitation">
                                        <i class="ki-outline ki-information fs-7"></i>
                                    </span></a>
                            </div>
                            <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                data-kt-menu-placement="right-start">
                                <a href="#" class="menu-link px-3">
                                    <span class="menu-title">Groups</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                            title="Coming soon">Create Group</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                            title="Coming soon">Invite Members</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                            title="Coming soon">Settings</a>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-item px-3 my-1">
                                <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                    title="Coming soon">Settings</a>
                            </div>
                        </div>
                    </div>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" id="kt_drawer_chat_close">
                        <i class="ki-outline ki-cross-square fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="card-body" id="kt_drawer_chat_messenger_body">
                <div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer"
                    data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px">
                    <div class="d-flex justify-content-start mb-10">
                        <div class="d-flex flex-column align-items-start">
                            <div class="d-flex align-items-center mb-2">
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                </div>
                                <div class="ms-3">
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                    <span class="text-muted fs-7 mb-1">2 mins</span>
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                                data-kt-element="message-text">How likely are you to recommend our company to your
                                friends and family ?</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-10">
                        <div class="d-flex flex-column align-items-end">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <span class="text-muted fs-7 mb-1">5 mins</span>
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                </div>
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-1.jpg" />
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
                                data-kt-element="message-text">Hey there, we’re just writing to let you know that
                                you’ve been subscribed to a repository on GitHub.</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mb-10">
                        <div class="d-flex flex-column align-items-start">
                            <div class="d-flex align-items-center mb-2">
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                </div>
                                <div class="ms-3">
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                    <span class="text-muted fs-7 mb-1">1 Hour</span>
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                                data-kt-element="message-text">Ok, Understood!</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-10">
                        <div class="d-flex flex-column align-items-end">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <span class="text-muted fs-7 mb-1">2 Hours</span>
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                </div>
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-1.jpg" />
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
                                data-kt-element="message-text">You’ll receive notifications for all issues, pull
                                requests!</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mb-10">
                        <div class="d-flex flex-column align-items-start">
                            <div class="d-flex align-items-center mb-2">
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                </div>
                                <div class="ms-3">
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                    <span class="text-muted fs-7 mb-1">3 Hours</span>
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                                data-kt-element="message-text">You can unwatch this repository immediately by clicking
                                here:
                                <a href="https://keenthemes.com">Keenthemes.com</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-10">
                        <div class="d-flex flex-column align-items-end">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <span class="text-muted fs-7 mb-1">4 Hours</span>
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                </div>
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-1.jpg" />
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
                                data-kt-element="message-text">Most purchased Business courses during this sale!</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mb-10">
                        <div class="d-flex flex-column align-items-start">
                            <div class="d-flex align-items-center mb-2">
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                </div>
                                <div class="ms-3">
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                    <span class="text-muted fs-7 mb-1">5 Hours</span>
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                                data-kt-element="message-text">Company BBQ to celebrate the last quater achievements
                                and goals. Food and drinks provided</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-10 d-none" data-kt-element="template-out">
                        <div class="d-flex flex-column align-items-end">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <span class="text-muted fs-7 mb-1">Just now</span>
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                </div>
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-1.jpg" />
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
                                data-kt-element="message-text"></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mb-10 d-none" data-kt-element="template-in">
                        <div class="d-flex flex-column align-items-start">
                            <div class="d-flex align-items-center mb-2">
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                </div>
                                <div class="ms-3">
                                    <a href="#"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                    <span class="text-muted fs-7 mb-1">Just now</span>
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                                data-kt-element="message-text">Right before vacation season we have the next Big Deal
                                for you.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-4" id="kt_drawer_chat_messenger_footer">
                <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input"
                    placeholder="Type a message"></textarea>
                <div class="d-flex flex-stack">
                    <div class="d-flex align-items-center me-2">
                        <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                            data-bs-toggle="tooltip" title="Coming soon">
                            <i class="ki-outline ki-paper-clip fs-3"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                            data-bs-toggle="tooltip" title="Coming soon">
                            <i class="ki-outline ki-cloud-add fs-3"></i>
                        </button>
                    </div>
                    <button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_shopping_cart" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="cart"
        data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_drawer_shopping_cart_toggle"
        data-kt-drawer-close="#kt_drawer_shopping_cart_close">
        <div class="card card-flush w-100 rounded-0">
            <div class="card-header">
                <h3 class="card-title text-gray-900 fw-bold">Shopping Cart</h3>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_shopping_cart_close">
                        <i class="ki-outline ki-cross fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="card-body hover-scroll-overlay-y h-400px pt-5">
                <div class="d-flex flex-stack">
                    <div class="d-flex flex-column me-3">
                        <div class="mb-3">
                            <a href="../../demo6/dist/apps/ecommerce/sales/details.html"
                                class="text-gray-800 text-hover-primary fs-4 fw-bold">Iblender</a>
                            <span class="text-gray-400 fw-semibold d-block">The best kitchen gadget in 2022</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-gray-800 fs-5">$ 350</span>
                            <span class="text-muted mx-2">for</span>
                            <span class="fw-bold text-gray-800 fs-5 me-3">5</span>
                            <a href="#"
                                class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
                                <i class="ki-outline ki-minus fs-4"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
                                <i class="ki-outline ki-plus fs-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
                        <img src="assets/media/stock/600x400/img-1.jpg" alt="" />
                    </div>
                </div>
                <div class="separator separator-dashed my-6"></div>
                <div class="d-flex flex-stack">
                    <div class="d-flex flex-column me-3">
                        <div class="mb-3">
                            <a href="../../demo6/dist/apps/ecommerce/sales/details.html"
                                class="text-gray-800 text-hover-primary fs-4 fw-bold">SmartCleaner</a>
                            <span class="text-gray-400 fw-semibold d-block">Smart tool for cooking</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-gray-800 fs-5">$ 650</span>
                            <span class="text-muted mx-2">for</span>
                            <span class="fw-bold text-gray-800 fs-5 me-3">4</span>
                            <a href="#"
                                class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
                                <i class="ki-outline ki-minus fs-4"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
                                <i class="ki-outline ki-plus fs-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
                        <img src="assets/media/stock/600x400/img-3.jpg" alt="" />
                    </div>
                </div>
                <div class="separator separator-dashed my-6"></div>
                <div class="d-flex flex-stack">
                    <div class="d-flex flex-column me-3">
                        <div class="mb-3">
                            <a href="../../demo6/dist/apps/ecommerce/sales/details.html"
                                class="text-gray-800 text-hover-primary fs-4 fw-bold">CameraMaxr</a>
                            <span class="text-gray-400 fw-semibold d-block">Professional camera for edge</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-gray-800 fs-5">$ 150</span>
                            <span class="text-muted mx-2">for</span>
                            <span class="fw-bold text-gray-800 fs-5 me-3">3</span>
                            <a href="#"
                                class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
                                <i class="ki-outline ki-minus fs-4"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
                                <i class="ki-outline ki-plus fs-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
                        <img src="assets/media/stock/600x400/img-8.jpg" alt="" />
                    </div>
                </div>
                <div class="separator separator-dashed my-6"></div>
                <div class="d-flex flex-stack">
                    <div class="d-flex flex-column me-3">
                        <div class="mb-3">
                            <a href="../../demo6/dist/apps/ecommerce/sales/details.html"
                                class="text-gray-800 text-hover-primary fs-4 fw-bold">$D Printer</a>
                            <span class="text-gray-400 fw-semibold d-block">Manfactoring unique objekts</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-gray-800 fs-5">$ 1450</span>
                            <span class="text-muted mx-2">for</span>
                            <span class="fw-bold text-gray-800 fs-5 me-3">7</span>
                            <a href="#"
                                class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
                                <i class="ki-outline ki-minus fs-4"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
                                <i class="ki-outline ki-plus fs-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
                        <img src="assets/media/stock/600x400/img-26.jpg" alt="" />
                    </div>
                </div>
                <div class="separator separator-dashed my-6"></div>
                <div class="d-flex flex-stack">
                    <div class="d-flex flex-column me-3">
                        <div class="mb-3">
                            <a href="../../demo6/dist/apps/ecommerce/sales/details.html"
                                class="text-gray-800 text-hover-primary fs-4 fw-bold">MotionWire</a>
                            <span class="text-gray-400 fw-semibold d-block">Perfect animation tool</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-gray-800 fs-5">$ 650</span>
                            <span class="text-muted mx-2">for</span>
                            <span class="fw-bold text-gray-800 fs-5 me-3">7</span>
                            <a href="#"
                                class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
                                <i class="ki-outline ki-minus fs-4"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
                                <i class="ki-outline ki-plus fs-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
                        <img src="assets/media/stock/600x400/img-21.jpg" alt="" />
                    </div>
                </div>
                <div class="separator separator-dashed my-6"></div>
                <div class="d-flex flex-stack">
                    <div class="d-flex flex-column me-3">
                        <div class="mb-3">
                            <a href="../../demo6/dist/apps/ecommerce/sales/details.html"
                                class="text-gray-800 text-hover-primary fs-4 fw-bold">Samsung</a>
                            <span class="text-gray-400 fw-semibold d-block">Profile info,Timeline etc</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-gray-800 fs-5">$ 720</span>
                            <span class="text-muted mx-2">for</span>
                            <span class="fw-bold text-gray-800 fs-5 me-3">6</span>
                            <a href="#"
                                class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
                                <i class="ki-outline ki-minus fs-4"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
                                <i class="ki-outline ki-plus fs-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
                        <img src="assets/media/stock/600x400/img-34.jpg" alt="" />
                    </div>
                </div>
                <div class="separator separator-dashed my-6"></div>
                <div class="d-flex flex-stack">
                    <div class="d-flex flex-column me-3">
                        <div class="mb-3">
                            <a href="../../demo6/dist/apps/ecommerce/sales/details.html"
                                class="text-gray-800 text-hover-primary fs-4 fw-bold">$D Printer</a>
                            <span class="text-gray-400 fw-semibold d-block">Manfactoring unique objekts</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-gray-800 fs-5">$ 430</span>
                            <span class="text-muted mx-2">for</span>
                            <span class="fw-bold text-gray-800 fs-5 me-3">8</span>
                            <a href="#"
                                class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
                                <i class="ki-outline ki-minus fs-4"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
                                <i class="ki-outline ki-plus fs-4"></i>
                            </a>
                        </div>
                    </div>
                    <div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
                        <img src="assets/media/stock/600x400/img-27.jpg" alt="" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex flex-stack">
                    <span class="fw-bold text-gray-600">Total</span>
                    <span class="text-gray-800 fw-bolder fs-5">$ 1840.00</span>
                </div>
                <div class="d-flex flex-stack">
                    <span class="fw-bold text-gray-600">Sub total</span>
                    <span class="text-primary fw-bolder fs-5">$ 246.35</span>
                </div>
                <div class="d-flex justify-content-end mt-9">
                    <a href="#" class="btn btn-primary d-flex justify-content-end">Pleace Order</a>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <div class="modal fade" id="kt_modal_upgrade_plan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded">
                <div class="modal-header justify-content-end border-0 pb-0">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <div class="modal-body pt-0 pb-15 px-5 px-xl-20">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Upgrade a Plan</h1>
                        <div class="text-muted fw-semibold fs-5">If you need more info, please check
                            <a href="#" class="link-primary fw-bold">Pricing Guidelines</a>.
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="nav-group nav-group-outline mx-auto" data-kt-buttons="true">
                            <button
                                class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active"
                                data-kt-plan="month">Monthly</button>
                            <button class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3"
                                data-kt-plan="annual">Annual</button>
                        </div>
                        <div class="row mt-10">
                            <div class="col-lg-6 mb-10 mb-lg-0">
                                <div class="nav flex-column">
                                    <label
                                        class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 active mb-6"
                                        data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_startup">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                                                <input class="form-check-input" type="radio" name="plan"
                                                    checked="checked" value="startup" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Startup
                                                </div>
                                                <div class="fw-semibold opacity-75">Best for startups</div>
                                            </div>
                                        </div>
                                        <div class="ms-5">
                                            <span class="mb-2">$</span>
                                            <span class="fs-3x fw-bold" data-kt-plan-price-month="39"
                                                data-kt-plan-price-annual="399">39</span>
                                            <span class="fs-7 opacity-50">/
                                                <span data-kt-element="period">Mon</span></span>
                                        </div>
                                    </label>
                                    <label
                                        class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6"
                                        data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_advanced">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                                                <input class="form-check-input" type="radio" name="plan"
                                                    value="advanced" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Advanced
                                                </div>
                                                <div class="fw-semibold opacity-75">Best for 100+ team size</div>
                                            </div>
                                        </div>
                                        <div class="ms-5">
                                            <span class="mb-2">$</span>
                                            <span class="fs-3x fw-bold" data-kt-plan-price-month="339"
                                                data-kt-plan-price-annual="3399">339</span>
                                            <span class="fs-7 opacity-50">/
                                                <span data-kt-element="period">Mon</span></span>
                                        </div>
                                    </label>
                                    <label
                                        class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6"
                                        data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_enterprise">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                                                <input class="form-check-input" type="radio" name="plan"
                                                    value="enterprise" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">
                                                    Enterprise
                                                    <span
                                                        class="badge badge-light-success ms-2 py-2 px-3 fs-7">Popular</span>
                                                </div>
                                                <div class="fw-semibold opacity-75">Best value for 1000+ team</div>
                                            </div>
                                        </div>
                                        <div class="ms-5">
                                            <span class="mb-2">$</span>
                                            <span class="fs-3x fw-bold" data-kt-plan-price-month="999"
                                                data-kt-plan-price-annual="9999">999</span>
                                            <span class="fs-7 opacity-50">/
                                                <span data-kt-element="period">Mon</span></span>
                                        </div>
                                    </label>
                                    <label
                                        class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6"
                                        data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_custom">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                                                <input class="form-check-input" type="radio" name="plan"
                                                    value="custom" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Custom
                                                </div>
                                                <div class="fw-semibold opacity-75">Requet a custom license</div>
                                            </div>
                                        </div>
                                        <div class="ms-5">
                                            <a href="#" class="btn btn-sm btn-success">Contact Us</a>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="tab-content rounded h-100 bg-light p-10">
                                    <div class="tab-pane fade show active" id="kt_upgrade_plan_startup">
                                        <div class="pb-5">
                                            <h2 class="fw-bold text-dark">What’s in Startup Plan?</h2>
                                            <div class="text-muted fw-semibold">Optimal for 10+ team size and new
                                                startup</div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10
                                                    Active Users</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30
                                                    Project Integrations</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-muted flex-grow-1">Finance
                                                    Module</span>
                                                <i class="ki-outline ki-cross-circle fs-1"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-muted flex-grow-1">Accounting
                                                    Module</span>
                                                <i class="ki-outline ki-cross-circle fs-1"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-muted flex-grow-1">Network
                                                    Platform</span>
                                                <i class="ki-outline ki-cross-circle fs-1"></i>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-semibold fs-5 text-muted flex-grow-1">Unlimited Cloud
                                                    Space</span>
                                                <i class="ki-outline ki-cross-circle fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kt_upgrade_plan_advanced">
                                        <div class="pb-5">
                                            <h2 class="fw-bold text-dark">What’s in Startup Plan?</h2>
                                            <div class="text-muted fw-semibold">Optimal for 100+ team size and grown
                                                company</div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10
                                                    Active Users</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30
                                                    Project Integrations</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-muted flex-grow-1">Network
                                                    Platform</span>
                                                <i class="ki-outline ki-cross-circle fs-1"></i>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-semibold fs-5 text-muted flex-grow-1">Unlimited Cloud
                                                    Space</span>
                                                <i class="ki-outline ki-cross-circle fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kt_upgrade_plan_enterprise">
                                        <div class="pb-5">
                                            <h2 class="fw-bold text-dark">What’s in Startup Plan?</h2>
                                            <div class="text-muted fw-semibold">Optimal for 1000+ team and enterpise
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10
                                                    Active Users</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30
                                                    Project Integrations</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Network
                                                    Platform</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited
                                                    Cloud Space</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kt_upgrade_plan_custom">
                                        <div class="pb-5">
                                            <h2 class="fw-bold text-dark">What’s in Startup Plan?</h2>
                                            <div class="text-muted fw-semibold">Optimal for corporations</div>
                                        </div>
                                        <div class="pt-1">
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited
                                                    Users</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited
                                                    Project Integrations</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting
                                                    Module</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center mb-7">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Network
                                                    Platform</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited
                                                    Cloud Space</span>
                                                <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-center flex-row-fluid pt-12">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="kt_modal_upgrade_plan_btn">
                            <span class="indicator-label">Upgrade Plan</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mw-650px">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <div class="text-center mb-13">
                        <h1 class="mb-3">Invite a Friend</h1>
                        <div class="text-muted fw-semibold fs-5">If you need more info, please check out
                            <a href="#" class="link-primary fw-bold">FAQ Page</a>.
                        </div>
                    </div>
                    <div class="btn btn-light-primary fw-bold w-100 mb-8">
                        <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg"
                            class="h-20px me-3" />Invite Gmail Contacts
                    </div>
                    <div class="separator d-flex flex-center mb-8">
                        <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">or</span>
                    </div>
                    <textarea class="form-control form-control-solid mb-8" rows="3" placeholder="Type or paste emails here"></textarea>
                    <div class="mb-10">
                        <div class="fs-6 fw-semibold mb-2">Your Invitations</div>
                        <div class="mh-300px scroll-y me-n7 pe-7">
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-6.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Smith</a>
                                        <div class="fw-semibold text-muted">smith@kpmg.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2" selected="selected">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-danger text-danger fw-semibold">M</span>
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Melody Macy</a>
                                        <div class="fw-semibold text-muted">melody@altbox.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1" selected="selected">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-1.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Max Smith</a>
                                        <div class="fw-semibold text-muted">max@kt.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3" selected="selected">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-5.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Sean Bean</a>
                                        <div class="fw-semibold text-muted">sean@dellito.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2" selected="selected">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Brian Cox</a>
                                        <div class="fw-semibold text-muted">brian@exchange.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3" selected="selected">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-warning text-warning fw-semibold">C</span>
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Mikaela
                                            Collins</a>
                                        <div class="fw-semibold text-muted">mik@pex.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2" selected="selected">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-9.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Francis
                                            Mitcham</a>
                                        <div class="fw-semibold text-muted">f.mit@kpmg.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3" selected="selected">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-danger text-danger fw-semibold">O</span>
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Olivia Wild</a>
                                        <div class="fw-semibold text-muted">olivia@corpmail.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2" selected="selected">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-primary text-primary fw-semibold">N</span>
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Neil Owen</a>
                                        <div class="fw-semibold text-muted">owen.neil@gmail.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1" selected="selected">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-23.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Dan Wilson</a>
                                        <div class="fw-semibold text-muted">dam@consilting.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3" selected="selected">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-danger text-danger fw-semibold">E</span>
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Bold</a>
                                        <div class="fw-semibold text-muted">emma@intenso.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2" selected="selected">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-12.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ana Crown</a>
                                        <div class="fw-semibold text-muted">ana.cf@limtel.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1" selected="selected">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-info text-info fw-semibold">A</span>
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Robert Doe</a>
                                        <div class="fw-semibold text-muted">robert@benko.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3" selected="selected">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-13.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">John Miller</a>
                                        <div class="fw-semibold text-muted">miller@mapple.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3" selected="selected">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-success text-success fw-semibold">L</span>
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Lucy Kunic</a>
                                        <div class="fw-semibold text-muted">lucy.m@fentech.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2" selected="selected">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-21.jpg" />
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ethan
                                            Wilder</a>
                                        <div class="fw-semibold text-muted">ethan@loop.com.au</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1" selected="selected">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-stack py-4">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light-warning text-warning fw-semibold">C</span>
                                    </div>
                                    <div class="ms-5">
                                        <a href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Mikaela
                                            Collins</a>
                                        <div class="fw-semibold text-muted">mik@pex.com</div>
                                    </div>
                                </div>
                                <div class="ms-2 w-100px">
                                    <select class="form-select form-select-solid form-select-sm"
                                        data-control="select2" data-dropdown-parent="#kt_modal_invite_friends"
                                        data-hide-search="true">
                                        <option value="1">Guest</option>
                                        <option value="2">Owner</option>
                                        <option value="3" selected="selected">Can Edit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-stack">
                        <div class="me-5 fw-semibold">
                            <label class="fs-6">Adding Users by Team Members</label>
                            <div class="fs-7 text-muted">If you need more info, please check budget planning</div>
                        </div>
                        <label class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" checked="checked" />
                            <span class="form-check-label fw-semibold text-muted">Allowed</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/custom/apps/ecommerce/sales/listing.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/create-campaign.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <script src="{{ asset('assets/js/language.js') }}"></script>
</body>

</html>
