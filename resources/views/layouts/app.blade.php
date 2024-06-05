<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Koperasi Digital')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />
    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0') }}" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=2.0.0') }}" />
    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css') }}" />
    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css') }}" />
    <!-- JQUEY UI-->
    <link rel="stylesheet" href="{{ asset('assets/external/jquery-ui-1.13.3.custom/jquery-ui.min.css') }}">
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('assets/external/select2/select2.min.css') }}">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/external/sweetalert/sweetalert2.min.css') }}">
    <!-- Custom css ku -->
    <link rel="stylesheet" href="{{ asset('assets/external/mycss.css') }}">

    <style>
        .dataTables_length {
            margin-bottom: 16px;
        }
        html div.dataTables_wrapper div.dataTables_paginate {
            margin-top: 8px;
        }
    </style>

    @stack('css')
</head>

<body class="  ">

    <aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="{{ url('/dashboard') }}" class="navbar-brand">
                <!--Logo start-->
                <div class="logo-main">
                    <div class="logo-normal">
                        <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                            <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                        </svg>
                    </div>
                    <div class="logo-mini">
                        <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                            <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                        </svg>
                    </div>
                </div>
                <!--logo End-->

                <h4 class="logo-title">KOSIPA</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar -->
                <x-sidebar />
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>
    <main class="main-content">
        <!-- Navbar -->
        <x-navbar />

        <div class="" style="height: 85px;">
        </div>

        <div class="conatiner-fluid content-inner mt-n5 py-0">

            {{-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    @foreach(Request::segments() as $segment)
                        <li class="breadcrumb-item">{{ Str::headline($segment) }}</li>
                    @endforeach
                </ol>
            </nav> --}}

            {{ $slot }}
        </div>
    </main>

    <!-- Wrapper End-->
   @stack('modal')

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <script src="{{ asset('assets/js/charts/dashboard.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>
    <!-- Jquery UI -->
    <script src="{{ asset('assets/external/jquery-ui-1.13.3.custom/jquery-ui.min.js') }}"></script>
    <!-- Jquery Validation -->
    <script src="{{ asset('assets/external/jquery-validation/jquery.validate.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{ asset('assets/external/select2/select2.full.min.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('assets/external/sweetalert/sweetalert2@11.js') }}"></script>
    <!-- Jquery Mask -->
    <script src="{{ asset('assets/external/jquery-mask/jquery.mask.min.js') }}"></script>
    <!-- Base JS -->
    <script src="{{ asset('assets/external/base.js') }}"></script>

    @stack('script')
</body>
</html>
