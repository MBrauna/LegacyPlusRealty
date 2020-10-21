@extends('layouts.legacy')

@section('pageName','User list')

@section('body')

    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <div class="row">
                <div class="col-12 col-sm-11 col-md-11 text-center">
                    All users
                </div>
                <div class="col-12 col-sm-1 col-md-1 text-center">
                    <a class="btn btn-outline-light btn-sm btn-block" href="{{ route('admin.user.pageAdd') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-borderless table-sm" id="dataTable" cellspacing="0">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th text-center>ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>License</th>
                            <th>Recommended by</th>
                            <th>Admin</th>
                            <th>Broker</th>
                            <th>Realtor</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-white text-center bg-primary" style="min-width: 5vw;"><small>#{{ $user->id }}</small></td>
                            <td style="min-width: 15vw;" class="text-primary font-weight-bold"><small>{{ $user->name.' '.$user->second_name.' '.$user->last_name }}</small></td>
                            <td><small>{{$user->email}}</small></td>
                            <td><small>{{$user->license ?? 'without license' }}</small></td>
                            <td><small>{{$user->recommendedBy->name ?? ' - ' }}</small></td>
                            <td class="font-weight-bold"><small>{{$user->descUserType ?? 'undefined' }}</small></td>
                            <td style="min-width: 15vw;">
                                <div class="row d-flex justify-content-center">
                                    <form class="col-6" method="POST" action="{{ route('admin.user.pageEdit') }}">
                                        @csrf
                                        <input type="hidden" name="idUser" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </form>
                                    <form class="col-6" method="POST" action="{{ route('admin.user.pageEdit') }}">
                                        @csrf
                                        <input type="hidden" name="idUser" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <h6 class="text-primary text-center">
                                    No user<br>
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
                ordering:  true,
                responsive: true,
                paging: true,
            });
        });
    </script>
@endsection