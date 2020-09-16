@extends('layouts.legacy')

@section('pageName','Dashboard')

@section('body')
    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
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
        <div class="col-xl-3 col-md-6 mb-4">
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

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Courses completed</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> First hierarchical level
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Second hierarchical level
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Third hierarchical level
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Comission</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-white bg-primary">
                        <tr>
                            <th>Location</th>
                            <th>Name</th>
                            <th>Contract date</th>
                            <th>Value</th>
                            <th>Comission</th>
                        </tr>
                    </thead>
                    <tfoot class="text-white bg-primary">
                        <tr>
                            <th>Location</th>
                            <th>Name</th>
                            <th>Contract date</th>
                            <th>Value</th>
                            <th>Comission</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($contracts as $item)

                            <tr>
                                <th>{{ $item->location }}</th>
                                <th>{{ $item->name }}</th>
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
        </div>
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