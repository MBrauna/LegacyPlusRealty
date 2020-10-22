@extends('layouts.legacy')

@section('pageName','Global parameter')

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th><small>Name</small></th>
                            <th><small>Variable</small></th>
                            <th style="min-width: 30vw;"><small>Value</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($parameters as $item)
                            <tr>
                                <td><small>{{ $item->visual_name }}</small></td>
                                <td><small>{{ $item->param_name }}</small></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.utilities.paramAdd') }}">
                                        @csrf
                                        <input type="hidden" value="{{ $item->id_split_parameter }}" name="idSplitParameter">
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <input type="number" step="0.01" value="{{ $item->value }}" class="form-control form-control-sm text-right" id="param_value" name="param_value" aria-describedby="ParamValue" placeholder="Insert value" required>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-sm btn-block btn-primary">
                                                    Alter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-primary text-center">No data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('layout')

@endsection

@section('script')

@endsection