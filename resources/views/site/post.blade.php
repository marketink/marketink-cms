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
                            <li class="breadcrumb-item"><a href="{{ url('blog') }}">وبلاگ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $post['info']['title'] ?? "" }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- section -->
    <section class="my-8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- text -->
                    <div class="mb-5">
                        <div class="mb-3 text-center"><a href="#!">{{ $post['info']['label'] ?? "" }}</a></div>
                        <h1 class="fw-bold text-center">{{ $post['info']['title'] ?? "" }}</h1>
                        <div class="d-flex justify-content-center text-muted mt-4">
                            <span class="me-2"><small>{{ $post['info']['created_at']['date'] ?? "" }}</small></span>
                            <span>
                                <small>
                                    مدت زمان مطالعه:
                                    <span class="text-dark fw-bold">{{ $post['info']['read'] ?? "" }}</span>
                                </small>
                            </span>
                        </div>
                    </div>

                    {!! $post['info']['embed'] ?? "" !!}

                    <div class="row mt-lg-10 mt-5">
                        <div class="col-md-6">
                            <!-- text -->
                            <div class="mb-4">
                                <p class="mb-0 text-box">{!! nl2br($post['info']['body'] ?? "") !!}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="h-100 pb-lg-10">
                                <img data-src="{{ $post['info']['banner'] ?? ""}}" alt="{{ $post['info']['title'] ?? "" }}"
                                    title="{{ $post['info']['title'] ?? "" }}" class="img-fluid rounded w-100 h-100 object-fit-cover lazy" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <hr class="mt-lg-10 mb-lg-6 my-md-6" />

            <div class="my-8">
                <!-- row -->
                <div class="row">
                    <!-- col -->
                    <div class="col-md-12">
                        <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-8">
                                <div>
                                    <h4>نظرات</h4>
                                </div>
                            </div>

                            @foreach ($comments as $comment)
                                <div class="d-flex border-bottom pb-6 mb-6">
                                    <!-- img -->
                                    <!-- img -->
                                    <div class="ms-5">
                                        <h6 class="mb-1">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</h6>
                                        <!-- select option -->
                                        <!-- content -->
                                        <p class="small">
                                            <span class="text-muted">{{ toJalali($comment->created_at) }}</span>

                                        </p>

                                        <p class="text-box mb-0">
                                            {{ $comment->comment }}
                                        </p>

                                    </div>
                                </div>

                            @endforeach

                            <div>
                                {{ $comments->links() }}
                            </div>
                        </div>

                        <div>

                            <form action="{{ route('comment.post', $post) }}" method="post">
                                @csrf
                                <div class="py-4 mb-0">
                                    <!-- heading -->
                                    <h5>ارسال نظر</h5>
                                    <p>لطفا نظرات خود را جهت ارتقا کیفیت پست های ما ارسال نمایید</p>
                                    <textarea name="comment" required class="form-control" rows="3" placeholder="نظر خود را وارد نمایید"></textarea>
                                </div>
                                <!-- button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">ارسال</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>









        </div>
    </section>

@endsection