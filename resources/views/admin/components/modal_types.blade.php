@foreach ($types as $type)
    <div class="modal fade" id="content-{{ $type['type'] }}-form-modal"
        aria-labelledby="content-{{ $type['type'] }}-form-modal-label" data-table="contents">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="content-{{ $type['type'] }}-form-modal-label"> {{trans("message.create")." ". $type['name'] }}</h6>
                </div>
                <div class="modal-body">

                    @if (isset($type['media']) && $type['media'] == true)
                        <div class="row">
                            @if (isset($type['files']))
                                <?php            $fileI = 0; ?>
                                @foreach ($type['files'] as $file)
                                    <?php                ++$fileI; ?>
                                    <div class="col-12 {{  count($type['files']) > 1 ? 'col-sm-6' : 'col-sm-12' }} mb-2">
                                        <form data-success="files" method="POST"
                                            action="{{ route('files.store') }}?content={{ $type['type'] }}&type={{ $file }}"
                                            enctype="multipart/form-data" class="dropzone" data-dropzone-type="{{ $file }}"
                                            title="{{ trans("message.dropzone_title", [
                                                "logo" => trans("message." . $file)
                                            ]) }}"
                                            id="dropzone-{{ $type['type'] }}-{{ $file }}">
                                            @csrf
                                        </form>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    <form data-success="contents" class="content-submit-form form-box-{{ $type['type'] }} main-form"
                        method="post" action="{{ route('contents.store') }}">
                        <input type="hidden" name="type" value="{{ $type['type'] }}" />
                        <input type="hidden" name="lang" value="{{ defaultLang() }}" />
                        <input type="hidden" name="currency" value="{{ defaultCurrency() }}" />
                        @csrf()

                        @if (isset($type['label']))
                            <?php        $formI = 0;?>
                            @foreach ($type['label'] as $value => $key)
                                <?php            ++$formI; ?>
                                <div class="input-group input-group-outline my-3">
                                    @if($key == "string")
                                        <label class="form-label">{{ trans("message." . $value) }}</label>
                                        <input type="text" class="form-control" name="texts[{{ $formI }}][text]" required />
                                    @endif
                                    @if($key == "link")
                                        <label class="form-label">{{ trans("message." . $value) }}</label>
                                        <input type="url" class="form-control" name='texts[{{ $formI }}][text]' required />
                                    @endif
                                    @if($key == "text")
                                        <textarea type="text" placeholder='{{ trans("message." . $value) }}' class="form-control"
                                            name="texts[{{ $formI }}][text]" required></textarea>
                                    @endif
                                </div>
                                <input type="hidden" name="texts[{{ $formI }}][label]" value="{{ $value }}" />
                            @endforeach
                        @endif

                        @if (isset($type['price']) && $type['price'] == true)
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">{{trans("message.price")}}</label>
                                <input type="int" class="form-control" name="price" required />
                            </div>
                        @endif

                        @if (isset($type['discount']) && $type['discount'] == true)
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">{{trans("message.discount")}}</label>
                                <input type="int" min="0" max="100" class="form-control" name="discount" required />
                            </div>
                        @endif

                        @if (isset($type['stock']) && $type['stock'] == true)
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">{{trans("message.stock")}}</label>
                                <input type="int" class="form-control" name="stock" required />
                            </div>
                        @endif

                        @if(isset(collect(statuses())->where('type', $type['type'])->first()['status']))
                            <div class="input-group input-group-outline my-3">
                                <select class="form-control" name="status" required>
                                    @foreach (collect(statuses())->where('type', $type['type'])->first()['status'] as $status)
                                        <option value="{{ $status }}">{{ trans("message." . $status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if (isset(collect(types())->where('type', $type['type'])->first()['relations']))
                            @foreach (collect(types())->where('type', $type['type'])->first()['relations'] as $relation)
                                <div class="smart-form-init hidden">
                                    <h6>{{ trans("message." . $relation['to']) }}</h6>
                                    <div class="smart-form"
                                        url="{{ route('contents.index') }}?type={{ $relation['to'] }}&parent=main"></div>
                                </div>
                            @endforeach
                        @endif

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal mb-0" data-dismiss="modal">{{trans("message.close")}}</button>
                    <button type="button" class="btn btn-primary mb-0 send-form"
                        data-form=".form-box-{{ $type['type'] }}">{{trans("message.send")}}</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
