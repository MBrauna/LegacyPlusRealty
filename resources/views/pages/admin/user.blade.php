@extends('layouts.legacy')

@section('pageName','User list')

@section('body')
    <!-- Content Row -->
    
    <div class="table-responsive rounded">
        <table class="table table-hover table-striped table-borderless table-sm border-left-primary " id="dataTable" cellspacing="0">
            <thead>
                <tr class="bg-primary text-white">
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
@endsection

@section('script')
    <!-- Page level plugins 
    <script src="/legacy/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/legacy/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
@endsection