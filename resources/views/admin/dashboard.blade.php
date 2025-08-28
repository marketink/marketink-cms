@extends('admin.layouts.app')

@section('script')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets/admin/js/plugins/chartjs.min.js') }}"></script>

@endsection

@section('content')

    <div class="container-fluid py-2">
        <div class="row">
            @foreach ($reports as $item)
                <div class="col-6 col-sm-6 mb-2">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between p-3 pt-2 rounded-2">
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">report</i>
                            </div>
                            <div class="text-start pt-1">
                                <p class="text-sm mb-0 text-capitalize">{{ $item['count_label'] }}</p>
                                <h4 class="text-md mb-0 mt-1">{{ number_format($item['count_data']) }} {{ $item['count_info'] }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            @foreach ($reports as $report)
                <div class="col-lg-6 col-md-6 mt-2 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-0 ">{{ $report['chart_label'] }}</h6>
                            <p class="text-sm ">{{ $report['chart_info'] }}</p>
                            <div class="pe-2">
                                <div class="chart chart-init" data-background="#000" data-label="{{ $report['count_info'] }}"
                                    data-labels="{{ $report['chart_data']->pluck('month')->join(',') }}"
                                    data-data="{{ $report['chart_data']->pluck('total')->join(',') }}">
                                    <canvas class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-symbols-rounded text-sm my-auto ms-1">schedule</i>
                                <p class="mb-0 text-sm">  {{trans("message.chart_v1")." ".  $report['month']." ". trans("message.chart_v2") }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @include('admin.layouts.footer')
    </div>
@endsection
