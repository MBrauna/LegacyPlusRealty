@extends('layouts.legacy')

@section('pageName','Contract')

@section('body')

    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <div class="row">
                <div class="col-12 col-sm-10 col-md-11 text-center">
                    Contracts
                </div>
                <div class="col-12 col-sm-2 col-md-1 text-center">
                    <button type="button" class="btn btn-outline-light btn-sm btn-block" data-toggle="modal" data-target="#createContract">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-borderless table-sm border-primary" id="dataTable" cellspacing="0">
                    <thead class="bg-primary text-white rounded">
                        <tr>
                            <th class="text-right">ID</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Seller</th>
                            <th>Address</th>
                            <th>Contract date</th>
                            <th>Payment date</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot class="bg-primary text-white rounded">
                        <tr>
                            <th class="text-right">ID</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Seller</th>
                            <th>Address</th>
                            <th>Contract date</th>
                            <th>Payment date</th>
                            <th>Comission</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @forelse ($contracts as $contract)
                        <tr class="text-primary">
                            <td class="bg-primary text-white text-right">{{ $contract->id_contract }}</td>
                            <td>{{ $contract->type == 1 ? 'Sale': 'Rent' }}</td>
                            <td class="text-left" style="min-width: 15vw;">US$ {{ number_format($contract->value, 2, ',', ' ') }}</td>
                            <td style="min-width: 12vw;">{{ $contract->user->name ?? 'No responsible' }}</td>
                            <td style="min-width: 20vw;">{{ $contract->address }}</td>
                            <td style="min-width: 20vw;">{{ $contract->contract_date }}</td>
                            <td style="min-width: 20vw;">{{ $contract->payment_date }}</td>
                            <td>{{ $contract->payment ? 'Paid' : 'Unpaid' }}</td>
                            <td style="min-width: 10vw">
                                <div class="row d-flex justify-content-center">
                                    @if(!$contract->payment)
                                    <form class="col-12 col-sm-12 col-md-6" method="POST" action="{{ route('dashboard.home') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <form class="col-12 col-sm-12 col-md-6" method="POST" action="{{ route('dashboard.home') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                                            <i class="fas fa-comments-dollar"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <h6 class="text-primary text-center">
                                    No contracts<br>
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

    <div class="modal fade" id="createContract" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.contract.add') }}" class="modal-content was-validated" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
    
                        <div class="form-group col-12 col-sm-12 col-md-12">
                            <label for="type">Type:</label>
                            <select class="form-control form-control-sm" id="type" name="type" required>
                                <option value="">Not defined</option>
                                <option value="1">Sale</option>
                                <option value="2">Rent</option>
                            </select>
                        </div>
    
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="contractDate">Contract date:</label>
                            <input type="date" class="form-control form-control-sm" id="contractDate" name="contractDate" required>
                        </div>
    
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="paymentDate">Payment date:</label>
                            <input type="date" class="form-control form-control-sm" id="paymentDate" name="paymentDate" required>
                        </div>
    
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="address">Address:</label>
                            <input type="text" minlength="5" maxlength="350" class="form-control form-control-sm" id="address" name="address" value="" required>
                        </div>
    
                        <div class="form-group col-sm-12 col-12 col-md-12">
                            <label for="description">Description:</label>
                            <textarea minlength="5" maxlength="2000" class="form-control form-control-sm" name="description" id="description"></textarea>
                        </div>
    
                        <div class="form-group col-sm-12 col-12 col-md-6">
                            <label for="value">Value:</label>
                            <input type="number" min="0" max="999999999999" step="0.01" class="form-control form-control-sm" id="value" name="value" required>
                        </div>
                        
                        <div class="form-group col-sm-12 col-12 col-md-6">
                            <label for="idUserSeller">Seller:</label>
                            <select class="form-control form-control-sm" id="idUserSeller" name="idUserSeller" required>
                                <option value="" selected>Seller not defined</option>
                                @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
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

@endsection

@section('layout')

@endsection

@section('script')

@endsection