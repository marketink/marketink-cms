<!DOCTYPE html>
<html lang="{{ defaultLang() }}">
<?php $setting = getSetting(); ?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta data-n-head="ssr" name="viewport"
        content="width=device-width, minimum-scale=1, initial-scale=1, maximum-scale=1, user-scalable=1, viewport-fit=cover">
    {!! isset($SEOData) ? seo($SEOData) : seo() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .text-box {
            line-height: 25px;
            font-weight: 400;

        }

        iframe {
            border-radius: 10px;
        }

        .curtain-part .dropdown-menu {
            min-width: 320px;
        }


        .accordion-button:not(.collapsed):after {
            content: "" !important;
            width: 25px;
        }

        .logo-img {
            width: 100%;
            height: auto !important;
            max-height: 55px;
            margin: 0 !important;
            object-fit: contain;
        }
    </style>
    @yield("beforeHead")
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo.webp')}}?v=3">
    <link rel="preload" as="style" href="{{ asset('build/theme.min.css') }}">
    <link rel="preload" as="style" href="{{ asset('build/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/theme.min.css') }}?v={{ siteSetting()['assets']['css']['main'] }}" />
    <link rel="stylesheet" href="{{ asset('build/main.min.css') }}?v={{ siteSetting()['assets']['css']['main'] }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" />
</head>

<body>
 
 
    <main>
 

        @if (flash()->message)
            <div class="alert alert-success d-flex align-items-center rounded-0 mb-0" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-check-circle-fill ms-2" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                <div>
                    {{ flash()->message }}
                </div>
            </div>
        @endif
        @if (isset($errors) && $errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger d-flex align-items-center rounded-0 mb-0" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-exclamation-triangle-fill ms-2" viewBox="0 0 16 16">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <div>
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        @endif
        @yield('content')
    </main>
</body>

</html>