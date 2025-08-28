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
    <!-- navbar -->
    <div class="border-bottom">
        <div class="py-5">
            <div class="container">
                <div class="row w-100 align-items-center gx-lg-2 gx-0">
                    <div class="col-xxl-2 col-lg-2 col-md-6 col-5">
                        <a class="navbar-brand d-none d-lg-block" href="{{  url('/') }}">
                            <img class="logo-img" src="{{ asset('logo.webp')}}?v=3" alt="{{ env('APP_NAME') }}"
                                title="{{ env('APP_NAME') }}" />
                        </a>
                        <div class="d-flex justify-content-between w-100 d-lg-none">
                            <a class="navbar-brand" href="{{  url('/') }}">
                                <img class="logo-img" src="{{ asset('logo.webp')}}?v=3" alt="{{ env('APP_NAME') }}"
                                    title="{{ env('APP_NAME') }}" />
                            </a>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-lg-8 d-none d-lg-block">
                        <form action="{{ route('products') }}">
                            <div class="input-group">
                                <input class="form-control rounded" name="search" type="search"
                                    placeholder="{{trans("message.enter_word")}}" />
                                <span class="input-group-append">
                                    <button class="btn bg-white border border-end-0 ms-n10 rounded-0 rounded-start"
                                        type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-search">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-2 col-xxl-2 text-start col-md-6 col-7">
                        <div class="list-inline">

                            <div class="list-inline-item ms-5">
                                <a href="{{ route('profile') }}" class="text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </a>
                            </div>
                            <div class="list-inline-item ms-5 me-lg-0">
                                <button class="btn p-0 text-muted position-relative" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight" type="button" role="button"
                                    aria-controls="offcanvasRight">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-shopping-bag">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                                    </svg>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                        1
                                        <span class="visually-hidden">سفارش</span>
                                    </span>
                                </button>
                            </div>
                            <div class="list-inline-item d-inline-block d-lg-none">
                                <!-- Button -->
                                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#navbar-default" aria-controls="navbar-default"
                                    aria-label="Toggle navigation">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                        class="bi bi-text-indent-left text-primary" viewBox="0 0 16 16">
                                        <path
                                            d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light navbar-default py-0 pb-lg-4"
            aria-label="Offcanvas navbar large">
            <div class="container">
                <div class="offcanvas offcanvas-end" tabindex="-1" id="navbar-default"
                    aria-labelledby="navbar-defaultLabel">
                    <div class="offcanvas-header pb-1">
                        <a href="{{ url('/') }}"><img height="55" src="{{ asset('logo.webp')}}?v=3"
                                title="{{ env('APP_NAME') }}" alt="{{ env('APP_NAME') }}" /></a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="d-block d-lg-none mb-4">
                            <form action="{{ route('products') }}">
                                <div class="input-group">
                                    <input class="form-control rounded" name="search" type="search"
                                        placeholder="{{trans("message.enter_word")}}" />
                                    <span class="input-group-append">
                                        <button class="btn bg-white border border-end-0 ms-n10 rounded-0 rounded-start"
                                            type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="d-block d-lg-none mb-4">
                            <a class="btn btn-primary w-100 d-flex justify-content-center align-items-center"
                                data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                                aria-controls="collapseExample">
                                <span class="ms-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-grid">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg>
                                </span>
                                {{trans("message.categories")}}
                            </a>
                            <div class="collapse mt-2" id="collapseExample">
                                <div class="card card-body">
                                    <ul class="mb-0 list-unstyled">
                                        @foreach ($categories as $category)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('products.category', [$category['id']]) }}">
                                                    {{ $category['info']['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown ms-3 d-none d-lg-block">
                            <button class="btn btn-primary px-6" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="ms-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-grid">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg>
                                </span>
                                {{trans("message.categories")}}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                @foreach ($categories as $category)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('products.category', [$category['id']]) }}">
                                            {{ $category['info']['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <ul class="navbar-nav align-items-center">

                                <li class="nav-item w-100 w-lg-auto">
                                    <a class="nav-link" href="{{ url('/') }}">{{trans("message.first_page")}}</a>
                                </li>

                                <li class="nav-item w-100 w-lg-auto">
                                    <a class="nav-link" href="{{ route('products') }}">{{trans("message.products")}}</a>
                                </li>

                                <li class="nav-item w-100 w-lg-auto">
                                    <a class="nav-link" href="{{ route('posts') }}">{{trans("message.blog")}}</a>
                                </li>

                                <li class="nav-item w-100 w-lg-auto">
                                    <a class="nav-link" href="{{ route('aboutUs') }}">{{trans("message.about_us")}}</a>
                                </li>

                                <li class="nav-item w-100 w-lg-auto">
                                    <a class="nav-link" href="{{ route('faq') }}">{{trans("message.faq")}}</a>
                                </li>

                                <li class="nav-item w-100 w-lg-auto">
                                    <a class="nav-link"
                                        href="{{ route('user.orders') }}">{{trans("message.orders")}}</a>
                                </li>

                                <li class="nav-item w-100 w-lg-auto">
                                    <a class="nav-link" href="{{ route('profile') }}">{{trans("message.profile")}}</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Shop Cart -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <div class="text-end">
                <h5 id="offcanvasRightLabel" class="mb-0 fs-4">{{trans("message.create_order")}}</h5>
                <small>
                    {{trans("message.customize_your_certain")}} 
                    <span class="d-block">درصورت نیاز به راهنمایی با شماره 
                        <b><a href="tel:{{ $setting->option->tel ?? "" }}">{{ $setting->option->tel ?? "" }}</a></b>
                        تماس حاصل فرمایید.
                    </span>
                </small>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <div class="wizard my-5">
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{trans("message.step_1")}}">
                        <a disabled
                            class="nav-link active rounded-circle mx-auto d-flex align-items-center justify-content-center"
                            href="#step1" id="step1-tab" data-bs-toggle="tab" role="tab" aria-controls="step1"
                            aria-selected="true">
                            <span>{{trans("message.curtain_width")}}</span>
                        </a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{trans("message.step_2")}}">
                        <a disabled
                            class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                            href="#step2" id="step2-tab" data-bs-toggle="tab" role="tab" aria-controls="step2"
                            aria-selected="false" title="Step 2">
                            <span>انتخاب کناره</span>
                        </a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{trans("message.step_3")}}">
                        <a disabled
                            class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                            href="#step3" id="step3-tab" data-bs-toggle="tab" role="tab" aria-controls="step3"
                            aria-selected="false" title="Step 3">
                            <span>
                                انتخاب پرده
                            </span>
                        </a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{trans("message.step_4")}}">
                        <a disabled
                            class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                            href="#step4" id="step4-tab" data-bs-toggle="tab" role="tab" aria-controls="step4"
                            aria-selected="false" title="Step 4">
                            <span>
                                دوخت و ابزار
                            </span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <p class="wizard-error hidden"></p>
                    <div class="tab-pane fade show active" role="tabpanel" id="step1" aria-labelledby="step1-tab">
                        <div class="pt-5">
                            <h3>{{trans("message.curtain_width")}}</h3>
                            <p>{{ trans('message.add_your_curtain_width') }}</p>


                            <div class="w-100 position-relative window-width">
                                <img class="w-100 rounded lazy" data-src="{{ asset('assets/images/window.png') }}" />
                                <p>عرض پنجره</p>
                            </div>

                            <div dir="ltr" id="ruler-runner"></div>

                            <div class="d-flex mt-9 justify-content-between">
                                <button class="ruler-button rm">{{trans("message.decrease_25_cm")}}</button>
                                <div>
                                    <input id="curtain-width" type="number" name="ruler" min="0" max="12" step=".25"
                                        value="0">
                                    <p class="curtain-width-cm">{{trans("message.meter")}}</p>
                                </div>
                                <button class="ruler-button add">{{trans("message.increase_25_cm")}}</button>
                            </div>

                            <p class="curtain-width-label-text">
                                <span>
                                    {{trans("message.your_curtain_width_is_v1")}}
                                    <span id="curtain-width-label">{{trans("message.0_cm")}}</span>
                                    {{trans("message.your_curtain_width_is_v2")}}
                                </span>
                                <a class="next next-wizard no" step="1"
                                    error="{{trans("message.must_be_more_than_0_cm")}}">{{trans("message.next_step")}}<i
                                        class="fa fa-angle-right"></i></a>
                            </p>
                        </div>
                    </div>
                    <div class="tab-pane fade" role="tabpanel" id="step2" aria-labelledby="step2-tab">
                        <div class="pt-5">
                            <h3>اتنخاب کناره</h3>
                            <p>نوع کناره خود را انتخاب کنید</p>
                            <section class="section-services">
                                <div class="">
                                    <div class="row g-4 row-cols-lg-3 row-cols-2 row-cols-md-3" id="set-sides">
                                    </div>
                                </div>
                            </section>
                            <div class="d-flex justify-content-between mt-5 ">
                                <a class="previous previous-wizard"><i class="fa fa-angle-left"></i> مرحله قبل</a>
                                <div class="next next-wizard no" step="2" onclick=""
                                    error="لطفا نوع کناره خود را انتخاب کنید">
                                    <div class="dropdown-do-toggle" data-bs-toggle="">
                                        {{trans("message.next_step")}}
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                    <ul class="dropdown-menu hidden">
                                        <li><a class="dropdown-item next chin" value="1" step="2" href="#"
                                                onclick="porchin_kamchin='kamchin'">
                                                کم
                                                چین
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item next chin" value="2" step="2" href="#"
                                                onclick="porchin_kamchin='porchin'">پرچین</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" role="tabpanel" id="step3" aria-labelledby="step3-tab">
                        <div class="pt-5">
                            <h3>اتنخاب پرده</h3>
                            <p>.بر روی حریر و کناره کلیک نمایید و مورد مورد نظر خود را انتخاب نمایید</p>
                            <div>
                                <div class="parde-preview"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-5 ">
                                <a class="previous previous-wizard"><i class="fa fa-angle-left"></i> مرحله قبل</a>
                                <a class="next next-wizard no" step="3"
                                    error="لطفا حریر/کناره پرده خود را انتخاب نمایید">{{trans("message.next_step")}}<i
                                        class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" role="tabpanel" id="step4" aria-labelledby="step4-tab">
                        <div class="pt-5">
                            <h3>دوخت</h3>
                            <p>نوع دوخت خود را مشخص نمایید</p>
                            <div>
                                <div class="list-group">
                                    <label class="list-group-item d-flex gap-3 pt-3">
                                        <input class="form-check-input flex-shrink-0" type="radio" name="dookht-type"
                                            value="1" checked>
                                        <div>
                                            <strong class="d-block">پانچ (پنل آماده)</strong>
                                            <small class="text-muted">ارتفاع پنل های آماده 2 متر و 80 سانت میباشد که
                                                شامل گارانتی 48 ساعته، تعویض مرجوعی بی قید و شرط می باشد.</small>
                                        </div>
                                    </label>

                                    <label class="list-group-item d-flex gap-3 pt-3">
                                        <input class="form-check-input flex-shrink-0" type="radio" name="dookht-type"
                                            value="3">
                                        <div>
                                            <strong class="d-block">پانچ (پنل سفارشی)</strong>
                                            <small class="text-muted">ارتفاع پنل های آماده 2 متر و 80 سانت میباشد که
                                                شامل گارانتی 48 ساعته، تعویض مرجوعی بی قید و شرط می باشد.</small>
                                        </div>
                                    </label>

                                    <label class="list-group-item d-flex gap-3 pt-3">
                                        <input class="form-check-input flex-shrink-0" type="radio" name="dookht-type"
                                            value="2">
                                        <div>
                                            <strong class="d-block">مینیمال (ارتفاع سفارشی)</strong>
                                            <small class="text-muted">
                                                ارتفاع برابراست با سقف تا زمین 5 سانتی متر (بادخور) می باشد
                                                <br>
                                                نکته:
                                                اگر دیواری نصب می شود از جایی که به دیوار می زنید تا روی زمین 5
                                                سانتی
                                                متر
                                                بادخور داشته باشد
                                            </small>
                                        </div>
                                    </label>
                                </div>
                                <div class="mt-4 hidden curtain-height">
                                    <label class="form-label" for="height">
                                        ارتفاع را وارد نمایید
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="int" id="height" class="form-control" name="height"
                                        placeholder="ارتفاع پنجره خود را وارد نمایید" />
                                </div>
                            </div>

                            <div class="pt-5">
                                <h3>نوع پایه</h3>
                                <p>نوع پایه مورد نیاز خود را انتخاب نمایید</p>
                                <div>
                                    <div class="list-group">
                                    <label class="list-group-item d-flex gap-3 pt-3">
                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                name="base-type" value="1" checked>
                                            <div>
                                                <strong class="d-block">دیواری</strong>
                                            </div>
                                        </label>
                                        <label class="list-group-item d-flex gap-3 pt-3">
                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                name="base-type" value="2">
                                            <div>
                                                <strong class="d-block">سقفی</strong>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-5">
                                <h3>ابزار </h3>
                                <p>درصورت نیاز به ابزار، ابزار مورد نیاز خود را انتخاب نمایید</p>
                                <div>
                                    <div class="list-group">
                                        <label class="list-group-item d-flex gap-3 pt-3">
                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                name="curtain-tool" value="0" checked>
                                            <div>
                                                <strong class="d-block">میله ابزار دارم و نمیخواهم</strong>
                                            </div>
                                        </label>
                                        @foreach (collectProducts($products, $setting?->option?->curtain_tools ?? []) as $product)
                                            <label class="list-group-item d-flex gap-3 pt-3 tool-panch">
                                                <input class="form-check-input flex-shrink-0" type="radio"
                                                    name="curtain-tool" value="{{ $product['id'] }}">
                                                <div class="d-flex">
                                                    <img 
                                                        width="60"
                                                        height="60"
                                                        class="ms-4 rounded"
                                                        src="{{ $product['info']['banner'] ?? "" }}" alt="{{ $product['info']['title'] ?? "" }}" title="{{ $product['info']['title'] ?? "" }}"/>
                                                    <div>
                                                        <strong class="d-block">{{ $product['info']['title'] ?? "" }}</strong>
                                                        <small class="text-muted">
                                                            {{ number_format($product['info']['final_price']) }}
                                                            <b>تومان</b>
                                                        </small>
                                                        <p class="curtain-tool-info">قیمت همراه
                                                            قپه و
                                                            پایه به تعداد نیاز میباشد.</p>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                        @foreach (collectProducts($products, $setting?->option?->curtain_tools_minimal ?? []) as $product)
                                            <label class="list-group-item d-flex gap-3 pt-3 tool-minimal hidden">
                                                <input class="form-check-input flex-shrink-0" type="radio"
                                                    name="curtain-tool" value="{{ $product['id'] }}">
                                                <div class="d-flex">
                                                    <img 
                                                        width="50"
                                                        height="50"
                                                        class="ms-4 rounded"
                                                        src="{{ $product['info']['banner'] ?? "" }}" alt="{{ $product['info']['title'] ?? "" }}" title="{{ $product['info']['title'] ?? "" }}"/>
                                                    <div>
                                                        <strong class="d-block">{{ $product['info']['title'] ?? "" }}</strong>
                                                        <small class="text-muted">
                                                            {{ number_format($product['info']['final_price']) }}
                                                            <b>تومان</b>
                                                        </small>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach

                                    </div>
                                </div>
                            </div>


                            <div class="pt-5 curtain-length-box hidden">
                                <h3>طول میله</h3>
                                <p>پس از انتخاب ابزار قیمت در طول میله ضرب خواهد شد</p>
                                <div>
                                    <div class="list-group">
                                        <label class="list-group-item d-flex gap-3 pt-3">
                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                name="rod-length-type" value="1">
                                            <div>
                                                <strong class="d-block">دستی</strong>
                                                <small class="text-muted">
                                                    طول میله خود را به صورت دستی وارد نمایید
                                                </small>
                                            </div>
                                        </label>

                                        <label class="list-group-item d-flex gap-3 pt-3">
                                            <input class="form-check-input flex-shrink-0" type="radio"
                                                name="rod-length-type" value="2" checked>
                                            <div>
                                                <strong class="d-block">
                                                    اتوماتیک
                                                </strong>
                                                <small class="text-muted">
                                                    طول میله شما به صورت اتوماتیک برابر است با عرض پنجره شما به
                                                    علاوه 20
                                                    سانتی متر
                                                </small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="mt-4 hidden curtain-length">
                                        <label class="form-label" for="length">
                                            طول میله را وارد نمایید
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="int" id="length" class="form-control" name="length"
                                            placeholder="طول میله خود را وارد نمایید" />
                                    </div>
                                </div>

                            </div>


                            <div class="pt-5">
                                <h3> نکته نظر </h3>
                                <p>در صورت داشتن نکته نظر وارد نمایید</p>
                                <div>
                                    <textarea name="description" class="form-control w-100 border-1 color-black rounded p-3" placeholder="نکته نظرات خود را وارد نمایید"></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5 ">
                                <a class="previous previous-wizard"><i class="fa fa-angle-left"></i> مرحله قبل</a>
                                <a class="next next-wizard" step="4"
                                    error="برای ثبت سفارش میبایست دوخت، ابزار و طول میله را مشخص نمایید">{{trans("message.next_step")}}<i
                                        class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <p class="wizard-error hidden"></p>

                </div>
            </div>

        </div>
    </div>

    <main>
        <div class="order-button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" type="button"
            role="button" aria-controls="offcanvasRight">
            <span class="blinking-dot mx-2"></span>
            <p>برای سفارش خرید مرحله ای <b>کلیک کنید</b></p>
            <span class="blinking-dot mx-2"></span>
        </div>

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
    @include('layouts.footer')
    <script>
        const setting = @json($setting);
        const products = @json($products);
        const categories = @json($categories);
        const kenarehs = setting.option.kenareh_ids;
        const harirs = setting.option.harir_ids;
        const curtain_tools = setting.option.curtain_tools;
        const height_conf = setting.option.height_conf;
        const sides = @json(sides());
        const logined = {{ auth()->user() ? "true" : "false" }};
        const verified = {{ auth()?->user()?->username_verified_at ? "true" : "false" }};
        const runner = [];
        var porchin_kamchin = "";
        var cartDetail = null;
        function setChin(chin){
            porchin_kamchin = chin;
        }

        function addToCart() {
            $('.next[step=4]').removeClass('no');
            cartDetail = null;
            var width = Number($('#curtain-width').val()) ?? 0;
            width = width * 100;
            var from = Number($('[name="from"]:checked').val());
            var orders = [];
            $('.curtain-part').each(function () {
                var type = "kenareh";
                var id = Number($(this).attr('value')) ?? 0;
                if ($(this).hasClass('harir')) {
                    type = "harir";
                }
                orders.push({ type, id, amount: 1 });
            });
            var dookht = Number($('[name="dookht-type"]:checked').val());
            var height = Number($('#height').val()) ?? 0;
            var tool = Number($('[name="curtain-tool"]:checked').val());
            var rod = Number($('[name="rod-length-type"]:checked').val());
            var base_type = Number($('[name="base-type"]:checked').val());
            var length = Number($('#length').val()) ?? 0;
            var description = $('textarea[name="description"]').val() ?? "";

            if (tool > 0) {
                orders.push({ type: "tool", id: tool, amount: 1 });
            }

            if ((dookht == 2 || dookht == 3) && height == 0) {
                return $('.next[step=4]').addClass('no');
            }

            if (tool > 0 && rod == 1 && length == 0) {
                return $('.next[step=4]').addClass('no');
            }

            $('.next[step=4]').removeClass('no');

            cartDetail = {
                width,
                from,
                orders,
                dookht,
                height,
                tool,
                rod,
                length,
                porchin_kamchin,
                base_type,
                description
            };
        }

        function submitCart() {
            $.ajax({
                url: '/profile/orders',
                method: "POST",
                data: cartDetail,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                success: function () {
                    return window.location.href = "/profile/orders/current-cart";
                },
                complete: function () {

                },
                error: function (res) {
                    var response = res.responseJSON;
                    $('.tab-content .alert').remove();
                    $('.tab-content').append(`
                        <div class="alert alert-danger d-flex align-items-center rounded-0 mb-0 mt-4" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-exclamation-triangle-fill ms-2" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                            <div>
                                ${response.message}
                            </div>
                        </div>
                    `)
                }
            })
        }

    </script>

    <script>

