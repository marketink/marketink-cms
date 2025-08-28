@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('content')

    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">صفحه نخست</a></li>
                            <li class="breadcrumb-item active"><a href="{{ url('blog') }}">وبلاگ</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- section -->
    <section class="mt-8">
        <div class="container">
            <div class="row">
                <!-- logo -->
                <div class="col-12">
                    <h1 class="fw-bold">وبلاگ</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- section -->
    <section class="mt-6 mb-lg-10 mb-8">
        <!-- container -->
        <div class="container">
            @php
                $firstPost = $posts->first();
            @endphp

            @if($firstPost)
                <div class="row d-flex align-items-center mb-8">
                    <div class="col-12 col-md-12 col-lg-8">
                        <a href="{{ route('post', $firstPost) }}">
                            <!-- img -->
                            <div class="img-zoom">
                                <img src="{{ $firstPost['info']['banner'] ?? "" }}"
                                    alt="{{ $firstPost['info']['title'] ?? "" }}"
                                    title="{{ $firstPost['info']['title'] ?? "" }}" class="img-fluid w-100" />
                            </div>
                        </a>
                    </div>
                    <!-- text -->
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="ps-lg-8 mt-8 mt-lg-0">
                            <h2 class="mb-3"><a href="{{ route('post', $firstPost) }}" class="text-inherit">{{ $firstPost['info']['title'] ?? "" }}</a></h2>
                            <p>
                                {{ $firstPost['info']['body'] ?? "" }}
                            </p>
                            <div class="d-flex justify-content-between text-muted">
                                <span><small>{{ $firstPost['info']['created_at']['date'] ?? "" }}</small></span>
                                <span>
                                    <small>
                                        مدت زمان مطالعه:
                                        <span class="text-dark fw-bold">{{ $firstPost['info']['read'] ?? "" }}</span>
                                    </small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- row -->
            <div class="row">
                @foreach ($posts->skip(1) as $post)
                    <div class="col-12 col-md-6 col-lg-4 mb-10">
                        <div class="mb-4">
                            <a href="{{ route('post', $post) }}">
                                <!-- img -->
                                <div class="img-zoom">
                                    <img src="{{ $post['info']['banner'] ?? "" }}" alt="{{ $post['info']['title'] ?? "" }}"
                                        title="{{ $post['info']['title'] ?? "" }}" class="img-fluid w-100" />
                                </div>
                            </a>
                        </div>
                        <!-- text -->
                        <div class="mb-3"><a href="{{ route('post', $post) }}">{{ $post['info']['label'] ?? "" }}</a></div>
                        <!-- text -->
                        <div>
                            <h2 class="h5"><a href="{{ route('post', $post) }}" class="text-inherit">
                                    {{ $post['info']['title'] ?? "" }}
                                </a>
                            </h2>
                            <p>
                                {{ Str::limit($post['info']['body'] ?? "", 100) }}
                            </p>
                            <div class="d-flex justify-content-between text-muted mt-4">
                                <span><small>{{ $post['info']['created_at']['date'] ?? "" }}</small></span>
                                <span>
                                    <small>
                                        مدت زمان مطالعه:
                                        <span class="text-dark fw-bold">{{ $post['info']['read'] ?? "" }}</span>
                                    </small>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12">
                    <nav>
                        {{ $posts->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </section>

@endsection