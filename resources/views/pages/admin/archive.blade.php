@extends('layouts.legacy')

@section('pageName','Admin files')

@section('body')

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user" aria-selected="true">User</a>
        </li>
        <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-group-tab" data-toggle="pill" href="#pills-group" role="tab" aria-controls="pills-group" aria-selected="false">Group</a>
        </li>
        <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-contract-tab" data-toggle="pill" href="#pills-contract" role="tab" aria-controls="pills-contract" aria-selected="false">Contract</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
            <form method="POST" action="{{ route('archive.import') }}" enctype="multipart/form-data" class="dropzone border-primary was-validated" id="dropzone">
                <input type="hidden" name="legacy_type" value="4">
                <div class="row">
                    <div class="form-group col-sm-12 col-12 col-md-12 text-primary">
                        <label for="idUser">User:</label>
                        <select class="form-control form-control-sm" id="idUser" name="idUser" required>
                            <option value="" selected>Empty user</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @csrf
                <div class="fallback">
                    <input name="fileToUpload[]" type="file" multiple />
                </div>
            </form>

            @if(count($archiveU) <= 0)
                <h6 class="text-center text-primary">
                    No file to the user<br/>
                    <i class="fas fa-frown-open"></i>
                </h6>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless table-sm">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>Name</th>
                                <th>To user</th>
                                <th>Extension</th>
                                <th>Length</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-primary text-white">
                                <th>Name</th>
                                <th>To user</th>
                                <th>Extension</th>
                                <th>Length</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($archiveU as $archive)
                                <tr>
                                    <td class="text-primary">
                                        <small>
                                            <a href="{{ Storage::url($archive->repository.'/'.$archive->name_server) }}"><i class="fas fa-download"></i></a>
                                            <a href="{{ Storage::url($archive->repository.'/'.$archive->name_server) }}">{{ $archive->name_file }}</a>
                                        </small>
                                    </td>
                                    <td class="text-primary"><small>{{ $archive->user->name }}</small></td>
                                    <td><small>{{ $archive->extension }}</small></td>
                                    <td><small>{{ $archive->length }}</small></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="pills-group" role="tabpanel" aria-labelledby="pills-group-tab">
            <form method="POST" action="{{ route('archive.import') }}" enctype="multipart/form-data" class="dropzone border-primary was-validated" id="dropzone">
                <input type="hidden" name="legacy_type" value="2">
                <div class="row">
                    <div class="form-group col-sm-12 col-12 col-md-12 text-primary">
                        <label for="idGroup">Group:</label>
                        <select class="form-control form-control-sm" id="idGroup" name="idGroup" required>
                            <option value="" selected>Empty group</option>
                            @foreach ($groups as $item)
                                <option value="{{ $item->id_users_group }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @csrf
                <div class="fallback">
                    <input name="fileToUpload[]" type="file" multiple />
                </div>
            </form>

            @if(count($archiveG) <= 0)
                <h6 class="text-center text-primary">
                    No file to the groups<br/>
                    <i class="fas fa-frown-open"></i>
                </h6>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless table-sm">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>Name</th>
                                <th>Group</th>
                                <th>Extension</th>
                                <th>Length</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-primary text-white">
                                <th>Name</th>
                                <th>Group</th>
                                <th>Extension</th>
                                <th>Length</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($archiveG as $archive)
                                <tr>
                                    <td class="text-primary">
                                        <small>
                                            <a href="{{ Storage::url($archive->repository.'/'.$archive->name_server) }}"><i class="fas fa-download"></i></a>
                                            <a href="{{ Storage::url($archive->repository.'/'.$archive->name_server) }}">{{ $archive->name_file }}</a>
                                        </small>
                                    </td>
                                    <td class="text-primary"><small>{{ $archive->group->name }}</small></td>
                                    <td><small>{{ $archive->extension }}</small></td>
                                    <td><small>{{ $archive->length }}</small></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="pills-contract" role="tabpanel" aria-labelledby="pills-contract-tab">
            <form method="POST" action="{{ route('archive.import') }}" enctype="multipart/form-data" class="dropzone border-primary was-validated" id="dropzone">
                <input type="hidden" name="legacy_type" value="3">
                <div class="row">
                    <div class="form-group col-sm-12 col-12 col-md-12 text-primary">
                        <label for="idContract">Contract:</label>
                        <select class="form-control form-control-sm" id="idContract" name="idContract" required>
                            <option value="" selected>Empty contact</option>
                        </select>
                    </div>
                </div>
                @csrf
                <div class="fallback">
                    <input name="fileToUpload[]" type="file" multiple />
                </div>
            </form>

            @if(count($archiveC) <= 0)
                <h6 class="text-center text-primary">
                    No file to the user<br/>
                    <i class="fas fa-frown-open"></i>
                </h6>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless table-sm">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>Name</th>
                                <th>Extension</th>
                                <th>Length</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-primary text-white">
                                <th>Name</th>
                                <th>Extension</th>
                                <th>Length</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($archiveC as $archive)
                                <tr>
                                    <td class="text-primary">
                                        <small>
                                            <a href="{{ Storage::url($archive->repository.'/'.$archive->name_server) }}"><i class="fas fa-download"></i></a>
                                            <a href="{{ Storage::url($archive->repository.'/'.$archive->name_server) }}">{{ $archive->name_file }}</a>
                                        </small>
                                    </td>
                                    <td><small>{{ $archive->extension }}</small></td>
                                    <td><small>{{ $archive->length }}</small></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('layout')
    <link href="/legacy/vendor/dropzone/dist/dropzone.css" rel="stylesheet">
@endsection

@section('script')
    <script src="/legacy/vendor/dropzone/dist/dropzone.js"></script>
    <script type="text/javascript">

        Dropzone.options.dropzone = {
            maxFilesize: 12,
            addRemoveLinks: true,
            timeout: 5000,
            parallelUploads:10,
            dictDefaultMessage: "Drop files here to upload on Legacy Plus Realty",
            success: function(file, response) {
                location.reload();
            },
        };
    </script>
@endsection