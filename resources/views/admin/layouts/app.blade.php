<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta data-n-head="ssr" name="viewport"
        content="width=device-width, minimum-scale=1, initial-scale=1, maximum-scale=1, user-scalable=1, viewport-fit=cover">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('logo.webp')}}">
    <link rel="icon" type="image/png" href="{{ asset('logo.webp')}}">
    <title>
        {{ siteSetting()['siteName'] . " " . trans("message.managing_panel") }}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/admin/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="{{ asset('assets/font-awesome/js/all.min.js') }}" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/admin/css/material-dashboard.css')}}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/fontiran.css')}}?v=3.2.0" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/toastify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/select2.css') }}">

    <style>
        .rtl .dropdown .dropdown-menu {
            left: 0 !important;
            right: auto !important;
        }
    </style>
</head>

<body class="g-sidenav-show rtl bg-gray-100">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-end me-2 rotate-caret bg-white my-2"
        id="sidenav-main">
        <div class="sidenav-header">
            <i style="left:0"
                class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute top-0 d-none d-xl-none"
                id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0" href="{{ route('dashboard') }}">
                <img src="{{ asset('logo.webp')}}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
                <span class="me-1 text-sm text-dark strong">{{ siteSetting()['siteName'] }}</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse px-0 w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ checkActiveMenu(route('dashboard'), 'text-dark', 'active bg-gradient-dark text-white') }}"
                        href="{{ route('dashboard') }}">
                        <i class="material-symbols-rounded opacity-10">dashboard</i>
                        <span class="nav-link-text me-1">{{trans("message.dashboard")}}</span>
                    </a>
                </li>
                @foreach (types() as $type)
                    <li class="nav-item">
                        <a class="nav-link {{ checkActiveMenu(route('dashboard.contents', $type['type']), 'text-dark', 'active bg-gradient-dark text-white') }}"
                            href="{{ route('dashboard.contents', $type['type']) }}">
                            <i class="material-symbols-rounded opacity-10">{{ $type['menu_icon'] ?? '' }}</i>
                            <span class="nav-link-text me-1">{{ $type['name'] }}</span>
                        </a>
                    </li>
                @endforeach

                <li class="nav-item">
                    <a class="nav-link {{ checkActiveMenu(route('dashboard.carts'), 'text-dark', 'active bg-gradient-dark text-white') }}"
                        href="{{ route('dashboard.carts') }}">
                        <i class="material-symbols-rounded opacity-10">shopping_cart</i>
                        <span class="nav-link-text me-1">سفارشات</span>
                    </a>
                </li>
				
                <li class="nav-item">
                    <a class="nav-link {{ checkActiveMenu(route('dashboard.setting'), 'text-dark', 'active bg-gradient-dark text-white') }}"
                        href="{{ route('dashboard.setting') }}">
                        <i class="material-symbols-rounded opacity-10">settings</i>
                        <span class="nav-link-text me-1">{{trans("message.setting")}}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ checkActiveMenu(route('dashboard.users'), 'text-dark', 'active bg-gradient-dark text-white') }}"
                        href="{{ route('dashboard.users') }}">
                        <i class="material-symbols-rounded opacity-10">groups</i>
                        <span class="nav-link-text me-1">{{trans("message.users")}}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        href="{{ route('logout') }}">
                        <i class="material-symbols-rounded opacity-10">logout</i>
                        <span class="nav-link-text me-1">{{trans("message.exit")}}</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
            <div class="mx-3">
                <a class="btn bg-gradient-dark w-100" href="{{  url('/') }}"
                    type="button">{{trans("message.show_site")}}</a>
            </div>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-x-hidden">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 ">
                        <li class="breadcrumb-item text-sm ps-2"><a class="opacity-5 text-dark" href="javascript:;">
                                {{trans("message.managing_panel")}}
                            </a>
                        </li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">{{ trans("message.contents") }}</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 px-0" id="navbar">
                    <ul class="navbar-nav d-flex align-items-center me-auto ms-0 justify-content-end">
                        <li class="nav-item d-xl-none pe-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        @yield('content')
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/platform/js/vendors/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/core/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/plugins/smooth-scrollbar.min.js')}}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script src="{{ asset('assets/admin/js/material-dashboard.min.js')}}?v=3.2.0"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/toastify.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select2.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dashboard.js')}}?v=1.1.{{  time() }}"></script>

    @yield('script')
</body>

</html>