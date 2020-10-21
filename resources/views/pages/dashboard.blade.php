@extends('layouts.legacy')

@section('pageName','Dashboard')

@section('body')
    <!-- Content Row -->
    <div class="row">
        <div class="col-12 col-sm-8 col-md-8 col-lg-8">
            <div class="row">
                <div class="col-12">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Earnings (Monthly)<br/>
                                        <small class="text-muted"> between {{ $monthMin }} and {{ $monthMax }}</small>
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalMonth ?? 'US$ 0.00' }} ({{ $totalComissionMonth ?? 'US$ 0.00' }} + {{ $totalAdditionalMonth ?? 'US$ 0.00' }})
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Earnings (Year)<br/>
                                        <small class="text-muted"> between {{ $monthMin }} and {{ $monthMax }}</small>
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalYear ?? 'US$ 0.00' }} ({{ $totalComissionYear ?? 'US$ 0.00' }} + {{ $totalAdditionalYear ?? 'US$ 0.00' }})
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4 col-md-4 col-lg-4">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center text-primary font-weight-bold">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="col-12">
                            <span class="text-primary font-weight-bold">ID:</span> #{{ Auth::user()->id }}
                        </div>


                        <h6 class="col-12 text-center bg-primary text-white mt-3 pt-1 pb-1 font-weight-bold rounded">License</h6>
                        @if(is_null(Auth::user()->license))
                        <span class="col-12 text-center">Without license</span>
                        @else
                        <div class="col-12">
                            <span class="text-primary font-weight-bold">License:</span> {{ Auth::user()->license ?? 'without license' }}
                        </div>
                        <div class="col-12">
                            <span class="text-primary font-weight-bold">License date:</span> {{ is_null(Auth::user()->license_date) ? 'without date' : \Carbon\Carbon::parse(Auth::user()->license_date)->format('m/d/Y') }}
                        </div>
                        <div class="col-12">
                            <span class="text-primary font-weight-bold">License due:</span> {{ is_null(Auth::user()->license_due) ? 'without date' : \Carbon\Carbon::parse(Auth::user()->license_date)->format('m/d/Y') }}
                        </div>
                        @endif
                        

                        <h6 class="col-12 text-center bg-primary text-white mt-3 pt-1 pb-1 font-weight-bold rounded">Parameter</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-primary">Type</th>
                                        <th class="text-primary">Min value</th>
                                        <th class="text-primary">Max value</th>
                                        <th class="text-primary">% split</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataComission as $item)
                                        <tr>
                                            <td class="text-primary"><small>{{ $item->allDesc->type }}</small></td>
                                            <td class="text-primary"><small>{{ $item->allDesc->min }}</small></td>
                                            <td class="text-primary"><small>{{ $item->allDesc->max }}</small></td>
                                            <td class="text-primary"><small>{{ $item->allDesc->perc }}</small></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="table-responsive">
        
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

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    ordering:  true,
                    responsive: true,
                    paging: true,
                });
            });
        </script>

@endsection

@section('layout')
    <link href="/legacy/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection