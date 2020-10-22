@extends('layouts.legacy')

@section('pageName','List of active contracts')

@section('body')

    <div class="card border-primary shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <div style="min-width: 10vw;"></div>
            <span>List of active contracts</span>
            <div style="min-width: 10vw;">
                <a href="{{ route('admin.contract.create') }}" class="btn btn-outline-light btn-sm btn-block">
                    <i class="fas fa-plus-square"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-sm table-hover table-striped" id="dataTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center"><small>#ID</small></th>
                                <th><small>Value</small></th>
                                <th><small>Type</small></th>
                                <th><small>Contract start</small></th>
                                <th><small>Contract end</small></th>
                                <th><small>Payment</small></th>
                                <th><small>Seller</small></th>
                                <th><small>Actions</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contracts as $item)
                                <tr class="text-primary">
                                    <td style="min-width: 5vw;" class="bg-primary text-white text-right"><small>{{ $item->id_contract }}</small></td>
                                    <td class="text-right text-white bg-primary" style="min-width: 6vw;"><small><b>{{ $item->allDesc->value }}</b></small></td>
                                    <td style="min-width: 6vw;"><small>{{ $item->allDesc->type }}</small></td>
                                    <td style="min-width: 6vw;"><small>{{ $item->allDesc->start_contract }}</small></td>
                                    <td style="min-width: 6vw;"><small>{{ $item->allDesc->end_contract }}</small></td>
                                    <td style="min-width: 6vw;"><small>{{ $item->allDesc->payment_exec }}</small></td>
                                    <td style="min-width: 10vw;"><small>{{ $item->allDesc->id_user_seller->name ?? 'Not defined' }}</small></td>
                                    <td style="min-width: 8vw;" class="row d-flex justify-content-center">
                                        <form action="{{ route('admin.contract.id',['id_contract' => $item->id_contract]) }}" method="POST" class="col-12 col-sm-12 col-md-12">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-block btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <h6 class="text-primary d-flex justify-content-center">No contracts available</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('layout')
    <link href="/legacy/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="/legacy/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/legacy/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                searching: false,
                ordering:  true,
                responsive: true,
                paging: false,
            });
        });
    </script>
@endsection