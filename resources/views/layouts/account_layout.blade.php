@extends('layouts.app')
@section('content')

    <section>
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center d-md-none py-4">
                        <!-- heading -->
                        <h3 class="fs-5 mb-0">حساب کاربری</h3>
                        <!-- button -->
                        <button class="btn btn-outline-gray-400 text-muted d-md-none btn-icon btn-sm me-3" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasAccount" aria-controls="offcanvasAccount">
                            <i class="bi bi-text-indent-right fs-3 position-relative" style="top: 3px"></i>
                        </button>
                    </div>
                </div>
                <!-- col -->
                <div class="col-lg-3 col-md-4 col-12 border-start d-none d-md-block mb-4 pb-2">
                    <div class="pt-10">
                        <!-- nav item -->
                        <ul class="nav flex-column nav-pills nav-pills-dark">
                            <li class="nav-item">
                                <a class="nav-link {{ checkActiveMenu(route('profile'), '', 'active') }} }}"
                                    href="{{route("profile")}}">
                                    <i class="feather-icon icon-settings ms-2"></i>
                                    {{trans("message.personal_info")}}
                                </a>
                            </li>
                            @if(auth()->user()->role == "admin")
                                <li class="nav-item">
                                    <a class="nav-link {{ checkActiveMenu(route('dashboard'), '', 'active') }}"
                                        aria-current="page" href="{{ route('dashboard') }}">
                                        <i class="feather-icon icon-grid ms-2"></i>
                                        {{ trans("message.managing_panel") }}
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ checkActiveMenu(route('current.cart'), '', 'active') }} }}"
                                    aria-current="page" href="{{route("current.cart")}}">
                                    <i class="feather-icon icon-shopping-bag ms-2"></i>
                                    {{trans("message.cart")}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ checkActiveMenu(route('user.orders'), '', 'active') }} }}"
                                    aria-current="page" href="{{route("user.orders")}}">
                                    <i class="feather-icon icon-shopping-bag ms-2"></i>
                                    {{trans("message.orders")}}
                                </a>
                            </li>
                            <!-- nav item -->
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link {{ checkActiveMenu(route('user.address'), '', 'active') }} }}"
                                    href="{{route("user.address")}}">
                                    <i class="feather-icon icon-map-pin ms-2"></i>
                                    {{trans("message.my_addresses")}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <hr />
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    href="{{ route('logout') }}">
                                    <i class="feather-icon icon-log-out ms-2"></i>
                                    {{trans("message.exit")}}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @yield("content1")
            </div>
        </div>
    </section>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasAccount" aria-labelledby="offcanvasAccountLabel">
        <!-- offcanvas header -->
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasAccountLabel">{{ env('APP_NAME') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <!-- offcanvas body -->
        <div class="offcanvas-body">
            <ul class="nav flex-column nav-pills nav-pills-dark">
                <li class="nav-item">
                    <a class="nav-link {{ checkActiveMenu(route('profile'), '', 'active') }} }}"
                        href="{{route("profile")}}">
                        <i class="feather-icon icon-settings ms-2"></i>
                        {{trans("message.personal_info")}}
                    </a>
                </li>
                @if(auth()->user()->role == "admin")
                    <li class="nav-item">
                        <a class="nav-link {{ checkActiveMenu(route('dashboard'), '', 'active') }}" aria-current="page"
                            href="{{ route('dashboard') }}">
                            <i class="feather-icon icon-grid ms-2"></i>
                            {{ trans("message.managing_panel") }}
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ checkActiveMenu(route('current.cart'), '', 'active') }} }}" aria-current="page"
                        href="{{route("current.cart")}}">
                        <i class="feather-icon icon-shopping-bag ms-2"></i>
                        {{trans("message.cart")}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ checkActiveMenu(route('user.orders'), '', 'active') }} }}" aria-current="page"
                        href="{{route("user.orders")}}">
                        <i class="feather-icon icon-shopping-bag ms-2"></i>
                        {{trans("message.orders")}}
                    </a>
                </li>
                <!-- nav item -->
                <!-- nav item -->
                <li class="nav-item">
                    <a class="nav-link {{ checkActiveMenu(route('user.address'), '', 'active') }} }}"
                        href="{{route("user.address")}}">
                        <i class="feather-icon icon-map-pin ms-2"></i>
                        {{trans("message.my_addresses")}}
                    </a>
                </li>
                <li class="nav-item">
                    <hr />
                </li>
                <!-- nav item -->
                <li class="nav-item">
                    <a class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        href="{{ route('logout') }}">
                        <i class="feather-icon icon-log-out ms-2"></i>
                        {{trans("message.exit")}}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>

        </div>
    </div>
@endsection