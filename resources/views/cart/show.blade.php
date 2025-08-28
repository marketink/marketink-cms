@extends('layouts.account_layout')
@section('content1')

    <div class="col-lg-9 col-md-8 col-12">
        <div class="py-6 p-md-6 p-lg-10">
            @if(isset($cart) && $cart->orders && count($cart->orders) > 0)
                @if($cart->status == "pending")
                    <h2 class="mb-6">{{trans("message.cart")}}</h2>
                    <form action="{{route("deleteAllOrders")}}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-danger mb-4">حذف همه سفارش ها</button>
                    </form>
                @else
                    <h2 class="mb-6">{{trans("message.order") . " " . $cart->id}}</h2>
                @endif
                <div class="table-responsive-xxl"
                    style="border: 1px solid #00000060;border-radius: 10px;font-size: 12px;font-weight: bold;line-height: 30px;margin-bottom: 20px">
                    <!-- Table -->
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
                                @if($cart->type != "multiple")
									<th></th>
								@endif
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table body -->
                            @foreach($cart->orders as $order)
                                <tr>
                                    <td class="align-middle border-top-0 w-0 ">
                                        <a>
                                            <img src="{{ $order["products"]['info']['vector'] ?? "" }}" width="50" height="50"
                                                class="icon-shape icon-xl" style="border-radius: 10px;object-fit: cover;" />
                                        </a>
                                    </td>
                                    <td class="align-middle border-top-0 py-0">
                                        <a class="fw-semibold text-inherit">
                                            <h6 class="mb-0">{{ $order["products"]["info"]["title"]  }}</h6>
                                        </a>
                                    </td>
                                    @if($cart->type != "multiple")
                                        <td class="align-middle border-top-0 py-0">

                                            <form action="{{ route('storeSingle') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $order['content_id'] }}" />
                                                <input type="number" name="quantity" value="{{$order->qty}}"
                                                style="
                                                    padding: 5px;
                                                    text-align: center;
                                                    border-radius: 10px;
                                                    border: 1px solid #1b1b1b20;
                                                    max-width: 50px;
                                                    margin-left: 5px;
                                                "
                                                />
                                                <button type="submit" class="btn btn-primary" style="font-size: 10px;">
                                                    ثبت تعداد
                                                </button>
                                            </form>

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
									
                                    @if($cart->type != "multiple")
                                        <td class="align-middle border-top-0 py-0">
                                            <form action="{{ route('storeSingle') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $order['content_id'] }}" />
                                                <input type="hidden" name="quantity" value="0" />
                                                <button type="submit" class="btn btn-danger" style="font-size: 10px;">
                                                    حذف
                                                </button>
                                            </form>
                                        </td>
                                    @endif
									
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive-xxl"
                    style="border: 1px solid  #00000060;max-width: 500px;border-radius: 10px;margin-bottom: 15px;">
                    <table class="table mb-0 text-nowrap table-centered">
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
                            @if($cart->status == "pending")
                                <tr>
                                    <td colspan="2" class="p-0">
                                        <div class="list-group">
                                            <p
                                                style="margin: 0;padding: 10px 20px 10px;font-size: 12px;font-weight: bold;border-bottom: 1px solid #1b1b1b30;">
                                                انتخاب آدرس
                                            </p>
                                            @if(auth()->user()->addresses->count() > 0)
                                                <form action="{{ route('current.cart.post') }}" method="post">
                                                    @csrf
                                                    @foreach (auth()->user()->addresses as $address)
                                                        <label class="list-group-item d-flex gap-3 pt-3 rounded-0 border-0">
                                                            <input class="form-check-input flex-shrink-0" type="radio" name="address_id"
                                                                value="{{ $address->id }}" onclick="this.form.submit()" {{ $address->id == $cart->address_id ? 'checked' : '' }}>
                                                            <div>
                                                                <strong class="d-block">
                                                                    {{ $address->name }}
                                                                </strong>
                                                                <small class="text-muted">
                                                                    {{$address->city . " " . $address->address}}
                                                                </small>
                                                            </div>
                                                        </label>
                                                    @endforeach

                                                    @if($cart->address_id)
                                                        <p style="margin: 0;padding: 10px;font-size: 13px;white-space: break-spaces;">
                                                            برای پرداخت پیش فاکتور کلیک نمایید
                                                            <a href="{{  route('payments.initiate') }}" class="btn btn-primary py-1 mx-2">
                                                                پرداخت
                                                            </a>
                                                        </p>
                                                    @endif

                                                </form>
                                            @else
                                                <p style="margin: 0;padding: 10px;font-size: 13px;line-height: 35px;">
                                                    شما آدرسی ثبت نکردید برای تکمیل سفارش لطفا آدرس خود را وارد نمایید
                                                    <br>
                                                    <a href="{{  url('profile/address') }}" class="btn btn-primary py-1 mt-1">آدرس های من
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

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

                                <tr class="hidden">
                                    <td colspan="2" class="p-0">
                                        <p
                                            style="margin: 0;padding: 10px 20px 10px;font-size: 12px;font-weight: bold;border-bottom: 1px solid #1b1b1b30;">
                                            انتخاب تاریخ
                                            ارسال
                                        </p>
                                        <div class="calendar">
                                            <div class="d-flex px-2">
                                                <select id="monthSelector"></select>
                                                <select id="yearSelector"></select>
                                            </div>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th class="border-right-0">ش</th>
                                                        <th>ی</th>
                                                        <th>د</th>
                                                        <th>س</th>
                                                        <th>چ</th>
                                                        <th>پ</th>
                                                        <th class="border-left-0">ج</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="calendarBody"></tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <label for="deliveryHour">انتخاب بازه زمانی ارسال:</label>
                                            <select id="deliveryHour">
                                                <option disabled selected>-- انتخاب بازه ساعتی --</option>
                                            </select>
                                        </div>

                                        <div id="deliveryResult"></div>
                                        <input type="hidden" id="deliveryDateInput" name="delivery_datetime">
                                    </td>
                                </tr>

                            @else

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


                                @if($cart->statuses->count() > 0)
                                    <tr>
                                        <td colspan="2" class="p-0">

                                            <p style="margin: 0;padding: 10px 20px 10px;font-size: 12px;font-weight: bold;">
                                                وضعیت ها
                                            </p>
                                        </td>
                                    </tr>

                                    @foreach ($cart->statuses as $status)
                                        <tr>
                                            <td>{{ trans('message.' . $status->status) }} </td>
                                            <td class="align-middle border-top-0">
                                                <p style="margin: 0;font-size: 13px;white-space: break-spaces;" dir="ltr">
                                                    {{ siteSetting()['dateFunction']($status->created_at)->format('Y-m-d H:i:s') }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                            @endif

                        </tbody>
                    </table>
                </div>

            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="ci-map-pin text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-semibold">{{ trans('message.no_cart') }}</h5>
                    <p class="text-muted mb-4">{{ trans('message.no_cart_description') }}</p>
                </div>
            @endif

        </div>
    </div>
@endsection