function renderPoducts(type, box = null) {

    type = type.map(function (e) {
        return Number(e)
    })

    var elms = "";
    var i = 0;
    for(var t of type){
        i++;
        var cate = categories.find(e => e.id == t)
        elms = elms + `
<div class="accordion mb-2" id="accordion-${t}">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <div class="accordion-button ${i == 1 ? "" : "collapsed"} ps-2"  ${i == 1 ? "aria-expanded='true'" : "aria-expanded='false'"} data-bs-toggle="collapse" data-bs-target="#collapse-${t}" >
                <div class="cats-cord">
                <div class="d-flex mb-2 info">
                    <img src="${cate.info.logo}" width=50 height=50 />
                    <p class="mb-0">${cate.info.title}</p>
                </div>
                <div class="d-flex">
                    <i class="feather-icon icon-video ms-2"></i>
                    <a href="${cate.info.blog}" target="_blank" >دیدن ویدیو معرفی محصول</a> 
                </div>
            </div>
        </h2>
        <div id="collapse-${t}" class="accordion-collapse collapse ${i == 1 ? "show" : ""}" data-bs-parent="#accordion-${t}">
            <div class="accordion-body p-2 text-end">
        `;

        var all = products.map(function(e){
            var data = e.info;
            data.id = e.id;
            data.categories = e.parents.map(function(item){
                return Number(item.id);
            });
            return data
        });
        const filtered = all.filter(item => item.categories.includes(Number(t)));

        for(var e of filtered){
            elms += `
                <label class="list-group-item d-flex gap-3 align-items-start choose-product" value="${e.id}">
                    <img src="${e.vector}" alt="${e.title}" width="50" height="50" class="rounded">
                    <div>
                        <strong class="d-block">${e.title}</strong>
                        <small class="text-muted">${Number(e.final_price).toLocaleString('en-US')} <b>تومان</b></small>
                    </div>
                </label>
            `;
        }

        elms = elms + `
            </div>
        </div>
    </div>
</div>
        `
    }

    return elms;



    console.log(type)
    var id = new Date().getTime();
    id = `id_${id}`
    var all = products.map(function (e) {
        var data = e.info;
        data.id = e.id;
        data.categories = e.parents;
        return data
    });
    all = all.filter(function (items) {
        var parents = items?.categories.map(function (e) {
            return e.id
        }) ?? [];
        var status = false;
        for (var parent of parents) {
            if (type.includes(Number(parent))) {
                status = true;
            }
        }
        return status;
    })
    if (box) {
        var elements = ``;
        for (var e of all) {
            elements += `
                <label class="list-group-item d-flex gap-3 align-items-start choose-product" value="${e.id}">
                    <img src="${e.vector}" alt="${e.title}" width="35" height="35" class="rounded">
                    <div>
                        <strong class="d-block">${e.title}</strong>
                        <small class="text-muted">${Number(e.final_price).toLocaleString('en-US')} <b>تومان</b></small>
                    </div>
                </label>
            `;
        }
        return elements;
    } else {
        return all;
    }
}
    </script>

    <script src="{{ asset('build/main.min.js') }}?v={{ siteSetting()['assets']['js']['main'] }}" async></script>
</body>

</html>