@extends('admin.layouts.app')

@section('content')
    <style>
        .table thead th {
            font-weight: bold;
        }

        .table * {
            font-size: 13px;
        }
    </style>
    <div class="container-fluid py-2">
        <div class="row mt-1">
            <div class="col-lg-12 col-md-12 mb-md-0 mb-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row mb-0">
                            <div class="col-12">
                                <h6>
                                    سفارش {{ $cart->id }}
                                    <b class="mx-2">({{ $cart->trans_type }})</b>
                                </h6>
                                <p class="text-sm">
                                    <i class="fa fa-check text-info"></i>
                                    در این قسمت میتوانید سفارش خود را مدیریت کنید
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 pb-3 pt-0" style="font-size: 15px">
                        <div class="table-responsive">
                            <table class="table mb-0 text-nowrap table-centered">
                                <!-- Table Head -->
                                <thead class="bg-light" style="border-bottom: 1px solid #00000060">
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>{{trans("message.product_name")}}</th>
                                        @if($cart->type != "multiple")
                                            <th>{{trans("message.quantity")}}</th>
                                            <th>{{trans("message.product_price")}}</th>
                                        @else
                                            <th>{{trans("message.type")}}</th>
                                        @endif
                                        <th>{{trans("message.total_price")}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table body -->
                                    @foreach($cart->orders as $order)
                                        <tr>
                                            <td class="align-middle border-top-0 w-0 ">
                                                <a>
                                                    <img src="{{ $order["products"]['info']['vector'] ?? "" }}" width="30"
                                                        height="30" class="icon-shape"
                                                        style="border-radius: 10px;object-fit: cover;" />
                                                </a>
                                            </td>
                                            <td class="align-middle border-top-0 py-0">
                                                <a class="fw-semibold text-inherit">
                                                    <h6 class="mb-0">{{ $order["products"]["info"]["title"]  }}</h6>
                                                </a>
                                            </td>
                                            @if($cart->type != "multiple")
                                                <td class="align-middle border-top-0 py-0">
                                                    <a class="text-inherit">{{$order->qty}}</a>
                                                </td>
                                                <td class="align-middle border-top-0 py-0">
                                                    {{number_format($order->price)}}
                                                    <small>
                                                        <b>تومان</b>
                                                    </small>
                                                </td>
                                            @else
                                                <td class="align-middle border-top-0 py-0">
                                                    {{trans("message." . $order->type)}}
                                                </td>
                                            @endif

                                            <td class="align-middle border-top-0 py-0">
                                                {{number_format($order->final_price)}}
                                                <small>
                                                    <b>تومان</b>
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($cart->info)
                            <div class="list-group mt-2">
                                @foreach (array_keys((array) json_decode($cart->info)) as $info)
                                    @if ($info != "orders")

                                        <label class="list-group-item d-flex gap-3 pt-3 mb-0">
                                            <div>
                                                <strong class="d-block">{{ trans("message.orderDetail.$info") }}</strong>
                                                <small class="text-muted">
                                                    {{  orderDetail($info, json_decode($cart->info)->$info) }}
                                                </small>
                                            </div>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        @if($cart->statuses->count() > 0)
                            <p style="margin-top: 25px;margin-bottom: 10px;font-size: 15px;font-weight: bold;">
                                وضعیت ها
                            </p>
                            <div class="list-group">
                                @foreach ($cart->statuses as $status)
                                    <label class="list-group-item d-flex gap-3 pt-3 mb-0 w-100">

                                        <div class="w-100">
                                            <strong class="d-block">{{ trans("message.$status->status") }}</strong>
                                            <small class="text-muted d-flex w-100" style="justify-content: space-between;">
                                                <b>
                                                    {{ $status->user->first_name }}
                                                    {{ $status->user->last_name }}
                                                </b>
                                                <b dir="ltr">
                                                    {{ siteSetting()['dateFunction']($status->created_at)->format('Y-m-d H:i:s') }}
                                                </b>
                                            </small>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table mb-0 text-nowrap table-centered mt-3">
                                <tbody>
                                    <tr>
                                        <td>هزینه فاکتور</td>
                                        <td class="align-middle border-top-0">
                                            {{number_format($cart->total_price)}}
                                            <small>
                                                <b>تومان</b>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>هزینه ارسال</td>
                                        <td class="align-middle border-top-0">
                                            {{number_format($cart->shipping_cost)}}
                                            <small>
                                                <b>تومان</b>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>مجموع </td>
                                        <td class="align-middle border-top-0">
                                            {{number_format($cart->final_price)}}
                                            <small>
                                                <b>تومان</b>
                                            </small>
                                        </td>
                                    </tr>

                                    @if($cart->address)
                                        <tr>
                                            <td>آدرس </td>
                                            <td class="align-middle border-top-0">
                                                <p style="margin: 0;font-size: 13px;white-space: break-spaces;">
                                                    {{ $cart->address->address }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endif

                                    @if($cart->description)
                                        <tr>
                                            <td>توضیحات </td>
                                            <td class="align-middle border-top-0">
                                                <p style="margin: 0;font-size: 13px;white-space: break-spaces;">
                                                    {{ $cart->description }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endif

                                    @if($cart->tracking_code)
                                        <tr>
                                            <td>کد رهگیری مرسوله </td>
                                            <td class="align-middle border-top-0">
                                                <p style="margin: 0;font-size: 13px;white-space: break-spaces;">
                                                    {{ $cart->tracking_code }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>

                        @if($statuses->count() > 0)
                            <form data-success="cart" action="{{ route('carts.update', $cart) }}" method="POST">
                                @csrf
                                @method('put')
                                <p style="margin-top: 25px;margin-bottom: 10px;font-size: 15px;font-weight: bold;">
                                    وضعیت بعدی
                                </p>
                                <div>
                                    @foreach ($statuses as $status)
                                        <div class="smart-form-inputs" id="">
                                            <div class="form-check">
                                                <input type="radio" value="{{  $status }}" name="status" class="form-check-input"
                                                    id="smart-form-{{  $status }}" />
                                                <label class="custom-control-label me-2" for="smart-form-{{ $status }}">
                                                    {{trans('message.' . $status)}}</label>

                                            </div>
                                        </div>
                                    @endforeach


                                    @if(!$cart->tracking_code)
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="tracking_code">
                                                    کد رهگیری
                                                </label>
                                                <input id="tracking_code" class="form-control" name="tracking_code"
                                                    style="padding: 10px 15px;border: 1px solid #1b1b1b50;"
                                                    value="{{ $cart->tracking_code }}" />
                                            </div>
                                        </div>
                                    @endif

                                    <button class="btn btn-primary">انتخاب</button>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
    </div>
@endsection