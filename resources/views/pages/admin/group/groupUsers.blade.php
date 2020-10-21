@extends('layouts.legacy')

@section('pageName','Group')

@section('body')

    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <div class="row">
                <form class="col-12 col-sm-1 col-md-1 text-center" method="POST" action="{{ route('admin.group.list') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm btn-block">
                        <i class="fas fa-backward"></i>
                    </button>
                </form>
                <div class="col-12 col-sm-10 col-md-10 text-center">
                    All users for {{ $idGroup->name }}
                </div>
                <div class="col-12 col-sm-1 col-md-1 text-center">
                    <button type="button" class="btn btn-outline-light btn-sm btn-block" data-toggle="modal" data-target="#addGroup">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse ($UsersGroup as $item)
                    <li class="list-group-item text-primary border-primary">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                {{ $item->name }}
                            </h6>
                            <form method="POST" action="{{ route('admin.group.removeGroup') }}">
                                @csrf
                                <input type="hidden" name="idUser" value="{{ $item->id }}">
                                <input type="hidden" name="idGroup" value="{{ $idGroup->id_group }}">
                                <input type="hidden" name="redirectTo" value="1">
                                <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-primary border-primary">
                        <div class="d-flex w-100 justify-content-between">
                            <h5><i class="fas fa-frown-open"></i></h5>
                            <h6 class="mb-1">No users</h6>
                            <h5><i class="fas fa-frown-open"></i></h5>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>


    <div class="modal fade" id="addGroup" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.group.addGroup') }}" class="modal-content was-validated" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="idGroup" value="{{ $idGroup->id_group }}">
                    <input type="hidden" name="redirectTo" value="1">
                    <div class="row">
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="idUser">User:</label>
                            <select class="form-control" id="idUser" name="idUser" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
    
@endsection