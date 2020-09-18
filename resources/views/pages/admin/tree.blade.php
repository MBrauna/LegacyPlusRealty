@extends('layouts.legacy')

@section('pageName','Tree')

@section('layout')
    <link href="/legacy/vendor/jquery-tree/css/jquery.treegrid.css" rel="stylesheet">
@endsection

@section('body')

    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <div class="row">
                <div class="col-12 col-sm-9 col-md-10 text-center">
                    Tree
                </div>
                <div class="col-12 col-sm-3 col-md-2 text-center">
                    <button type="button" class="btn btn-outline-light btn-sm btn-block" data-toggle="modal" data-target="#addItem">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsible">
                <table class="table table-hover table-borderless table-sm tree">
                    <tr class="treegrid-0">
                        <td><small>Root node</small></td>
                        <td><small>Actions</small></td>
                    </tr>
                    @foreach ($tree as $item)
                        {{ render_tree($item) }}
                    @endforeach
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addItem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.tree.add') }}" class="modal-content was-validated" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="idPrevNode">Previous node:</label>
                            <select class="form-control form-control-sm" id="idPrevNode" name="idPrevNode">
                                <option value="" selected>Root node</option>
                                @foreach($treeList as $item)
                                    <option value="{{ $item->id_tree_comission }}">#{{ $item->id_tree_comission }} - {{ $item->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-6 col-md-6">
                            <label for="idUser">User:</label>
                            <select class="form-control form-control-sm" id="idUser" name="idUser" required>
                                @foreach($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="idUser">Percentual comission:</label>
                            <input type="number" class="form-control form-control-sm" step="0.01" name="percentual" id="percentual">
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
    <script src="/legacy/vendor/jquery-tree/js/jquery.treegrid.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.tree').treegrid();
        });
    </script>
@endsection