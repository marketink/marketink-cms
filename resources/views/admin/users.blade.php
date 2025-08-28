@extends('admin.layouts.app')

@section('content')

    <div class="container-fluid py-2">

        <div class="row mt-1">
            <div class="col-lg-12 col-md-12 mb-md-0 mb-1">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row mb-3">
                            <div class="col-6">
                                <h6>{{trans("message.users")}}</h6>
                                <p class="text-sm">
                                    <i class="fa fa-check text-info" ></i>
                                    {{trans("message.show_all_users")}}
                                </p>
                            </div>
                            <div class="col-6 my-auto text-start">
                                <div class="dropdown float-start ps-4">
                                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-secondary"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-n4"
                                        aria-labelledby="dropdownTable">
                                        <li><a class="dropdown-item border-radius-md open-modal"
                                                data-form="#user-form-modal .user-submit-form"
                                                data-target="#user-form-modal" href="javascript:;">{{trans("message.create_user")}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3">
                        <div class="data-table">
                            <table data-url="{{ route('users.index') }}" data-id="users" class="display nowrap"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th data="id">{{trans("message.english_id")}}</th>
                                        <th data="first_name">{{trans("message.first_name")}}</th>
                                        <th data="last_name">{{trans("message.last_name")}}</th>
                                        <th data="username">{{trans("message.phone_number")}}</th>
                                        <th data="role">{{trans("message.role")}}</th>
                                        <th data="created_at">{{trans("message.register_time")}}</th>
                                        <th data="action" scope="edit,delete">{{trans("message.tools")}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="user-form-modal" aria-labelledby="user-form-modal-label" data-table="users">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="user-form-modal-label">{{trans("message.create_user")}}
                        </h6>
                    </div>
                    <div class="modal-body">

                        <form data-success="users" class="content-submit-form form-box-user main-form" method="post"
                            action="{{ route('users.store') }}">
                            @csrf()

                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">{{trans("message.first_name")}}</label>
                                <input type="text" class="form-control" name="first_name" required />
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">{{trans("message.last_name")}}</label>
                                <input type="text" class="form-control" name="last_name" required />
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">{{trans("message.phone_number")}}</label>
                                <input type="text" class="form-control" name="username" required />
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">{{trans("message.password")}}</label>
                                <input type="password" class="form-control" name="password" />
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <select class="form-control" name="role" required>
                                    @foreach (roles() as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-modal mb-0" data-dismiss="modal">بستن</button>
                        <button type="button" class="btn btn-primary mb-0 send-form"
                            data-form=".form-box-user">{{trans("message.send")}}</button>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.footer')
    </div>
@endsection
