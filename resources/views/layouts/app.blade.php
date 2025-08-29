<!DOCTYPE html>
<html lang="{{ defaultLang() }}" dir="rtl">

<head>
    {!! isset($SEOData) ? seo($SEOData) : seo() !!}

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Dark mode -->
    <script>
        const storedTheme = localStorage.getItem('theme')

        const getPreferredTheme = () => {
            if (storedTheme) {
                return storedTheme
            }
            return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'light'
        }

        const setTheme = function (theme) {
            if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'dark')
            } else {
                document.documentElement.setAttribute('data-bs-theme', theme)
            }
        }

        setTheme(getPreferredTheme())

        window.addEventListener('DOMContentLoaded', () => {
            var el = document.querySelector('.theme-icon-active');
            if (el != 'undefined' && el != null) {
                const showActiveTheme = theme => {
                    const activeThemeIcon = document.querySelector('.theme-icon-active use')
                    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
                    const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

                    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                        element.classList.remove('active')
                    })

                    btnToActive.classList.add('active')
                    activeThemeIcon.setAttribute('href', svgOfActiveBtn)
                }

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                    if (storedTheme !== 'light' || storedTheme !== 'dark') {
                        setTheme(getPreferredTheme())
                    }
                })

                showActiveTheme(getPreferredTheme())

                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            localStorage.setItem('theme', theme)
                            setTheme(theme)
                            showActiveTheme(theme)
                        })
                    })

            }
        })

    </script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/platform/images/favicon.ico">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&family=Rubik:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="/assets/platform/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/platform/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="/assets/platform/vendor/tiny-slider/tiny-slider.css">
    <link rel="stylesheet" type="text/css" href="/assets/platform/vendor/plyr/plyr.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="/assets/platform/css/style-rtl.css">
    <link id="pagestyle" href="{{ asset('assets/fontiran.css')}}?v=3.2.0" rel="stylesheet" />
    <style>
        .tiny-slider {
            direction: ltr;
        }

        .tiny-slider .card {
            direction: rtl;
        }
    </style>

</head>

<body>

    <!-- Top alert START -->
    <div class="alert alert-warning py-2 m-0 bg-primary border-0 rounded-0 alert-dismissible fade show text-center overflow-hidden"
        role="alert">
        <!-- SVG shape START -->
        <figure class="position-absolute top-50 start-50 translate-middle">
            <svg width="1848" height="481" viewBox="0 0 1848.9 481.8" xmlns="http://www.w3.org/2000/svg">
                <path class="fill-success"
                    d="m779.4 251c-10.3-11.5-19.9-23.8-29.4-36.1-9-11.6-18.4-22.8-27.1-34.7-15.3-21.2-30.2-45.8-54.8-53.3-10.5-3.2-21.6-3.2-30.6 2.5-7.6 4.8-13 12.6-17.3 20.9-10.8 20.6-16.1 44.7-24.6 66.7-7.9 20.2-19.4 38.6-33.8 54.3-14.7 16.2-31.7 30-50.4 41-15.9 9.4-33.4 17.2-52 19.3-18.4 2-38-2.5-56.5-6.2-22.4-4.4-45.1-9.7-67.6-10.9-9.8-0.5-19.8-0.3-29.1 2.3-9.8 2.8-18.7 8.6-26.6 15.2-17.3 14.5-30.2 34.4-43.7 52.9-12.9 17.6-26.8 34.9-45.4 45.4-19.5 11-42.6 12.1-65 6.6-52.3-13.1-93.8-56.5-127.9-101.5-8.8-11.6-17.3-23.4-25.6-35.4-0.6-0.9-1.1-1.8-1.6-2.7-1.1-2.4-0.9-2.6 0.6-1.2 1 0.9 1.9 1.9 2.7 3 35.3 47.4 71.5 98.5 123.2 123.9 22.8 11.2 48.2 17.2 71.7 12.2 23-5 40.6-21.2 55.3-39.7 24.5-30.7 46.5-75.6 87.1-83 19.5-3.5 40.7 0.1 60.6 3.7 21.2 3.9 42.3 9.1 63.6 11.7 17.8 2.3 35.8-0.1 52.2-7 20-8.1 38.4-20.2 54.8-34.6 16.2-14.1 31-30.7 41.8-50.4 11.1-20.2 17-43.7 24.9-65.7 6.1-16.9 13.8-36.2 29.3-44.5 16.1-8.6 37.3-1.9 52.3 10.6 18.7 15.6 31.2 39.2 46.7 58.2" />
                <path class="fill-warning"
                    d="m1157.9 344.9c9.8 7.6 18.9 15.8 28.1 24 8.6 7.7 17.6 15.2 26 23.2 14.8 14.2 29.5 30.9 51.2 34.7 9.3 1.6 18.8 0.9 26.1-3.8 6.1-3.9 10.2-9.9 13.2-16.2 7.6-15.6 10.3-33.2 15.8-49.6 5.2-15.1 13.6-29 24.7-41.3 11.4-12.6 24.8-23.6 40-32.8 12.9-7.8 27.3-14.6 43.1-17.3 15.6-2.6 32.8-0.7 49 0.7 19.6 1.7 39.4 4 58.8 3.4 8.4-0.3 17-1.1 24.8-3.6 8.2-2.7 15.4-7.4 21.6-12.7 13.7-11.6 23.1-26.7 33.3-40.9 9.6-13.5 20.2-26.9 35.3-35.6 15.8-9.2 35.6-11.6 55.2-9.1 45.7 5.8 84.8 34.3 117.6 64.4 8.7 8 17.2 16.2 25.6 24.6 2.5 3.2 1.9 3-1.2 1-34.3-32-69.7-66.9-116.5-81.9-20.5-6.5-42.7-9.2-62.4-4-19.3 5.1-33.1 17.9-44.3 32.2-18.5 23.7-33.9 57.5-68.1 65.5-16.5 3.8-34.9 2.6-52.3 1.3-18.5-1.4-37-3.7-55.4-4.2-15.5-0.5-30.7 2.5-44.2 8.5-16.5 7.2-31.3 17.1-44.3 28.5-12.8 11.2-24.1 24.1-31.9 39-7.9 15.3-11.1 32.5-16.2 48.9-3.9 12.6-9 26.9-21.6 33.9-13.1 7.3-31.9 3.8-45.7-4.1-17.2-10-29.9-26.1-44.6-38.8" />
                <path class="fill-warning"
                    d="m1840.8 379c-8.8 40.3-167.8 79.9-300.2 45.3-42.5-11.1-91.4-32-138.7-11.6-38.7 16.7-55 66-90.8 67.4-25.1 1-48.6-20.3-58.1-39.8-31-63.3 50.7-179.9 155.7-208.1 50.4-13.5 97.3-3.2 116.1 1.6 36.3 9.3 328.6 87.4 316 145.2z" />
                <path class="fill-success"
                    d="M368.3,247.3C265.6,257.2,134,226,110.9,141.5C85,47.2,272.5-9.4,355.5-30.7s182.6-31.1,240.8-18.6    C677.6-31.8,671.5,53.9,627,102C582.6,150.2,470.9,237.5,368.3,247.3z" />
            </svg>
        </figure>
        <!-- SVG shape END -->
        <div class="position-relative">
            <p class="text-white m-0">
                {{ $platformSetting?->option?->slogan ?? '' }}
                <a href="{{ $platformSetting?->option?->slogan_link ?? '' }}" class="btn btn-xs btn-dark ms-3 mb-0">
                    {{ $platformSetting?->option?->slogan_button ?? '' }}
                </a>
            </p>
        </div>
        <!-- Close button -->
        <button type="button" class="btn-close btn-close-white opacity-9 p-3" data-bs-dismiss="alert"
            aria-label="Close"></button>
    </div>
    <!-- Top alert END -->

    <!-- Offcanvas START -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu">
        <div class="offcanvas-header justify-content-end">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column pt-0">
            <div>
                <img class="light-mode-item my-3" src="/assets/platform/images/logo.svg" alt="logo">
                <img class="dark-mode-item my-3" src="/assets/platform/images/logo-light.svg" alt="logo">
                <p>The next-generation blog, news, and magazine theme for you to start sharing your stories today! </p>
                <!-- Nav START -->
                <ul class="nav d-block flex-column my-4">
                    <li class="nav-item h5">
                        <a class="nav-link" href="index.html">Home</a>
                    <li class="nav-item h5">
                        <a class="nav-link" href="about-us.html">About</a>
                    </li>
                    <li class="nav-item h5">
                        <a class="nav-link" href="post-grid.html">Our Journal</a>
                    </li>
                    <li class="nav-item h5">
                        <a class="nav-link" href="contact-us.html">Contact Us</a>
                    </li>
                </ul>
                <!-- Nav END -->
                <div class="bg-primary bg-opacity-10 p-4 mb-4 text-center w-100 rounded">
                    <span>The Blogzine</span>
                    <h3>Save on Premium Membership</h3>
                    <p>Get the insights report trusted by experts around the globe. Become a Member Today!</p>
                    <a href="#" class="btn btn-warning">View pricing plans</a>
                </div>
            </div>
            <div class="mt-auto pb-3">
                <!-- Address -->
                <p class="text-body mb-2 fw-bold">New York, USA (HQ)</p>
                <address class="mb-0">750 Sing Sing Rd, Horseheads, NY, 14845</address>
                <p class="mb-2">Call: <a href="#" class="text-body"><u>469-537-2410</u> (Toll-free)</a> </p>
                <a href="#" class="text-body d-block">hello@blogzine.com</a>
            </div>
        </div>
    </div>
    <!-- Offcanvas END -->

    <!-- =======================
