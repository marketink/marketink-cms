@extends('layouts.app')

@section('content')
    <style>
        .tns-inner {
            direction: ltr
        }
    </style>
    <?php $items = collectProducts($products, collect($product['parents'] ?? [])->pluck('id')->toArray()); ?>
    <div class="mt-4">
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-12">
                    <!-- breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans("message.first_page")}}</a></li>
                            @foreach ($product['parents'] ?? [] as $category)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('products.category', [$category['id']]) }}">
                                        {{ $category['info']['title'] }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $product['info']['title'] ?? "" }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="mt-8 mb-8">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-xl-6">
                    <!-- img slide -->
                    <div class="product productModal" id="productModal" dir="ltr">
                        <div class="zoom" onmousemove="zoom(event)"
                            style="background-image: url({{ $product['info']['banner'] ?? "" }})">
                            <img src="{{ $product['info']['banner'] ?? "" }}" alt="{{ $product['info']['title'] ?? "" }}"
                                title="{{ $product['info']['title'] ?? "" }}" />
                        </div>
                        <div class="zoom" onmousemove="zoom(event)"
                            style="background-image: url({{ $product['info']['experience'] ?? "" }})">
                            <img src="{{ $product['info']['experience'] ?? "" }}"
                                alt="{{ $product['info']['title'] ?? "" }}" title="{{ $product['info']['title'] ?? "" }}" />
                        </div>
                    </div>
                    <!-- product tools -->
                    <div class="product-tools" dir="ltr">
                        <div class="thumbnails row g-3" id="productModalThumbnails">
                            <div class="col-3">
                                <div class="thumbnails-img">
                                    <img src="{{ $product['info']['banner'] ?? "" }}"
                                        alt="{{ $product['info']['title'] ?? "" }}"
                                        title="{{ $product['info']['title'] ?? "" }}" />
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="thumbnails-img">
                                    <!-- img -->
                                    <img src="{{ $product['info']['experience'] ?? "" }}"
                                        alt="{{ $product['info']['title'] ?? "" }}"
                                        title="{{ $product['info']['title'] ?? "" }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-xl-6">
                    <div class="ps-lg-10 mt-6 mt-md-0">
                        <!-- content -->
                        @if(count($product['parents']) > 0)
                            <a href="{{ route('products.category', $product['parents'][0]['id']) }}" class="mb-4 d-block">
                                {{ $product['parents'][0]['info']['title'] ?? "" }}
                            </a>
                        @endif
                        <!-- heading -->
                        <h1 class="mb-1">{{ $product['info']['title'] ?? "" }}</h1>
                        <div class="mb-4">
                            <p class="text-box">{!! nl2br($product['info']['body'] ?? "") !!}</p>
                        </div>
                        <div class="fs-4">

                            <span class="fw-bold text-dark">
                                {{ number_format($product['info']['final_price'] ?? "") }}
                                <b>
                                    <small>
                                        {{ $product['info']['currency_label'] ?? "" }}
                                    </small>
                                </b>
                            </span>

                            @if(isset($product['info']['discount']) && $product['info']['discount'] > 0)
                                <span class="text-decoration-line-through text-muted">
                                    {{ number_format($product['info']['price'] ?? "") }}
                                    <b>
                                        <small>
                                            {{ $product['info']['currency_label'] ?? "" }}
                                        </small>
                                    </b>
                                </span>
                                <span><small class="fs-6 ms-2 text-danger">{{ $product['info']['discount'] }}%
                                        {{trans("message.discount")}}</small></span>
                            @endif
                        </div>
                        <hr class="my-6 mb-2" />

                        <div class="mt-3 row justify-content-start g-2 align-items-center">
                            <div class="col-6 d-grid">
                                <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight" href="#offcanvasExample" role="button"
                                    aria-controls="offcanvasRight">
                                    <i class="feather-icon icon-shopping-bag ms-2"></i>
                                    سفارش مرحله ای
                                </button>
                            </div>
                            <div class="col-6 d-grid">
                                <form action="{{ route('storeSingle') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}" />
                                    <input type="hidden" name="quantity" value="1" />
                                    <button type="submit" class="btn btn-primary" >
                                        <i class="feather-icon icon-shopping-bag ms-2"></i>
                                        سفارش تکی
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection