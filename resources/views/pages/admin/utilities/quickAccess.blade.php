@extends('layouts.legacy')

@section('pageName','Quick links')

@section('body')
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <div class="row">
                <div class="col-12 col-sm-10 col-md-11 text-center">
                    All links
                </div>
                <div class="col-12 col-sm-2 col-md-1 text-center">
                    <button type="button" class="btn btn-outline-light btn-sm btn-block" data-toggle="modal" data-target="#addLinks">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse ($quickAccess as $item)
                    <li class="list-group-item text-primary border-primary">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 mt-1">
                                <a href="{{ $item->url }}" target="_blank">{{ $item->description }}</a>
                            </h6>
                            <form method="POST" action="{{ route('admin.utilities.linkRemove') }}">
                                @csrf
                                <input type="hidden" name="idQuickAccess" value="{{ $item->id_quick_access }}">
                                <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-primary border-primary">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">No quick links</h6>
                            <h6><i class="fas fa-frown-open"></i></h6>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>


    <div class="modal fade" id="addLinks" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.utilities.linkAdd') }}" class="modal-content was-validated" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Add quick link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="description">Description:</label>
                            <input type="text" name="description" id="description" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="url">Url:</label>
                            <input type="url" name="url" id="url" class="form-control form-control-sm" required>
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

@section('layout')

@endsection

@section('script')

@endsection