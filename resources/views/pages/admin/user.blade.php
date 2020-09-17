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
                    <button type="button" class="btn btn-outline-light btn-sm btn-block" data-toggle="modal" data-target="#createUser">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user" aria-selected="false">User</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-admin-tab" data-toggle="pill" href="#pills-admin" role="tab" aria-controls="pills-admin" aria-selected="true">Admin</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-borderless table-sm" id="dataTable" cellspacing="0">
                            <thead>
                                <tr class="bg-primary text-white text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot class="bg-primary text-white">
                                <tr class="bg-primary text-white text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="text-white text-center bg-primary" style="min-width: 5vw;"><small>#{{ $user->id }}</small></td>
                                    <td class="text-primary" style="min-width: 20vw;"><small>{{ $user->name }}</small></td>
                                    <td class="text-primary" style="min-width: 10vw;"><small><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></small></td>
                                    <td class="text-primary"><small>{{ $user->created_at }}</small></td>
                                    <td>
                                        <div class="row d-flex justify-content-center">
                                            <form class="col-12 col-sm-6 col-md-6" method="POST" action="{{ route('admin.users.group') }}">
                                                @csrf
                                                <input type="hidden" name="idUser" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </form>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-toggle="modal" data-target="#createUser_{{ $user->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h6 class="text-primary text-center">
                                            No users<br>
                                            <i class="fas fa-frown"></i>
                                        </h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-admin" role="tabpanel" aria-labelledby="pills-admin-tab">
                    <div class="table-responsive rounded-lg">
                        <table class="table table-hover table-striped table-borderless table-sm" id="dataTable" cellspacing="0">
                            <thead>
                                <tr class="bg-primary text-white text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot class="bg-primary text-white">
                                <tr class="bg-primary text-white text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            @forelse ($admins as $admin)
                                <tr>
                                    <td class="text-white text-center bg-primary" style="min-width: 5vw;"><small>#{{ $admin->id }}</small></td>
                                    <td class="text-primary" style="min-width: 20vw;"><small>{{ $admin->name }}</small></td>
                                    <td class="text-primary" style="min-width: 10vw;"><small><a href="mailto:{{ $admin->email }}">{{ $admin->email }}</a></small></td>
                                    <td class="text-primary"><small>{{ $admin->created_at }}</small></td>
                                    <td>
                                        <div class="row d-flex justify-content-center">
                                            <form class="col-12 col-sm-6 col-md-6" method="POST" action="{{ route('admin.users.group') }}">
                                                @csrf
                                                <input type="hidden" name="idUser" value="{{ $admin->id }}">
                                                <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </form>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-toggle="modal" data-target="#createUser_{{ $admin->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h6 class="text-primary text-center">
                                            No users<br>
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
        </div>
    </div>

    <div class="modal fade" id="createUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.save') }}" class="modal-content was-validated" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="nameForm">Name:</label>
                            <input type="text" minlength="5" maxlength="350" class="form-control form-control-sm" id="nameForm" name="nameForm" value="" required>
                        </div>
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="emailForm">E-mail:</label>
                            <input type="email" minlength="5" maxlength="350" class="form-control form-control-sm" id="emailForm" name="emailForm" value="" required>
                        </div>
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="adminForm">Admin:</label>
                            <select class="form-control form-control-sm" id="adminForm" name="adminForm" required>
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="passwordForm">Password:</label>
                            <input type="password" minlength="5" maxlength="40" class="form-control form-control-sm" id="passwordForm" name="passwordForm" value="" required>
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


    @foreach ($users as $user)
    <div class="modal fade" id="createUser_{{ $user->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.update') }}" class="modal-content was-validated" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel_{{ $user->id }}">Update {{ $user->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="idUserForm" value="{{ $user->id }}">
                    <div class="row">
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="nameForm">Name:</label>
                            <input type="text" minlength="5" maxlength="350" class="form-control form-control-sm" id="nameForm" name="nameForm" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="emailForm">E-mail:</label>
                            <input type="email" minlength="5" maxlength="350" class="form-control form-control-sm" id="emailForm" name="emailForm" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="adminForm">Admin:</label>
                            <select class="form-control form-control-sm" id="adminForm" name="adminForm" required>
                                @if($user->admin)
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                @else
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="passwordForm">Password:</label>
                            <input type="password" minlength="5" maxlength="40" class="form-control form-control-sm" id="passwordForm" name="passwordForm" aria-describedby="passwordHelp" value="">
                            <small id="passwordHelp" class="form-text text-muted">Keep blank to preserve the previous password.</small>
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
    @endforeach

    @foreach ($admins as $user)
    <div class="modal fade" id="createUser_{{ $user->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.update') }}" class="modal-content was-validated" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel_{{ $user->id }}">Update {{ $user->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="idUserForm" value="{{ $user->id }}">
                    <div class="row">
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="nameForm">Name:</label>
                            <input type="text" minlength="5" maxlength="350" class="form-control form-control-sm" id="nameForm" name="nameForm" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="emailForm">E-mail:</label>
                            <input type="email" minlength="5" maxlength="350" class="form-control form-control-sm" id="emailForm" name="emailForm" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="adminForm">Admin:</label>
                            <select class="form-control form-control-sm" id="adminForm" name="adminForm" required>
                                @if($user->admin)
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                @else
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="passwordForm">Password:</label>
                            <input type="password" minlength="5" maxlength="40" class="form-control form-control-sm" id="passwordForm" name="passwordForm" aria-describedby="passwordHelp" value="">
                            <small id="passwordHelp" class="form-text text-muted">Keep blank to preserve the previous password.</small>
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
    @endforeach

@endsection

@section('script')
    
@endsection