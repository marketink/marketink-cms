@extends('auth.layouts.app')

@section('content')

    <section class="my-lg-14 my-8">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2 hidden-in-mobile">
                    <!-- img -->
                    <img src="{{ asset('assets/platform/images/register-page.png')}}" alt="" class="img-fluid border-rounded" />
                </div>
                <!-- col -->
                <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                    <div class="mb-lg-9 mb-5">
                        <h1 class="mb-1 h2 fw-bold">{{trans("message.register")}}</h1>
                        <p>{{trans("message.welcome")}}</p>
                    </div>
                    <!-- form -->
                    <form method="POST" action="{{ route('register') }}" class="needs-validation
                            @error('first_name') was-validated @enderror
                            @error('last_name') was-validated @enderror
                            @error('username') was-validated @enderror
                            @error('password') was-validated @enderror
                        " novalidate>
                        @csrf
                        <div class="row g-3">
                            <!-- col -->
                            <div class="col">
                                <!-- input -->
                                <label for="formSignupfname" class="form-label visually-hidden">{{trans("message.first_name")}}</label>
                                <input type="text" class="form-control" id="formSignupfname" name="first_name"
                                    placeholder="{{trans("message.first_name")}}" required value="{{ old('first_name') }}" />
                                <div class="invalid-feedback">
                                    @error('first_name')
                                        {{ $message }}
                                    @else
                                    {{trans("message.first_name_required")}}
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <!-- input -->
                                <label for="formSignuplname" class="form-label visually-hidden">{{trans("message.last_name")}}</label>
                                <input type="text" class="form-control" id="formSignuplname" name="last_name"
                                    placeholder="{{trans("message.last_name")}}" required value="{{ old('last_name') }}" />
                                <div class="invalid-feedback">
                                    @error('last_name')
                                        {{ $message }}
                                    @else
                                        {{trans("message.last_name_required")}}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <!-- input -->
                                <label for="formSignupEmail" class="form-label visually-hidden">{{trans("message.phone_number")}}</label>
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
                                <div class="password-field position-relative">
                                    <label for="formSignupPassword" class="form-label visually-hidden">{{trans("message.password")}}</label>
                                    <div class="password-field position-relative">
                                        <input type="password" name="password" class="form-control fakePassword" id="formSignupPassword"
                                            placeholder="{{trans("message.password")}}" required />
                                        <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                                        <div class="invalid-feedback">
                                        @error('password')
                                            {{ $message }}
                                        @else
                                            {{trans("message.pass_required")}}
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- btn -->
                            <div class="col-12 d-grid"><button type="submit" class="btn btn-primary">{{trans("message.register")}}</button></div>

                            <!-- text -->
                            <p>
                                <small>
                                     {{trans("message.complete_register_means_v1")}}
                                    <a href="#!">{{trans("message.complete_register_means_v2")}}</a>
                                    {{trans("message.and")}}
                                    <a href="#!">{{trans("message.complete_register_means_v3")}}</a>
                                    {{trans("message.complete_register_means_v4")}}
                                </small>
                            </p>

                            <div class="mb-5 info-paraf mt-0">
                                <small>{{trans("message.i_have_account")}}
                                    <a href="{{  route('login') }}">{{trans("message.login")}}</a>
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
