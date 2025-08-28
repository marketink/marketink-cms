@extends('admin.layouts.app')

@section('content')

    <div class="container-fluid py-2">

        <div class="row mt-1">
            <div class="col-lg-12 col-md-12 mb-md-0 mb-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row mb-3">
                            <div class="col-6">
                                    <h6>{{ $type['name'] }} </h6>
                                <p class="text-sm">
                                    <i class="fa fa-check text-info"></i>
                                     {{ trans("message.view_all"). " " . $type['name']. " " . trans("message.plural_s") }}
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
                                        @foreach ($types as $t)
                                            <li><a class="dropdown-item border-radius-md open-modal open-content-create-model create-or-update-content"
                                                    data-form="#content-{{ $t['type'] }}-form-modal .content-submit-form"
                                                    data-target="#content-{{ $t['type'] }}-form-modal" href="javascript:;">{{trans("message.create")}}
                                                    {{ $t['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3">
                        <div class="data-table" id="data-table-body-contents">
                            <filter class="hidden">
                                <div class="datatable-filters mb-2 d-flex">
                                    <select name="status" class="form-select form-select-sm w-full">
                                        <option value="">{{trans("message.all_statuses")}}</option>
                                        @foreach (collect(statuses())->where('type', $type['type'])->first()['status'] as $status)
                                            <option value="{{$status}}">{{trans('message.' . $status)}}</option>
                                        @endforeach
                                    </select>

                                    <select name="parent" class="form-select form-select-sm w-full">
                                        <option value="">{{trans("message.all_types")}}</option>
                                        <option value="article">{{trans("message.mains")}}</option>
                                    </select>
                                </div>

                            </filter>
                            <table data-url="{{ route('contents.index') }}?type={{ $type['type'] }}" data-id="contents"
                                class="display nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th data="id">{{trans("message.english_id")}}</th>
                                        <th data="info.type_title">{{trans("message.title")}}</th>
                                        @if($type['price'])
                                            <th data="info.final_price" data-label="info.currency_label" data-function="Number(val).toLocaleString('en-US')">قیمت</th>
                                        @endif
                                        <th data="info.type_name">{{trans("message.type")}}</th>
                                        <th data="status_message">{{trans("message.status")}}</th>
                                        <th data="info.created_at.date">{{trans("message.created_at")}}</th>
                                        <th data="info.created_at.time">{{trans("message.created_at_time")}}</th>
                                        <th data="action" scope="edit,delete">{{trans("message.tools")}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('admin.components.modal_types', [
            "types" => $types
        ])
                @include('admin.layouts.footer')
            </div>
@endsection
