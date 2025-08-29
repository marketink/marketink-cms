@extends('admin.layouts.app')

@section('content')
    <style>
        .card-body input,
        .card-body select,
        .card-body input:hover,
        .card-body select:hover,
        .card-body input:focus,
        .card-body select:focus {
            border: 1px solid #1b1b1b20;
            height: 40px;
            padding: 10px 10px !important;
        }
    </style>

    <div class="container-fluid py-2">

        <div class="row mt-1">
            <div class="col-lg-12 col-md-12 mb-md-0 mb-1">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6>تنظیمات</h6>
                                <p class="text-sm">
                                    <i class="fa fa-check text-info"></i>
                                    تنظیمات وبسایت
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3">

                        <div class="p-4 pt-0 pb-0">

                            <!-- form -->
                            <form class="row needs-validation" novalidate action="" method="post" data-success="setting">
                                @csrf
                                <!-- input -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="app_color">
                                        رنگ سایت
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="color" id="app_color" class="form-control" name="app_color" required
                                        value="{{ $setting?->app_color }}" />
                                </div>

                                @foreach ($fields as $field)

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="{{ $field['key'] }}">
                                            {{ $field['name'] }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input id="{{ $field['key'] }}" class="form-control" name="{{ $field['key'] }}" required
                                            value="{{ $setting?->option?->{$field['key']} ?? '' }}" />
                                    </div>

                                @endforeach

                                <div class="col-md-12">
                                    <!-- btn -->
                                    <button type="submit" class="btn btn-primary">ارسال</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
    </div>
@endsection