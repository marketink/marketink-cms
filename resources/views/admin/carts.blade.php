@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-2">
        <div class="row mt-1">
            <div class="col-lg-12 col-md-12 mb-md-0 mb-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row mb-3">
                            <div class="col-6">
                                    <h6>سفارشات</h6>
                                <p class="text-sm">
                                    <i class="fa fa-check text-info"></i>
                                    در این قسمت میتوانید سفارش های خود را مدیریت کنید
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3">
                        <div class="data-table" id="data-table-body-carts">
                            <filter class="hidden">
                                <div class="datatable-filters mb-2 d-flex">
                                    <select name="status" class="form-select form-select-sm w-full">
                                        <option value="">{{trans("message.all_statuses")}}</option>
                                        @foreach (collect(statuses())->where('type', 'cart')->first()['status'] as $status)
                                            <option value="{{$status}}">{{trans('message.' . $status)}}</option>
                                        @endforeach
                                    </select>

                                    <select name="type" class="form-select form-select-sm w-full">
                                        <option value="">{{trans("message.all_types")}}</option>
                                        <option value="multiple">سفارش پرده</option>
                                        <option value="single">سفارش تکی</option>
                                    </select>
                                </div>

                            </filter>
                            <table data-url="{{ route('carts.index') }}" data-id="carts"
                                class="display nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th data="id">{{trans("message.english_id")}}</th>
                                        <th data="user.first_name">{{trans("message.first_name")}}</th>
                                        <th data="user.last_name">{{trans("message.last_name")}}</th>
                                        <th data="user.username">{{trans("message.phone_number")}}</th>
                                        <th data="trans_type" name="type">{{trans("message.type")}}</th>
                                        <th data="trans_status" name="status">{{trans("message.status")}}</th>										
                                        <th data="trans_created_at" name="created_at">{{trans("message.created_at")}}</th>
                                        <th data="action" scope="show">{{trans("message.tools")}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
    </div>
@endsection
