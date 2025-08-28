@extends('layouts.app')

@section('content')
    <?php $items = collectProducts($products, $category ? [$category['id']] : []); ?>

    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">صفحه نخست</a></li>
                            @if($category)
                                <li class="breadcrumb-item"><a href="{{ url('products') }}">محصولات</a></li>
                                <li class="breadcrumb-item active"><a
                                        href="{{ url('products') }}">{{ $category['info']['title'] ?? trans("message.products") }}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item active"><a href="{{ url('products') }}">محصولات</a></li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="mt-8 mb-lg-10 mb-8">
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-lg-12">
                    <!-- page header -->
                    <div class="card mb-4 bg-light border-0">
                        <!-- card body -->
                        <div class="card-body p-9">
                            <!-- title -->
                            <h2 class="mb-0 fs-2">{{ $category['info']['title'] ?? trans("message.products") }}</h2>
                        </div>
                    </div>
                    <!-- list icon -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 mb-md-0">
                                <span class="text-dark">{{ $items->count() }}</span>
                                {{trans("message.items_found")}}
                            </p>
                        </div>
                        <!-- icon -->
                        <div class="d-md-flex justify-content-between align-items-center">

                            <div class="d-flex mt-2 mt-lg-0">
                                <div>
                                    <form>
                                        <select class="form-select" name="sort" onchange="this.form.submit();">
                                            @foreach (productSortLists() as $productSortList)
                                                <option value="{{ $productSortList['key'] }}" {{ $productSortList['key'] == request()->get('sort') ? "selected" : "" }}>
                                                    {{ $productSortList['title'] }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 row-cols-lg-4 row-cols-2 row-cols-md-4 mt-1">
                        @foreach ($items->toArray() as $product)
                            <div class="col">
                                <div class="card card-product">
                                    <div class="card-body">
                                        <div class="text-center position-relative">
                                            @if(isset($product['info']['label']))
                                                <div class="position-absolute top-0 start-0 mt-1 ms-1">
                                                    <span class="badge bg-danger">{{ $product['info']['label'] ?? "" }}</span>
                                                </div>
                                            @endif
                                            <a href="{{ route('product', [$product['id']]) }}">
                                                <img data-src="{{ $product['info']['banner'] ?? "" }}"
                                                    src="{{ asset('placeholder.webp') }}" class="mb-3 img-fluid lazy"
                                                    loading="lazy" alt="{{ $product['info']['title'] ?? "" }}"
                                                    title="{{ $product['info']['title'] ?? "" }}" />
                                            </a>
                                        </div>
                                        @if(count($product['parents']) > 0)
                                            <div class="text-small mb-1">
                                                <a href="{{ route('products.category', $product['parents'][0]['id']) }}"
                                                    class="text-decoration-none text-muted text-limit"><small>{{ $product['parents'][0]['info']['title'] ?? "" }}</small></a>
                                            </div>
                                        @endif

                                        <h2 class="fs-6">
                                            <a href="{{ route('product', [$product['id']]) }}"
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
                                                <a href="javascript:;" class="btn btn-primary btn-sm" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasRight" href="#offcanvasExample" role="button"
                                                    aria-controls="offcanvasRight">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-plus">
                                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection