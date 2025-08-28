@extends('layouts.app')
@section('content')
    <section class="mt-lg-14 mt-8">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="offset-lg-1 col-lg-12 col-12">
                    <!-- row -->
                    <div class="row mb-8">
                        <div class="col-12">
                            <div class="mb-8">
                                <!-- heading -->
                                <h2>{{trans("message.faq")}}</h2>
                            </div>
                        </div>
                        @foreach($faq as $item)
                            <div class="col-md-4">
                                <!-- card -->
                                <div class="card bg-light mb-6 border-0" style="min-height: calc(100% - 25px)">
                                    <!-- card body -->
                                    <div class="card-body p-8">
                                        <h4>{{$item["info"]["question"] ?? ""}}</h4>
                                        <p>
                                            {{ $item["info"]["answer"] ?? "" }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection