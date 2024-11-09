<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <title>@yield('title')@yield('sub_title') - {{env('APP_NAME')}}</title>
    <meta charset="utf-8" />
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    @yield('header_js')
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/dev.css')}}" rel="stylesheet" type="text/css" />
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>


    @stack('styles')
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">

    <!--begin::Theme mode setup on page load-->
    <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
    <!--end::Theme mode setup on page load-->

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">

            <!--begin::Aside-->
            <div id="kt_aside" class="aside overflow-visible pb-5 pt-5 pt-lg-0" data-kt-drawer="true" data-kt-drawer-name="aside"
                 data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                 data-kt-drawer-width="{default:'80px', '300px': '100px'}" data-kt-drawer-direction="start"
                 data-kt-drawer-toggle="#kt_aside_mobile_toggle" @yield('aside_background')>
                <!--begin::Brand-->
                <div class="aside-logo py-8" id="kt_aside_logo" @yield('aside_background')>
                    <!--begin::Logo-->
                    <a href="{{route('home')}}" class="d-flex align-items-center">
                        <img alt="Logo" src="{{asset('favicon.ico')}}" class="h-45px logo" />
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
                            @if (session('type') == 'admin')
                                @include('layouts.menus.admin')
                            @elseif(session('type') == 'vas')
                                @include('layouts.menus.vas')
                            @elseif(session('type') == 'agent')
                                @include('layouts.menus.agent')
                            @elseif(session('type') == 'sales')
                                @include('layouts.menus.sales')
                            @endif
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
                            <a href="{{route('home')}}" class="d-lg-none">
                                <img alt="Logo" src="{{asset('favicon.ico')}}" class="h-25px" />
                            </a>
                        </div>
                        <!--end::Mobile logo-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <!--begin::Navbar-->
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                <!--begin::Menu wrapper-->
                                <div class="header-menu align-items-stretch">
                                    <!--begin::Menu-->
                                    <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-state-primary menu-title-gray-700 menu-arrow-gray-400 fw-semibold my-5 my-lg-0 px-2 px-lg-0 align-items-stretch" >
                                        <!--begin:Menu item-->
                                        <div class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                            <!--begin:Menu link-->
                                            <span class="menu-link py-3">
													<span class="menu-title">{{session('business_name')}}</span>
													<span class="menu-arrow d-lg-none"></span>
												</span>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::Navbar-->
                            <!--begin::Toolbar wrapper-->
                            <div class="d-flex align-items-stretch flex-shrink-0">
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
                                        <img src="{{asset('assets/media/avatars/blank.png')}}" alt="image" />
                                    </div>
                                    <!--begin::User account menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                         data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div class="menu-content d-flex align-items-center px-3">
                                                <div class="symbol symbol-50px me-5">
                                                    <img alt="Logo" src="{{asset('assets/media/avatars/blank.png')}}" />
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold d-flex align-items-center fs-5">
                                                        {{ session('name') }}
                                                        <span
                                                            class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ Str::ucfirst(__(session('type'))) }}</span>
                                                    </div>
                                                    <a href="#"
                                                       class="fw-semibold text-muted text-hover-primary fs-7">{{ session('email') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-2"></div>
                                        <div class="menu-item px-5">
                                            <a href="{{route('profile')}}" class="menu-link px-5">{{ __('Profile') }}</a>
                                        </div>
                                        <div class="menu-item px-5">
                                            <a href="{{route('changepassword')}}" class="menu-link px-5">{{ __('Change Password') }}</a>
                                        </div>
                                        <!--<div class="menu-item px-5">
                                            <a href="{{url('https://support.rakoli.com')}}" target="_blank" class="menu-link px-5">{{ __('Support') }}</a>
                                        </div> -->
                                        <div class="separator my-2"></div>
                                            <div class="menu-item px-5"
                                                 data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                 data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                                <a href="#" class="menu-link px-5">
                                                        <span class="menu-title position-relative">{{__('Language')}}
                                                            <span
                                                                class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">{{ localeToLanguage(session('locale'))}}
                                                                <img class="w-15px h-15px rounded-1 ms-2"
                                                                     src="{{ getLocaleSVGImagePath(session('locale')) }}"
                                                                     alt="" /></span></span>
                                                </a>
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <div class="menu-item px-3">
                                                        <a href="{{route('languageSwitch',['language'=>'en'])}}"
                                                           class="menu-link d-flex px-5 active">
                                                                <span class="symbol symbol-20px me-4">
                                                                    <img class="rounded-1"
                                                                         src="{{ getLocaleSVGImagePath('en') }}"
                                                                         alt="" />
                                                                </span>English</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="{{route('languageSwitch',['language'=>'sw'])}}"
                                                           class="menu-link d-flex px-5">
                                                                <span class="symbol symbol-20px me-4">
                                                                    <img class="rounded-1"
                                                                         src="{{ getLocaleSVGImagePath('sw') }}"
                                                                         alt="" />
                                                                </span>Swahili</a>
                                                    </div>

                                                </div>
                                            </div>
                                        <div class="separator my-2"></div>
                                        <div class="menu-item px-5">
                                            <form id="logout-form" action="{{ url('logout') }}" method="POST">
                                                {{ csrf_field() }}
                                                <button style="width: 100%" class="menu-link px-5"
                                                        type="submit">{{__('Sign Out')}}</button>
                                            </form>

                                        </div>
                                    </div>
                                    <!--end::User account menu-->


                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::User menu-->
                            </div>
                            <!--end::Toolbar wrapper-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->

                <!--begin::Toolbar-->
                <div class="toolbar py-2" id="kt_toolbar">
                    <!--begin::Container-->
                    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
                        <!--begin::Page title-->
                        <div class="flex-grow-1 flex-shrink-0 me-5">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">@yield('title')
                                    @yield('breadcrumb')
                                    @if(!empty(cleanText(Request()->route()->getPrefix())))
                                        <!--begin::Separator-->
                                        <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                        <!--end::Separator-->
                                        <!--begin::Description-->
                                        <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{__(ucfirst(cleanText(Request()->route()->getPrefix())))}}</small>
                                        <!--end::Description-->
                                    @endif
                                    <!--begin::Separator-->
                                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                    <!--end::Separator-->
                                    <!--begin::Description-->
                                    <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{strtoupper(__(session('type')))}}</small>
                                    <!--end::Description-->
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Toolbar-->

                @if ($errors->any())
                    <!--begin::Container-->
                    <div class="container-xxl mb-5">
                        <div class="card card-flush mb-0">
                            <div class="alert alert-danger mb-0">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <!--begin::Container-->
                    <div class="container-xxl mb-5">
                        <div class="card card-flush mb-0">
                            <div class="alert alert-danger mb-0">
                                <ul>
                                    @foreach (session('error') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('message'))
                    <div class="container-xxl mb-5">
                        <div class="card card-flush mb-0">
                            <div class="alert alert-success mb-0">
                                {{ session('message') }}
                            </div>
                        </div>
                    </div>
                @endif


                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    @yield('content')

                </div>
                <!--end::Content-->



                <!--begin::Footer-->
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1">{{ now()->year }}&copy;</span>
                            <a href="#" class="text-gray-800 text-hover-primary">{{env('APP_DEV', env('APP_NAME'))}}</a>
                        </div>
                        <!--end::Copyright-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->

            </div>
            <!--end::Wrapper-->

        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->

    <!--begin::Javascript-->
    <script>var hostUrl = "assets/";</script>

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/language.js') }}"></script>
    <script src="{{ asset('assets/js/rakoli_ajax.js') }}"></script>
    <script>
        const { format } = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: "{{ currencyCode() }}",
            maximumFractionDigits: 2,
        });

        // Function used to add images in select2
        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }
            var optionWithImage = $(
                '<span><img src="' + option.title + '" class="img-flag" /> ' + option.text + '</span>'
            );
            return optionWithImage;
        }


        const SwalModal = (icon, title, html) => {
            Swal.fire({
                icon,
                title,
                html,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        }
        const SwalConfirm = (icon, title, html, confirmButtonText) => {
            Swal.fire({
                icon,
                title,
                html,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText,
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        }

        const SwalInput = (title,input,inputLabel,inputPlaceholder) => {

            Swal.fire({
                title: title,
                input: input,
                inputLabel:  inputLabel,
                inputPlaceholder: inputPlaceholder
            })

        }

        const SwalAlert = (icon, title, html = "", timeout = 5000) => {
            Swal.fire({
                title: title,
                html: html,
                icon: icon,
                timer: timeout
            });
        }

    </script>
    <script>
        jQuery(document).ready(function(){
            jQuery(document).on("click",".dtr-data .action_btn",function(){
                
                jQuery(this).siblings(".action_menu").toggleClass("show");
            });
        });
    </script>

    @yield('footer_js')
    @stack('js')

</body>

</html>
