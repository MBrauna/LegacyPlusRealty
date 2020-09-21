@extends('layouts.legacy')

@section('pageName','Contract #'.$contract->id_contract)

@section('body')

    <div class="card border-primary">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <div style="min-width: 10vw;">
                <a href="{{ route('contract.list') }}" class="btn btn-outline-light btn-sm btn-block">
                    <i class="fas fa-caret-square-left"></i>
                </a>
            </div>
            <span>Contract #{{ $contract->id_contract }} - {{ $contract->allDesc->start_contract }}</span>
            <div style="min-width: 10vw;"></div>
        </div>
        <div class="card-body">
            <div class="row text-primary">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="id_contract">#ID</label>
                        <input type="text" readonly class="form-control form-control-sm" id="id_contract" value="{{ $contract->id_contract }}">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="id_contract">Contract start</label>
                        <input type="text" readonly class="form-control form-control-sm" id="start_contract" value="{{ $contract->allDesc->start_contract }}">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="id_contract">Contract end</label>
                        <input type="text" readonly class="form-control form-control-sm" id="end_contract" value="{{ $contract->allDesc->end_contract }}">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="id_contract">Payment date</label>
                        <input type="text" readonly class="form-control form-control-sm" id="payment_date" value="{{ $contract->allDesc->payment_date }}">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="id_contract">Contract value</label>
                        <input type="text" readonly class="form-control form-control-sm" id="value" value="{{ $contract->allDesc->value }}">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="id_contract">Seller</label>
                        <input type="text" readonly class="form-control form-control-sm" id="id_user_seller" value="{{ $contract->allDesc->id_user_seller->name ?? 'Not defined' }}">
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea readonly class="form-control form-control-sm" id="description">{{ $contract->description }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card border-primary mt-4">
                <div class="card-header bg-primary text-white text-center">
                    Address
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-4">
                        <table class="table table-sm table-hover" id="tableAddress">
                            <thead>
                                <tr class="text-primary">
                                    <th><small>Address</small></th>
                                    <th><small>City</small></th>
                                    <th><small>State</small></th>
                                    <th><small>Country</small></th>
                                    <th><small>Postal Code</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($address as $item)
                                    <tr class="text-primary">
                                        <td><small>{{ $item->address }}</small></td>
                                        <td><small>{{ $item->city }}</small></td>
                                        <td><small>{{ $item->state }}</small></td>
                                        <td><small>{{ $item->country }}</small></td>
                                        <td><small>{{ $item->postal_code }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <h6 class="text-primary">No data</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-primary mt-4">
                <div class="card-header bg-primary text-white text-center">
                    Phone
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="tablePhone">
                            <thead>
                                <tr class="text-primary">
                                    <th><small>DDI</small></th>
                                    <th><small>DDD</small></th>
                                    <th><small>Phone</small></th>
                                    <th><small>Final contact</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($phone as $item)
                                    <tr class="text-primary">
                                        <td style="min-width: 5vw;"><small>{{ $item->ddi ?? '01' }}</small></td>
                                        <td style="min-width: 5vw;"><small>{{ $item->ddd ?? '00'}}</small></td>
                                        <td style="min-width: 5vw;"><small>{{ $item->phone }}</small></td>
                                        <td><small>+{{ $item->ddi ?? '01' }}({{ $item->ddd ?? '00' }}) {{ $item->phone }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <h6 class="text-primary">No data</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-primary mt-4">
                <div class="card-header bg-primary text-white text-center">
                    Files
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr class="text-primary">
                                            <th><small>Name file</small></th>
                                            <th><small>Extension</small></th>
                                            <th><small>Upload at</small></th>
                                            <th><small>User</small></th>
                                            <th><small>Length</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($archive as $item)
                                            <tr>
                                                <td class="text-primary"><small><a href="{{ Storage::url($item->repository.'/'.$item->name_server) }}">{{ $item->name_file }}</a></small></td>
                                                <td><small>{{ $item->extension }}</small></td>
                                                <td><small>{{ $item->allDesc->created_at }}</small></td>
                                                <td><small>{{ $item->allDesc->id_user_created->name ?? 'error' }}</small></td>
                                                <td class="text-right"><small>{{ $item->allDesc->length }}</small></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <h6 class="text-primary text-center">No files</h6>
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
        </div>
    </div>

@endsection


@section('layout')

@endsection

@section('script')
@endsection