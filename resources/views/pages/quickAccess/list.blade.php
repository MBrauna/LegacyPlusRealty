@extends('layouts.legacy')

@section('pageName','Quick Access')

@section('body')
    <!-- Content Row -->
    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Description</th>
                            <th>Url</th>
                        </tr>
                    </thead>
                    <tfoot class="bg-primary text-white">
                        <tr>
                            <th>Description</th>
                            <th>Url</th>
                        </tr>
                    </tfoot>
                    <tbody>

                    @forelse ($quickAccess as $item)

                        <tr>
                            <td><a target="_blank" href="{{ $item->url }}">{{ $item->description }}</a></td>
                            <td><a target="_blank" href="{{ $item->url }}">{{ $item->url }}</a></td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="2">
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

@section('script')
    <!-- Page level plugins 
    <script src="/legacy/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/legacy/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
@endsection