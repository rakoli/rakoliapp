<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!--begin::Head-->
<head>
    <title>@yield('title', 'Auth') - {{env('APP_NAME')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    @yield('header_js')
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .pre-loader{display: none;}@media (max-width: 767px){.pre-loader{display:block;background:#409992;background-position:center center;background-size:43%;position:fixed;left:0;top:0;width:100%;height:100%;z-index:12345;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.pre-loader .loader-logo{padding-bottom:15px}.pre-loader .loader-progress{height:8px;border-radius:15px;max-width:200px;margin:0 auto;display:block;background:#ecf0f4;overflow:hidden}.pre-loader .bar{width:0%;height:8px;display:block;background:#02C6A9}.pre-loader .percent{text-align:center;font-size:24px;display:none}.pre-loader .loading-text{text-align:center;font-size:18px;font-weight:500;padding-top:15px}}
    </style>
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
