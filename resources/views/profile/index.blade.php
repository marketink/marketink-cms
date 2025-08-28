@extends('layouts.account_layout')
@section('content1')

    <div class="col-lg-9 col-md-8 col-12">
        <div class="py-6 p-md-6 p-lg-10">
            <div class="mb-6">
                <!-- heading -->
                <h2 class="mb-0">{{trans("message.profile")}}</h2>
            </div>
            <div>
                <!-- heading -->
                <h5 class="mb-4">{{trans("message.personal_info")}}</h5>
                <div class="row">
                    <div class="col-lg-5">
                        <!-- form -->
                        <form action="{{route("profile.update")}}" method="POST">
                            @csrf
                            <!-- input -->
                            <div class="mb-3">
                                <label class="form-label">{{trans("message.first_name")}}</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    value="{{$user->first_name}}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{trans("message.last_name")}}</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                    value="{{$user->last_name}}" />
                            </div>
                            <!-- input -->
                            <div class="mb-5">
                                <label class="form-label">{{trans("message.user_name")}}</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    value="{{$user->username}}" disabled />
                            </div>
                            <!-- button -->
                            <div class="mb-3">
                                <button class="btn btn-primary">{{trans("message.save")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(!$user->username_verified_at)
                <hr class="my-5" />
                <div class="">
                    <!-- heading -->
                    <h5 class="mb-4">تایید حساب کاربری</h5>
                    <p>برای ثبت سفارش میبایست حساب کاربری خود را تایید فرمایید.</p>

                    @if(isset($send_code) && $send_code == true)
                        <form action="{{route("verifyAccount")}}" method="POST">
                            @csrf
                            <input class="form-control" type="text" name="code" id="code" />
                            <div class="col-12 mt-2">
                                <input type="submit" class="btn btn-primary" value="{{trans("message.verify_account")}}" />
                            </div>
                        </form>
                    @else
                        <form class="row row-cols-1 row-cols-lg-2" method="POST" action="{{route("sendVerificationCode")}}">
                            @csrf
                            <input type="hidden" name="phone_number" id="phone_number" value="{{$user->username}}">
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary" value="{{trans("message.verify_account")}}" />
                            </div>
                        </form>
                    @endif
                </div>
            @endif

            <hr class="my-5" />
            <div class="">
                <!-- heading -->
                <h5 class="mb-4">{{trans("message.password")}}</h5>
                <form class="row row-cols-1 row-cols-lg-2" method="POST" action="{{route("user.update.password")}}">
                    @csrf
                    <!-- input -->
                    <div class="mb-3 col">
                        <label class="form-label">{{trans("message.new_password")}}</label>
                        <input type="password" name="new_password" class="form-control" placeholder="**********" />
                    </div>
                    <!-- input -->
                    <div class="mb-3 col">
                        <label class="form-label">{{trans("message.current_password")}}</label>
                        <input type="password" name="current_password" class="form-control" placeholder="**********" />
                    </div>
                    <!-- input -->
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" value="{{trans("message.save")}}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
