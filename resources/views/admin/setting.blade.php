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
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="tel">
                                        شماره تماس
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input  id="tel" class="form-control" name="tel" required
                                        value="{{ $setting?->option?->tel ?? '' }}" />
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="height_conf">
                                        درصد اضافی ارتفاع
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" id="height_conf" class="form-control" name="height_conf" required
                                        value="{{ $setting?->option?->height_conf }}" min="0" max="1" step="0.01" />
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <h6 class="mb-3">دسته بندی حریر ها در سفارش</h6>
                                    <ul class="list-group p-0">
                                        @foreach ($categories as $category)
                                            <label class="list-group-item">
                                                <input name="harir_ids[]" class="form-check-input ms-1" style="height:20px"
                                                    type="checkbox" value="{{ $category['id'] }}" @if (in_array($category['id'], $setting?->option?->harir_ids ?? [])) checked @endif>
                                                {{ $category['info']['title'] ?? "" }}
                                            </label>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <h6 class="mb-3">دسته بندی کناره ها در سفارش</h6>
                                    <ul class="list-group p-0">
                                        @foreach ($categories as $category)
                                            <label class="list-group-item">
                                                <input name="kenareh_ids[]" class="form-check-input ms-1" style="height:20px"
                                                    type="checkbox" value="{{ $category['id'] }}" @if (in_array($category['id'], $setting?->option?->kenareh_ids ?? [])) checked @endif>
                                                {{ $category['info']['title'] ?? "" }}
                                            </label>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <h6 class="mb-3">دسته بندی ابزار های پانچ در سفارش</h6>
                                    <ul class="list-group p-0">
                                        @foreach ($categories as $category)
                                            <label class="list-group-item">
                                                <input name="curtain_tools[]" class="form-check-input ms-1" style="height:20px"
                                                    type="checkbox" value="{{ $category['id'] }}" @if (in_array($category['id'], $setting?->option?->curtain_tools ?? [])) checked @endif>
                                                {{ $category['info']['title'] ?? "" }}
                                            </label>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <h6 class="mb-3">دسته بندی ابزار های مینیمال در سفارش</h6>
                                    <ul class="list-group p-0">
                                        @foreach ($categories as $category)
                                            <label class="list-group-item">
                                                <input name="curtain_tools_minimal[]" class="form-check-input ms-1" style="height:20px"
                                                    type="checkbox" value="{{ $category['id'] }}" @if (in_array($category['id'], $setting?->option?->curtain_tools_minimal ?? [])) checked @endif>
                                                {{ $category['info']['title'] ?? "" }}
                                            </label>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- input -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="shipping_cost">
                                        هزینه ارسال معمولی
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" id="shipping_cost" class="form-control" name="shipping_cost"
                                        required value="{{ $setting?->option?->shipping_cost ?? '' }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="height_conf">
                                        هزینه ارسال با میله
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" id="shipping_cost_with_rod" class="form-control"
                                        name="shipping_cost_with_rod" required
                                        value="{{ $setting?->option?->shipping_cost_with_rod ?? '' }}" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="height_conf">
                                        هزینه اضافی انتخاب مینیمال
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" id="minimal_conf" class="form-control"
                                        name="minimal_conf" required
                                        value="{{ $setting?->option?->minimal_conf ?? '' }}" />
                                </div>

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