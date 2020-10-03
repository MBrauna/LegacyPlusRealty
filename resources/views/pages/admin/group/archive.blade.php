@extends('layouts.legacy')

@section('pageName','Archive')

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
                    Archives for {{ $idGroup->name }}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('archive.import') }}" enctype="multipart/form-data" class="dropzone border-primary was-validated" id="dropzone">
                        @csrf
                        <input type="hidden" name="legacy_type" value="2">
                        <input type="hidden" name="idGroup" value="{{ $idGroup->id_group }}">
                        <div class="fallback">
                            <input name="fileToUpload[]" type="file" multiple />
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <ul class="list-group">
                @if(count($archive) <= 0)
                    <li class="list-group-item text-center">
                        No files
                    </li>
                @else
                    @foreach ($archive as $item)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-10 col-sm-10 col-md-10 col-lg-10">
                                <a href="{{ Storage::url($item->repository.'/'.$item->name_server) }}">
                                    <i class="fas fa-file-invoice"></i> - {{ $item->name_file }}
                                </a>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-1">
                                <button class="btn btn-sm btn-primary btn-block">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    @endforeach
                @endif
                
            </ul>
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
            parallelUploads:10,
            dictDefaultMessage: "Drop files here to upload on group {{ $idGroup->name }}",
            totaluploadprogress: function(progress){
                if(progress == 100) {
                    location.reload();
                }
            }
        };
    </script>
@endsection