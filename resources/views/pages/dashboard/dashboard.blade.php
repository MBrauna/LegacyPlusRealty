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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$0</div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$0</div>
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
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="text-white bg-primary">
                <tr>
                    <th>Closing date</th>
                    <th>Sales</th>
                    <th>Comission</th>
                </tr>
            </thead>
            <tfoot class="text-white bg-primary">
                <tr>
                    <th>Closing date</th>
                    <th>Sales</th>
                    <th>Comission</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse ($contracts as $item)

                    <tr>
                        <th>{{ $item->date_contract }}</th>
                        <th>{{ $item->value }}</th>
                        <th>{{ $item->comission }}</th>
                    </tr>
                @empty

                    <tr>
                        <td colspan="5">
                            <h6 class="text-center text-primary">
                                <b>No content available</b><br/>
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