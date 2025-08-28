<!DOCTYPE html>
<html lang="{{ defaultLang() }}">
<?php $setting = getSetting(); ?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta data-n-head="ssr" name="viewport"
        content="width=device-width, minimum-scale=1, initial-scale=1, maximum-scale=1, user-scalable=1, viewport-fit=cover">
    {!! isset($SEOData) ? seo($SEOData) : seo() !!}
    <style>
        :root {
            --home-color:
                {{ $setting?->app_color }}
                !important;
        }

        .font-weight-300 {
            font-weight: 300 !important
        }

        .curtain-tool-info {
            font-size: 12px !important;
            margin: 0 !important;
            font-weight: 400 !important;
        }
    </style>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo.webp')}}">
    <link rel="preload" as="style" href="{{ asset('build/theme.min.css') }}">
    <link rel="preload" as="style" href="{{ asset('build/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/theme.min.css') }}?v={{ siteSetting()['assets']['css']['main'] }}" />
    <link rel="stylesheet" href="{{ asset('build/main.min.css') }}?v={{ siteSetting()['assets']['css']['main'] }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" />

    <style>
        .logo-img {
            width: 100%;
            height: auto !important;
            max-height: 55px;
            margin: 0 !important;
            object-fit: contain;
        }
        body {
            padding: 0 !important
        }
    </style>
</head>

<body>
    <!-- navigation -->
    <div class="border-bottom shadow-sm">
        <nav class="navbar navbar-light py-2">
            <div class="container justify-content-center justify-content-lg-between">
                <a class="navbar-brand" href="{{  url('/') }}">
                    <img src="{{ asset('logo.webp')}}?v=3" alt="" class="d-inline-block align-text-top logo-img">
                </a>
                <span class="navbar-text">
                    <a href="{{  url('/') }}">{{trans("message.first_page")}}</a>
                </span>
            </div>
        </nav>
    </div>

    <main>
        <!-- section -->
        @yield('content')
    </main>

    @include('layouts.footer')
    <script src="{{ asset('assets/platform/js/vendors/password.js')}}"></script>
    <script src="{{ asset('build/main.min.js') }}?v={{ siteSetting()['assets']['js']['main'] }}" async></script>
</body>

</html>