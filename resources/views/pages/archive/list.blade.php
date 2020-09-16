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
                                            <a href="{{ Storage::url($archive->repository.'/'.$archive->name_server) }}">
                                                <i class="fas fa-download"></i> {{ $archive->name_file }}
                                            </a>
                                        </small>
                                    </td>
                                    <td><small>{{ $archive->name_file }}</small></td>
                                    <td><small>{{ $archive->repository }}</small></td>
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
            success: function(file, response) {
            }
        };
    </script>
@endsection