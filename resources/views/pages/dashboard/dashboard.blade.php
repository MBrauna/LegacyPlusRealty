@extends('layouts.legacy')

@section('pageName','Dashboard')

@section('body')
    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 col-sm-12 col-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings (Monthly)<br/>
                                <small class="text-muted"> between {{ $monthMin }} and {{ $monthMax }}</small>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthSum ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 col-sm-12 col-12  mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)<br/>
                                <small class="text-muted"> between {{ $yearMin }} and {{ $yearMax }}</small>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $yearSum ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Content Row -->
    <div class="table-responsive">
        <table class="table table-sm table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">Month</th>
                    <th class="text-left">Contracts</th>
                    <th class="text-right">Comission US$</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contracts as $item)
                    <tr class="text-primary">
                        <th style="min-width: 20vw;" class="text-center">{{ $item->desc_date }}</th>
                        <th style="min-width: 20vw;" class="text-left">{{ $item->count_comission }} contracts</th>
                        <th style="min-width: 20vw;" class="text-right">{{ $item->value }}</th>
                    </tr>
                @empty

                    <tr>
                        <td colspan="5">
                            <h6 class="text-center text-primary">
                                <b>No comission available</b><br/>
                                <i class="fas fa-frown"></i>
                            </h6>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')

        <!-- Page level plugins -->
        <script src="/legacy/vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="/legacy/js/demo/chart-area-demo.js"></script>
        <script src="/legacy/js/demo/chart-pie-demo.js"></script>

        <!-- Page level plugins -->
        <script src="/legacy/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="/legacy/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="/legacy/js/demo/datatables-demo.js"></script>

@endsection