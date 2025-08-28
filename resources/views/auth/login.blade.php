@extends('auth.layouts.app')

@section('content')
    @if (flash()->message)
        <div class="alert alert-success d-flex align-items-center rounded-0 mb-0" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                 class="bi bi-check-circle-fill ms-2" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </svg>
            <div>
                {{ flash()->message }}
            </div>
        </div>
    @endif
    @if (isset($errors) && $errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger d-flex align-items-center rounded-0 mb-0" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                     class="bi bi-exclamation-triangle-fill ms-2" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
                <div>
                    {{ $error }}
                </div>
            </div>
        @endforeach
    @endif
    <section class="my-lg-14 my-8">
        <div class="container">
            <!-- row -->
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2 hidden-in-mobile">
                    <!-- img -->

                    <img src="{{ asset('assets/platform/images/login-page.png')}}" alt=""
                        class="img-fluid border-rounded" />
                </div>
                <!-- col -->
                <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                    <div class="mb-lg-9 mb-5">
                        <h1 class="mb-1 h2 fw-bold">{{trans("message.login")}}</h1>
                        <p>{{trans("message.welcome")}}</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="needs-validation
                            @error('username') was-validated @enderror
                            @error('password') was-validated @enderror
                        " novalidate>
                        @csrf
                        <div class="row g-3">
                            <!-- row -->

                            <div class="col-12">
                                <!-- input -->
                                <label for="formSigninEmail" class="form-label visually-hidden">{{trans("message.phone_number")}}</label>
                                <input type="{{ siteSetting()['usernameType'] }}" class="form-control" id="formSignupEmail" name="username"
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
                                <div class="password-field position-relative">
                                    <label for="formSigninPassword" class="form-label visually-hidden">{{trans("message.password")}}</label>
                                    <div class="password-field position-relative">
                                        <input type="password" name="password" class="form-control fakePassword" id="formSignupPassword"
                                        placeholder="{{trans("message.password")}}" required />
                                        <span><i class="bi bi-eye-slash passwordToggler" style="right: auto !important"></i></span>
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
                            <div class="d-flex justify-content-between">
                                <!-- form check -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                    <!-- label -->
                                    <label class="form-check-label" for="flexCheckDefault">{{trans("message.keep_in_mine")}}</label>
                                </div>
                                <div>
                                    <a href="{{route("password.request")}}">
                                        {{trans("message.i_have_forgot_password")}}

                                    </a>
                                </div>
                            </div>
                            <!-- btn -->
                            <div class="col-12 d-grid"><button type="submit" class="btn btn-primary">{{trans("message.login")}}</button></div>
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