Header START -->
    <header class="navbar-light navbar-sticky header-static">
        <div class="navbar-top d-none d-lg-block small">
            <div class="container">
                <div class="d-md-flex justify-content-between align-items-center my-2">
                    <!-- Top bar left -->
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link ps-0" href="{{  url('about-us') }}">آکادمی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">سرمایه گذاری</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">مشاوره</a>
                        </li>
                        <li class="nav-item">
                            @if(auth()->user())
                            <a class="nav-link" href="{{ url('home') }}">پروفایل</a>
                            @else
                            <a class="nav-link" href="{{ url('login') }}">ورود / ثبت نام</a>
                            @endif
                        </li>
                    </ul>
                    <!-- Top bar right -->
                    <div class="d-flex align-items-center">
                        <!-- Font size accessibility START -->
                        <div class="btn-group me-3" role="group" aria-label="font size changer">
                            <input type="radio" class="btn-check" name="fntradio" id="font-sm">
                            <label class="btn btn-xs btn-outline-primary mb-0" for="font-sm">A-</label>

                            <input type="radio" class="btn-check" name="fntradio" id="font-default" checked>
                            <label class="btn btn-xs btn-outline-primary mb-0" for="font-default">A</label>

                            <input type="radio" class="btn-check" name="fntradio" id="font-lg">
                            <label class="btn btn-xs btn-outline-primary mb-0" for="font-lg">A+</label>
                        </div>

                        <!-- Dark mode options START -->
                        <div class="nav-item dropdown mx-2">
                            <!-- Switch button -->
                            <button class="modeswitch" id="bd-theme" type="button" aria-expanded="false"
                                data-bs-toggle="dropdown" data-bs-display="static">
                                <svg class="theme-icon-active">
                                    <use href="#"></use>
                                </svg>
                            </button>
                            <!-- Dropdown items -->
                            <ul class="dropdown-menu min-w-auto dropdown-menu-end" aria-labelledby="bd-theme">
                                <li class="mb-1">
                                    <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="light">
                                        <svg width="16" height="16" fill="currentColor"
                                            class="bi bi-brightness-high-fill fa-fw mode-switch me-1"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                                            <use href="#"></use>
                                        </svg>روشن
                                    </button>
                                </li>
                                <li class="mb-1">
                                    <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="dark">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-moon-stars-fill fa-fw mode-switch me-1"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
                                            <path
                                                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
                                            <use href="#"></use>
                                        </svg>تاریک
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center active"
                                        data-bs-theme-value="auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-circle-half fa-fw mode-switch me-1"
                                            viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                                            <use href="#"></use>
                                        </svg>اتوماتیک
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <!-- Dark mode options END -->
                        <ul class="nav">
                            @foreach ($socials as $social)
                                <li class="nav-item">
                                    <a target="_blank" class="nav-link px-2 fs-5"
                                        href="{{ $social['info']['link'] ?? "#!" }}"><i
                                            class="fab fa-{{ $social['info']['icon'] ?? "" }}"></i></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- Divider -->
                <div class="border-bottom border-2 border-primary opacity-1"></div>
            </div>
        </div>

        <!-- Logo Nav START -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo START -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="navbar-brand-item light-mode-item" src="/assets/platform/images/logo.svg" alt="logo">
                    <img class="navbar-brand-item dark-mode-item" src="/assets/platform/images/logo-light.svg"
                        alt="logo">
                </a>
                <!-- Logo END -->

                <!-- Responsive navbar toggler -->
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="text-body h6 d-none d-sm-inline-block">منو</span>
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Main navbar START -->
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav navbar-nav-scroll mx-auto">

                        <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}">صفحه نخست</a></li>

                        <!-- Nav item 2 Pages -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="pagesMenu" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">دسته بندی ها</a>
                            <ul class="dropdown-menu" aria-labelledby="pagesMenu">
                                @foreach ($categories as $category)
                                    <li> <a class="dropdown-item" href="/blogs/{{ $category['id'] }}">{{ $category['info']['title'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <!-- Nav item 4 Mega menu -->
                        <li class="nav-item dropdown dropdown-fullwidth">
                            <a class="nav-link dropdown-toggle" href="#" id="megaMenu" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"> رویداد ها</a>
                            <div class="dropdown-menu" aria-labelledby="megaMenu">
                                <div class="container">
                                    <div class="row g-4 p-3 flex-fill">
                                        @foreach ($banners as $banner)
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card bg-transparent">
                                                    <!-- Card img -->
                                                    <img class="card-img rounded"
                                                        src="{{ $banner['info']['banner'] ?? "" }}"
                                                        alt="{{ $banner['info']['title'] ?? "" }}">
                                                    <div class="card-body px-0 pt-3">
                                                        <h6 class="card-title mb-0">
                                                            <a href="{{ $banner['info']['link'] ?? "" }}" class="btn-link text-reset fw-bold">{{ $banner['info']['title'] ?? "" }}</a>
                                                        </h6>
                                                        <!-- Card info -->
                                                        <ul
                                                            class="nav nav-divider align-items-center text-uppercase small mt-2">
                                                            <li class="nav-item">
                                                                <a href="{{ $banner['info']['link'] ?? "" }}" class="text-reset btn-link">{{ $banner['info']['label'] ?? "" }}</a>
                                                            </li>
                                                            <li class="nav-item">{{ $banner['info']['created_at']['date'] }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div> <!-- Row END -->
                                    <!-- Trending tags -->
                                </div>
                            </div>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/about-us') }}">درباره ما</a></li>

                        @if(auth()->user())
                        <li class="nav-item"><a class="nav-link" href="{{ url('home') }}">پروفایل</a></li>
                            @else
                            <li class="nav-item"></li><a class="nav-link" href="{{ url('login') }}">ورود / ثبت نام</a></li>
                            @endif

                    </ul>
                </div>
                <!-- Main navbar END -->

                <!-- Nav right START -->
                <div class="nav flex-nowrap align-items-center">
                    <!-- Nav Button -->
                    <div class="nav-item d-none d-md-block">
                        <a href="{{ $socials[0]['info']['link'] }}" class="btn btn-sm btn-danger mb-0 mx-2">دنبال کنید</a>
                    </div>
                    <!-- Nav Search -->
                    <div class="nav-item dropdown dropdown-toggle-icon-none nav-search">
                        <a class="nav-link dropdown-toggle" role="button" href="#" id="navSearch"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-search fs-4"> </i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow rounded p-2" aria-labelledby="navSearch">
                            <form class="input-group">
                                <input class="form-control border-success" type="search" placeholder="Search"
                                    aria-label="Search">
                                <button class="btn btn-success m-0" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    <!-- Offcanvas menu toggler -->
                    <div class="nav-item">
                        <a class="nav-link p-0" data-bs-toggle="offcanvas" href="#offcanvasMenu" role="button"
                            aria-controls="offcanvasMenu">
                            <i class="bi bi-text-right rtl-flip fs-2" data-bs-target="#offcanvasMenu"> </i>
                        </a>
                    </div>
                </div>
                <!-- Nav right END -->
            </div>
        </nav>
        <!-- Logo Nav END -->
    </header>
    <!-- =======================
Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>
        @yield('content')
    </main>
    <!-- **************** MAIN CONTENT END **************** -->

    <!-- =======================
Footer START -->
    <footer class="bg-dark pt-5">
        <div class="container">
            <!-- About and Newsletter START -->
            <div class="row pt-3 pb-4">
                <div class="col-md-3">
                    <img src="/assets/platform/images/logo-footer.svg" alt="footer logo">
                </div>
                <div class="col-md-9">
                    <p class="text-body-secondary mb-0">{{ $platformSetting?->option?->description ?? "" }}</p>
                </div>
            </div>
            <!-- About and Newsletter END -->

            <!-- Divider -->
            <hr>

            <!-- Widgets START -->
            <div class="row pt-5">
                <!-- Footer Widget -->
                <div class="col-md-4 col-lg-4 mb-4">
                    <h5 class="mb-4 text-white">آخرین محتوا ها</h5>
                    @foreach ($blogs_data['latest'] as $blog)
                    <!-- Item -->
                    <div class="mb-4 position-relative">
                        <div><a href="/{{ $blog['type'] }}/{{ $blog['id'] }}" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>{{ $blog['info']['label'] }}</a></div>
                        <a href="/{{ $blog['type'] }}/{{ $blog['id'] }}" class="btn-link text-white fw-normal">
                            {{ $blog['info']['title'] }}
                        </a>
                        <ul class="nav nav-divider align-items-center small mt-2 text-body-secondary">
                           
                        <li class="nav-item">{{ $blog['info']['read'] }}</li>
                        <li class="nav-item">{{ $blog['info']['created_at']['date'] }}</li>
                        </ul>
                    </div>
                    @endforeach
                
                </div>

                <!-- Footer Widget -->
                <div class="col-md-4 col-lg-4 mb-4">
                    <h5 class="mb-4 text-white">دسته بندی ها</h5>
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav flex-column text-primary-hover">
                                @foreach ($categories as $category)
                                <li class="nav-item"><a class="nav-link" href="/blogs/{{ $category['id'] }}">{{ $category['info']['title'] }}</a></li>                                
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Footer Widget -->
                <div class="col-sm-4 col-lg-4 mb-4">
                    <h5 class="mb-4 text-white">شبکه های اجتماعی</h5>
                    <ul class="nav flex-column text-primary-hover">
                        @foreach ($socials as $social)
                            <li class="nav-item">
                                <a class="nav-link pt-0" href="{{ $social['info']['link'] }}">
                                    <i class="fab fa-{{ $social['info']['icon'] }} fa-fw me-2"></i>
                                    {{ $social['info']['title'] }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>

            </div>
            <!-- Widgets END -->

        </div>

        <!-- Footer copyright START -->
        <div class="bg-dark-overlay-3 mt-5">
            <div class="container">
                <div class="row align-items-center justify-content-md-between py-4">
                    <div class="col-md-12">
                        <!-- Copyright -->
                        <div class="text-center text-md-start text-primary-hover text-body-secondary">©2024 تمامی حقوق مادی و معنوی متعلق به
                            <a href="{{ url('/') }}" class="text-reset btn-link" target="_blank">{{ env('APP_NAME') }}</a> میباشد.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer copyright END -->
    </footer>
    <!-- =======================
Footer END -->

    <!-- Back to top -->
    <div class="back-top"><i class="bi bi-arrow-up-short"></i></div>

    <!-- =======================
JS libraries, plugins and custom scripts -->

    <!-- Bootstrap JS -->
    <script src="/assets/platform/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vendors -->
    <script src="/assets/platform/vendor/tiny-slider/tiny-slider.js"></script>
    <script src="/assets/platform/vendor/sticky-js/sticky.min.js"></script>
    <script src="/assets/platform/vendor/plyr/plyr.js"></script>

    <!-- Template Functions -->
    <script src="/assets/platform/js/functions.js"></script>
</body>

</html>