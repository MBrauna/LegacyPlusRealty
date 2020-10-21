@extends('layouts.legacy')

@section('pageName','Quick links')

@section('body')
    <div class="card border-primary">
        <div class="card-header bg-primary text-white text-center">
            Quick Access
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse ($links as $item)
                    <li class="list-group-item text-primary border-primary">
                        <div class="d-flex w-100 justify-content-between">
                            <i class="fas fa-link"></i>
                            <h6 class="mb-1 mt-1 text-center">
                                <a href="{{ $item->url }}" target="_blank">
                                    {{ $item->description }}<br/>
                                    <small class="text-muted">{{ $item->url}}</small>
                                </a>
                            </h6>
                            <i class="fas fa-link"></i>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-primary border-primary">
                        <div class="d-flex w-100 justify-content-between">
                            <h6><i class="fas fa-frown-open"></i></h6>
                            <h6 class="mb-1">No quick links</h6>
                            <h6><i class="fas fa-frown-open"></i></h6>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection

@section('script')
    <!-- Page level plugins 
    <script src="/legacy/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/legacy/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
@endsection