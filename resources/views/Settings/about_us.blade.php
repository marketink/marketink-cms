@extends('layouts.app')
@section('content')
    <section class="mt-lg-14 mt-8">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <?php $i = 0; ?>
                @foreach($aboutUs as $item)
                    <?php    ++$i ?>
                    <div class="col-lg-12 col-12" dir="{{ $i % 2 == 0 ? "ltr" : "rtl" }}">
                        <div class="row align-items-center mb-14">
                            <div class="col-md-6">
                                <!-- text -->
                                <div class="ms-xxl-14 me-xxl-15 mb-8 mb-md-0 text-center text-md-start">
                                    <h2 class="mb-6" dir="rtl" style="text-align: right">{{ $item['info']['title'] ?? "" }}</h2>
                                    <p class="mb-0 lead font-weight-300" dir="rtl" style="text-align: right">
                                        {{ $item['info']['body'] ?? "" }}
                                    </p>
                                </div>
                            </div>
                            <!-- col -->
                            <div class="col-md-6">
                                <div>
                                    <!-- img -->
                                    <img src="{{$item['info']['banner'] ?? ""}}" alt="{{ $item['info']['title'] ?? "" }}"
                                        title="{{ $item['info']['title'] ?? "" }}" class="img-fluid rounded w-100" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection