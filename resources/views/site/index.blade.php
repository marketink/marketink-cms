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

@endsection