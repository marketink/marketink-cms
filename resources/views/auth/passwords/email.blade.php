@extends('auth.layouts.app')

@section('content')
    <section class="my-lg-14 my-8">
        <div class="container">
            <!-- row -->
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                    <!-- img -->

                    <img src="{{ asset('assets/platform/images/login-page.png')}}" alt=""
                         class="img-fluid border-rounded" />
                </div>
                <!-- col -->
                <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                    <div class="mb-lg-9 mb-5">
                        <h1 class="mb-1 h2 fw-bold">{{trans("message.forget_password")}}</h1>
                        <p>{{trans("message.forget_password_description")}}</p>
                    </div>

                    <form method="POST" action="{{ route("password.email") }}" class="needs-validation
                            @error('username') was-validated @enderror
                            @error('password') was-validated @enderror
                        " novalidate>
                        @csrf
                        <div class="row g-3">
                            <!-- row -->

                            <div class="col-12">
                                <!-- input -->
                                <label for="formSigninEmail" class="form-label visually-hidden">{{trans("message.phone_number")}}</label>
                                <input type="text" class="form-control" id="formSignupEmail" name="username"
                                       placeholder="{{trans("message.phone_number")}}" required value="{{ old('username') }}"/>
                                <div class="invalid-feedback">
                                    @error('username')
                                    {{ $message }}
                                    @else
                                        {{trans("message.phone_required")}}
                                        @enderror

                                </div>
                            </div>
                            <div class="col-12">
                                <!-- input -->
                            </div>
                            <div class="d-flex justify-content-between">
                                <!-- form check -->
                            </div>
                            <!-- btn -->
                            <div class="col-12 d-grid"><button type="submit" class="btn btn-primary">{{trans("message.send_code")}}</button></div>
                            <!-- link -->
                            <div class="mb-5 info-paraf">
                                <small>
                                    {{trans("message.do_not_have_account")}}
                                    <a href="{{  route('register') }}">{{trans("message.register")}}</a>
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
