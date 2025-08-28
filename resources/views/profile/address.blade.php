@extends('layouts.account_layout')
@section('content1')
    <div class="col-lg-9 col-md-8 col-12">
        <div class="py-6 p-md-6 p-lg-10">
            <div class="d-flex justify-content-between mb-6">
                <!-- heading -->
                <h2 class="mb-0">{{trans("message.my_addresses")}}</h2>
                <!-- button -->
                @if(count($addresses))
                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#addAddressModal">{{trans("message.add_new_address")}}</a>
                @endif
            </div>
            <div class="row">
                <!-- col -->
                @if($addresses && count($addresses) > 0)
                    @foreach($addresses as $address)
                        <div class="col-xk-5 col-lg-6 col-xxl-4 col-12 mb-4">
                            <!-- input -->
                            <div class="card">
                                <div class="card-body p-6">
                                    <div class="form-check mb-4">
                                        <label class="form-check-label text-dark fw-semibold"
                                            for="officeRadio">{{$address->name}}</label>
                                    </div>
                                    <!-- nav item -->
                                    <p class="mb-6">
                                        {{$address->city . " " . $address->address}}
                                    </p>

                                    <div class="mt-4">
                                        <!-- btn -->
                                        <a class="text-danger"
                                            onclick="event.preventDefault(); this.querySelector('form').submit();"
                                            href="javascript:;">
                                            <b>{{trans("message.delete")}}</b>
                                            <form id="logout-form"
                                                action="{{ route('user.address.delete', ["id" => $address->id]) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method("delete")
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="ci-map-pin text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-semibold">{{ trans('message.no_addresses') }}</h5>
                        <p class="text-muted mb-4">{{ trans('message.no_addresses_description') }}</p>
                        <a href="#addAddressModal" data-bs-toggle="modal" class="btn btn-outline-primary">
                            {{ trans('message.add_address') }}
                        </a>
                    </div>
                @endif

            </div>
            <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <!-- modal content -->
                    <div class="modal-content">
                        <!-- modal body -->
                        <div class="modal-body p-6">
                            <div class="d-flex justify-content-between mb-5">
                                <div>
                                    <!-- heading -->
                                    <h5 class="mb-1" id="addAddressModalLabel">{{trans("message.add_new_address")}}</h5>
                                </div>
                                <div>
                                    <!-- button -->
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                            <!-- row -->
                            <form action="{{route("user.address.store")}}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <!-- col -->
                                    <div class="col-12">
                                        <!-- input -->
                                        <input type="text" name="name" value="{{ old('name') }}" id="name"
                                            class="form-control" placeholder="{{trans("message.address_name")}}"
                                            aria-label="First name" required="" />
                                    </div>
                                    <!-- col -->
                                    <div class="col-12">
                                        <!-- input -->
                                        <input type="int" name="postal_code" value="{{ old('postal_code') }}"
                                            id="postal_code" class="form-control"
                                            placeholder="{{trans("message.postal_code"). " " .trans("message.not_required")}}" aria-label="Last name"
                                        />
                                    </div>
                                    <!-- col -->
                                    <div class="col-12">
                                        <!-- input -->
                                        <input type="text" class="form-control" value="{{ old('address') }}" name="address"
                                            id="address" placeholder="{{trans("message.address")}}" />
                                    </div>

                                    <!-- col -->
                                    <div class="col-12">
                                        <div class="position-relative">
                                            <label class="form-label">{{trans('message.city')}}</label>
                                            <select name="city" id="city" class="form-select"
                                                data-select='{"searchEnabled": true}'
                                                aria-label="{{trans('message.choose_your_city')}}" required>
                                                @foreach(getProvinces() as $province)
                                                    <optgroup label="{{$province['name']}}">
                                                        @foreach(getCities($province['id']) as $city)
                                                            <option {{$city['name'] == (old('city') ?? "تهران") ? 'selected' : ''}}>
                                                                {{$city['name']}}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">{{trans('message.choose_city')}}</div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <div class="col-12">
                                        <!-- form check -->
                                        <div class="form-check">
                                            <input class="form-check-input" name="is_default" id="is_default"
                                                type="checkbox" value="" />
                                            <label class="form-check-label"
                                                for="flexCheckDefault">{{trans("message.set_as_is_default")}}</label>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-outline-primary"
                                            data-bs-dismiss="modal">{{trans("message.close")}}</button>
                                        <button class="btn btn-primary" type="submit">{{trans("message.save")}}</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
