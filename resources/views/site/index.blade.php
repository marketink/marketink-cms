@extends('layouts.app')

@section('beforeHead')
    @foreach ($sliders as $slider)
        <link rel="preload" as="image" href="{{ $slider['info']['banner'] ?? "" }}" fetchpriority="high" />
    @endforeach
@endsection

@section('content')

    @if(count($sliders) > 0)
        <section class="mt-lg-8 mt-4">
            <div class="container">
                <div class="hero-slider">
                    @foreach ($sliders as $slider)
                        <div class="position-relative rounded">
                            <img class="w-100 h-100 rounded object-fit-cover" 
                                src="{{ $slider['info']['banner'] ?? "" }}"
                                alt="{{ $slider['info']['title'] ?? "" }}" 
                                title="{{ $slider['info']['title'] ?? "" }}" 
                                loading="eager"
                            />
                            <div
                                class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center position-absolute w-100 top-0">
                                <span class="badge text-bg-warning">{{ $slider['info']['subtitle'] ?? "" }}</span>
                                <h2 class="text-dark slider-title display-5 fw-bold mt-4">{{ $slider['info']['title'] ?? "" }}</h2>
                                <p class="lead slider-subtitle">{{ $slider['info']['body'] ?? "" }}</p>
                                <a href="{{ $slider['info']['link'] ?? "" }}" class="btn btn-dark mt-3">
                                    {{ $slider['info']['label'] ?? "" }}
                                    <i class="feather-icon icon-arrow-left me-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($categories) > 0)
        <section class="mb-4 mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-6">
                        <h3 class="mb-0">{{trans("message.categories")}}</h3>
                    </div>
                </div>
                <div class="category-slider">
                    @foreach ($categories as $category)
                        <div class="item">
                            <a href="{{ route('products.category', [$category['id']]) }}" class="text-decoration-none text-inherit">
                                <div class="card card-product mb-lg-4">
                                    <div class="card-body text-center py-4">
                                        <img data-src="{{ $category['info']['logo'] ?? "" }}" src="{{ asset('placeholder.webp') }}"
                                            alt="{{ $category['info']['title'] ?? "" }}"
                                            title="{{ $category['info']['title'] ?? "" }}"
                                            class="mb-4 img-fluid object-fit-cover rounded lazy mx-auto" loading="lazy" />
                                        <div class="text-truncate">{{ $category['info']['title'] ?? "" }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif

    @if(count($banners) > 0)
        <section>
            <div class="container">
                <div class="row">
                    @foreach ($banners as $banner)
                        <div class="col-12 col-md-6 mb-0 mb-lg-3 px-1">
                            <div>
                                <div class="py-2 px-2 rounded position-relative">
                                    <img data-src="{{ $banner['info']['banner'] ?? "" }}" src="{{ asset('placeholder.webp') }}" class="w-100 h-100 rounded lazy" loading="lazy"
                                        alt="{{ $banner['info']['title'] ?? "" }}" title="{{ $banner['info']['title'] ?? "" }}" />
                                    <div class="position-absolute translate-middle-y top-50 me-4">
                                        <h3 class="fw-bold mb-1 slider-title">{{ $banner['info']['title'] ?? "" }}</h3>
                                        <p class="mb-4">{{ $banner['info']['subtite'] ?? "" }}</p>
                                        <a href="{{ $banner['info']['link'] ?? "" }}" alt="{{ $banner['info']['title'] ?? "" }}"
                                            title="{{ $banner['info']['title'] ?? "" }}"
                                            class="btn btn-dark slider-link">{{ $banner['info']['label'] ?? "" }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($products) > 0)
        <section class="my-8">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-6">
                        <h3 class="mb-0">{{trans("message.products")}}</h3>
                    </div>
                </div>
                <div class="row g-4 row-cols-lg-4 row-cols-2 row-cols-md-4">
                    @foreach (collectProducts($products)->take(8) as $product)

                        <div class="col">
                            <div class="card card-product">
                                <div class="card-body">
                                    <div class="text-center position-relative">
                                        @if(isset($product['info']['label']))
                                            <div class="position-absolute top-0 start-0 mt-1 ms-1">
                                                <span class="badge bg-danger">{{ $product['info']['label'] ?? "" }}</span>
                                            </div>
                                        @endif
                                        <a href="{{ route('product', [$product['id']]) }}"
                                            alt="{{ $product['info']['title'] ?? "" }}"
                                            title="{{ $product['info']['title'] ?? "" }}">
                                            <img data-src="{{ $product['info']['banner'] ?? "" }}" src="{{ asset('placeholder.webp') }}" class="mb-3 img-fluid lazy" loading="lazy"
                                                alt="{{ $product['info']['title'] ?? "" }}"
                                                title="{{ $product['info']['title'] ?? "" }}" />
                                        </a>
                                    </div>
                                    @if(count($product['parents']) > 0)
                                        <div class="text-small mb-1">
                                            <a alt="{{ $product['parents'][0]['info']['title'] ?? "" }}"
                                                title="{{ $product['parents'][0]['info']['title'] ?? "" }}"
                                                href="{{ route('products.category', $product['parents'][0]['id']) }}"
                                                class="text-decoration-none text-muted text-limit"><small>{{ $product['parents'][0]['info']['title'] ?? "" }}</small></a>
                                        </div>
                                    @endif

                                    <h2 class="fs-6">
                                        <a href="{{ route('product', [$product['id']]) }}"
                                            alt="{{ $product['info']['title'] ?? "" }}"
                                            title="{{ $product['info']['title'] ?? "" }}"
                                            class="text-inherit text-decoration-none text-limit">
                                            {{ $product['info']['title'] ?? "" }}
                                        </a>
                                    </h2>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            @if(isset($product['info']['discount']) && $product['info']['discount'] > 0)
                                                <span class="text-dark">
                                                    {{ number_format($product['info']['final_price'] ?? "")}}
                                                </span>
                                                <span class="text-decoration-line-through text-muted">
                                                    {{ number_format($product['info']['price'] ?? "") }}
                                                </span>
                                                <b>
                                                    <small>{{ $product['info']['currency_label'] ?? "" }}</small>
                                                </b>
                                            @endif
                                            @if(!isset($product['info']['discount']) || $product['info']['discount'] == 0)
                                                <span class="text-dark">
                                                    {{ number_format($product['info']['final_price'] ?? "") }}</span>
                                                <b><small>{{ $product['info']['currency_label'] ?? "" }}</small></b>
                                            @endif
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasRight" role="button" aria-controls="offcanvasRight"
                                                aria-label="{{ $product['info']['title'] ?? "" }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-plus">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($introduces) > 0)
        <section class="my-8">
            <div class="container">
                <div class="row">
                    @foreach ($introduces as $introduce)
                        <div class="col-md-6 col-lg-3">
                            <div class="mb-8 mb-xl-0">
                                <div class="mb-6">
                                    <img data-src="{{ $introduce['info']['icon'] ?? "" }}" src="{{ asset('placeholder.webp') }}" class="object-fit-cover rounded lazy" loading="lazy"
                                        width="50" height="50" alt="{{ $introduce['info']['title'] ?? "" }}"
                                        title="{{ $introduce['info']['title'] ?? "" }}" />
                                </div>
                                <h3 class="h5 mb-3">{{ $introduce['info']['title'] ?? "" }}</h3>
                                <p>{{ $introduce['info']['body'] ?? "" }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection