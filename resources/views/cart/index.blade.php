@extends('layouts.account_layout')
@section('content1')

    <div class="col-lg-9 col-md-8 col-12">
        <div class="py-6 p-md-6 p-lg-10">
            <!-- heading -->
            <h2 class="mb-6">{{trans("message.orders")}}</h2>

            @if(count($carts) > 0)
                <div class="table-responsive-xxl border-0">
                    <!-- Table -->
                    <table class="table mb-0 text-nowrap table-centered">
                        <!-- Table Head -->
                        <thead class="bg-light">
                            <tr>
                                <th>{{trans("message.order_id")}}</th>
                                <th>{{trans("message.order_created_at")}}</th>
                                <th>{{trans("message.total_price")}}</th>
                                <th>{{trans("message.status")}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $cart)
                                <tr>
                                    <td class="align-middle border-top-0">
                                        <a href="#" class="fw-semibold text-inherit">
                                            <h6 class="mb-0">{{$cart->id}}</h6>
                                        </a>
                                    </td>
                                    <td class="align-middle border-top-0">
                                        <a class="text-inherit">{{toJalali($cart->created_at)}}</a>
                                    </td>
                                    <td class="align-middle border-top-0">
                                        {{number_format($cart->final_price) . " " . trans("message.toman")}}</td>

                                    <td class="align-middle border-top-0">
                                        <span class="badge bg-warning">{{trans("message." . $cart->status)}}</span>
                                    </td>
                                    <td class="text-muted align-middle border-top-0">
                                        <a href="{{route("user.orders.show", ["id" => $cart->id])}}" class="text-inherit"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="{{trans("message.view_detail")}}"><i
                                                class="feather-icon icon-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="ci-map-pin text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-semibold">{{ trans('message.no_orders') }}</h5>
                    <p class="text-muted mb-4">{{ trans('message.no_order_description') }}</p>
                </div>

            @endif

        </div>
    </div>

@endsection