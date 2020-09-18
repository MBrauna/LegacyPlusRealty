@extends('layouts.legacy')

@section('pageName','Group list')

@section('body')

    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <div class="row">
                <div class="col-12 col-sm-11 col-md-11 text-center">
                    All groups
                </div>
                <div class="col-12 col-sm-1 col-md-1 text-center">
                    <button type="button" class="btn btn-outline-light btn-sm btn-block" data-toggle="modal" data-target="#createGroup">
                        <i class="fas fa-plus-circle"></i>
                    </button>
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
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Users in</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot class="bg-primary text-white">
                        <tr class="bg-primary text-white">
                            <th text-center>ID</th>
                            <th>Name</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Users in</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @forelse ($groups as $group)
                        <tr>
                            <td class="text-white text-center bg-primary" style="min-width: 5vw;"><small>#{{ $group->id_users_group }}</small></td>
                            <td class="text-primary" style="min-width: 15vw;"><small>{{ $group->name }}</small></td>
                            <td class="text-primary"><small><i class="{{ $group->icon }}"></i> - {{$group->icon}}</small></td>
                            <td class="text-primary"><small>{{ $group->status ? 'Active' : 'Inactive' }}</small></td>
                            <td class="text-primary"><small>{{ count($group->users_in) }} users</small></td>
                            <td class="text-primary"><small>{{ $group->created_at }}</small></td>
                            <td>
                                <div class="row d-flex justify-content-center">
                                    <form class="col-12 col-sm-6 col-md-6" method="POST" action="{{ route('admin.groups.user') }}">
                                        @csrf
                                        <input type="hidden" name="idGroup" value="{{ $group->id_users_group }}">
                                        <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </form>
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-toggle="modal" data-target="#createGroup_{{ $group->id_users_group }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <h6 class="text-primary text-center">
                                    No groups<br>
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

    <div class="modal fade" id="createGroup" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.groups.save') }}" class="modal-content was-validated" autocomplete="off">
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
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="iconForm">Icon (<a href="https://fontawesome.com/icons?d=gallery" target="_blank">FontAwesome</a>):</label>
                            <input type="text" minlength="5" maxlength="350" class="form-control form-control-sm" id="iconForm" name="iconForm" value="">
                        </div>
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="statusForm">Status:</label>
                            <select class="form-control form-control-sm" id="statusForm" name="statusForm" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
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

    @foreach ($groups as $group)
        <div class="modal fade" id="createGroup_{{ $group->id_users_group }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('admin.groups.update') }}" class="modal-content was-validated" autocomplete="off">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="staticBackdropLabel">Register</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="idGroupForm" value="{{ $group->id_users_group }}">
                        <div class="row">
                            <div class="form-group col-sm-12 col-12 col-md-12">
                                <label for="nameForm">Name:</label>
                                <input type="text" minlength="5" maxlength="350" class="form-control form-control-sm" id="nameForm" name="nameForm" value="{{ $group->name }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-6 col-md-6">
                                <label for="iconForm">Icon (<a href="https://fontawesome.com/icons?d=gallery" target="_blank">FontAwesome</a>):</label>
                                <input type="text" minlength="5" maxlength="350" class="form-control form-control-sm" id="iconForm" name="iconForm" value="{{ $group->icon }}">
                            </div>
                            <div class="form-group col-sm-12 col-6 col-md-6">
                                <label for="statusForm">Status:</label>
                                <select class="form-control form-control-sm" id="statusForm" name="statusForm" required>
                                    @if($group->status)
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    @else
                                        <option value="1">Active</option>
                                        <option value="0" selected>Inactive</option>
                                    @endif
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
    @endforeach

@endsection

@section('script')
    
@endsection