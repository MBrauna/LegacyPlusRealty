@extends('layouts.legacy')

@section('pageName','File List')

@section('body')

    <form method="post" action="{{ route('archive.import') }}" enctype="multipart/form-data" class="dropzone" id="dropzone">
        <input type="hidden" name="legacy_type" value="1">
        @csrf
        <div class="fallback">
            <input name="fileToUpload[]" type="file" multiple />
        </div>
    </form>

    <div class="card shadow-sm border-bottom-primary">
        <div class="card-header bg-primary text-white text-center">
            Lista de arquivos
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-archive-tab" data-toggle="pill" href="#v-pills-archive" role="tab" aria-controls="v-pills-archive" aria-selected="true">Files for {{ explode(' ',Auth::user()->name)[0] }}</a>

                        @foreach ($groups as $group)
                            <a class="nav-link" id="v-pills-{{ $group->id_users_group }}-tab" data-toggle="pill" href="#v-pills-{{ $group->id_users_group }}" role="tab" aria-controls="v-pills-{{ $group->id_users_group }}" aria-selected="true">{{ $group->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-archive" role="tabpanel" aria-labelledby="v-pills-archive-tab">
                            @if(count($archives) <= 0)
                                <h6 class="text-center text-primary">
                                    No file to the user<br/>
                                    <i class="fas fa-frown-open"></i>
                                </h6>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-borderless table-sm">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Extension</th>
                                                <th>Length</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Extension</th>
                                                <th>Length</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($archives as $archive)
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

                        @foreach ($groups as $group)

                            <div class="tab-pane fade" id="v-pills-{{ $group->id_users_group }}" role="tabpanel" aria-labelledby="v-pills-{{ $group->id_users_group }}-tab">
                                @if(count($group->archive) <= 0)
                                    <h6 class="text-center text-primary">
                                        No files<br/>
                                        <i class="fas fa-frown-open"></i>
                                    </h6>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-borderless table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Extension</th>
                                                    <th>Length</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Extension</th>
                                                    <th>Length</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($group->archive as $archive)
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
                        @endforeach
                    </div>
                </div>
            </div>
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