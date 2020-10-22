@extends('layouts.legacy')

@section('pageName','Payment per contract')

@section('body')

    <div class="card border-primary">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <div style="min-width: 10vw;"></div>
            <span>Financial - Payment per contract</span>
            <div style="min-width: 10vw;"></div>
        </div>
        <div class="card-body">
            <div class="accordion" id="listPayments">
                @forelse ($payments as $item)
                    <div class="card {{ ($item->payment_exec) ? 'border-left-success' : 'border-left-primary'}}">
                        <div class="card-header" id="payment-{{ $item->id }}">
                            <div class="mb-0">
                                <span class="text-left" data-toggle="collapse" data-target="#collapsePayment-{{ $item->id_contract }}" aria-expanded="true" aria-controls="collapsePayment-{{ $item->id_contract }}">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <span class="text-decoration-none text-primary">
                                                <a href="{{ route('admin.contract.id',['id_contract' => $item->id_contract]) }}">{{ $item->description }}</a>
                                                @if($item->payment_exec)
                                                    <span class="font-weight-bold text-success">(Already paid)</span>
                                                @endif
                                            </span><br/>
                                            <span><small>Between {{ $item->allDesc->start_contract }} and {{ $item->allDesc->end_contract }}</small></span>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 text-right text-decoration-none">
                                            <span class="text-primary">{{ $item->allDesc->value }}</span><br/>
                                            <span><small>Contract value</small></span>
                                        </div>
                                        <div class="col-12 text-center text-primary">
                                            <small>Click to detail</small>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div id="collapsePayment-{{ $item->id_contract }}" class="collapse" aria-labelledby="payment-{{ $item->id_contract }}" data-parent="#listPayments">
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white d-flex justify-content-between">
                                                <div style="min-width: 10vw;">
                                                </div>
                                                <span>Distribution to brokerage/agent(s)</span>
                                                <div style="min-width: 10vw;">
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover table-striped">
                                                        <thead class="bg-secondary text-white text-right">
                                                            <tr>
                                                                <th class="text-left" style="min-width: 30vw;">Item description</th>
                                                                <th>Comission</th>
                                                                <th>Additional</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><small>Real Estate Comission</small></td>
                                                                <td class="text-right"><small>{{ $item->realtor->split_value_desc }}</small></td>
                                                                <td class="text-right"><small>{{ $item->realtor->additional_desc }}</small></td>
                                                                <td class="text-right"><small>{{ $item->realtor->total_desc }}</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><small>Office Processing Fee</small></td>
                                                                <td class="text-right"><small>{{ $item->broker->split_value_desc }}</small></td>
                                                                <td class="text-right"><small>{{ $item->broker->additional_desc }}</small></td>
                                                                <td class="text-right"><small>{{ $item->broker->total_desc }}</small></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot class="bg-secondary text-white text-right">
                                                            <tr>
                                                                <th>Total:</th>
                                                                <th>{{ $item->total->split_value_desc }}</th>
                                                                <th>{{ $item->total->additional_desc }}</th>
                                                                <th>{{ $item->total->total_desc }}</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 pt-3">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white d-flex justify-content-between">
                                                <div style="min-width: 10vw;">
                                                </div>
                                                <span>Distribution to brokerage/agent(s)</span>
                                                <div style="min-width: 10vw;">
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover table-striped">
                                                        <thead class="bg-secondary text-center text-white">
                                                            <tr>
                                                                <th></th>
                                                                <th>Processing date</th>
                                                                <th>Payment date</th>
                                                                <th>Apply % on</th>
                                                                <th>% of $ amount</th>
                                                                <th>Split $</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($item->allPayments as $itemPayment)
                                                            <tr>
                                                                <td style="min-width: 20vw"><small>{{ isset($itemPayment->id_user_desc->name) ? $itemPayment->id_user_desc->name : 'Legacy Plus Realty' }}</small></td>
                                                                <td class="text-center"><small>{{ $itemPayment->processing_date_desc }}</small></td>
                                                                <td class="text-center"><small>{{ $itemPayment->payment_date_desc }}</small></td>
                                                                <td class="text-right"><small>{{ $itemPayment->split_total_desc }}</small></td>
                                                                <td class="text-right"><small>{{ $itemPayment->percentual_desc }}</small></td>
                                                                <td class="text-right"><small>{{ $itemPayment->split_value_desc }}</small></td>
                                                            </tr>
                                                            @empty
                                                                <tr class="text-primary font-weight-bold">
                                                                    <td colspan="8" class="text-center">No payments</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 pt-3">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white d-flex justify-content-between">
                                                <div style="min-width: 10vw;">
                                                </div>
                                                <span>Additional(manual) comission to brokerage/agent(s)</span>
                                                <div style="min-width: 10vw;">
                                                    @if(!$item->payment_exec)
                                                        <button type="button" class="btn btn-sm btn-block btn-outline-light" data-toggle="modal" data-target="#paymentAdd_id_{{ $item->id_payment }}">
                                                            <i class="fas fa-plus-square"></i>
                                                        </button>
                                                        <form method="POST" action="{{ route('admin.financial.additionalPayment') }}" class="modal fade was-validated" id="paymentAdd_id_{{ $item->id_payment }}" tabindex="-1" role="dialog" aria-labelledby="paymentAdd_id_{{ $item->id_payment }}Label" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary">
                                                                        <h5 class="modal-title" id="paymentAdd_id_{{ $item->id_payment }}Label">Additional payment</h5>
                                                                        <button type="button" class="close bg-primary text-white" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <input type="hidden" name="idContract" value="{{ $item->id_contract }}">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="idUser" class="text-primary">User</label>
                                                                                    <select id="idUser" name="idUser" class="form-control form-control-sm" required>
                                                                                        <option value="" selected>None</option>
                                                                                        @foreach ($users as $key => $dataUser)
                                                                                            <option value="{{ $dataUser->id }}">{{ $dataUser->name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="value" class="text-primary">Additional value</label>
                                                                                    <input type="number" step="0.01" min="-{{ $item->realtor->split_value}}" max="{{$item->realtor->split_value}}" class="form-control form-control-sm value-legacy" id="value" name="value" placeholder="Additional value" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover table-striped">
                                                        <thead class="bg-secondary text-center text-white">
                                                            <tr>
                                                                <th>To</th>
                                                                <th>Processing date</th>
                                                                <th>Payment date</th>
                                                                <th>Value</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($item->allAdditionals as $itemPayment)
                                                            <tr>
                                                                <td><small>{{ isset($itemPayment->id_user_desc->name) ? $itemPayment->id_user_desc->name : 'Legacy Plus Realty' }}</small></td>
                                                                <td class="text-center"><small>{{ $itemPayment->processing_date_desc }}</small></td>
                                                                <td class="text-center"><small>{{ $itemPayment->payment_date_desc }}</small></td>
                                                                <td class="text-right"><small>{{ $itemPayment->value_desc }}</small></td>
                                                                
                                                                @if($item->payment_exec)
                                                                    <td>
                                                                        <button type="button" class="btn btn-sm btn-block btn-success" disabled>
                                                                            <i class="fas fa-money-bill-alt"></i>
                                                                            Already paid
                                                                        </button>
                                                                    </td>
                                                                @else
                                                                    <td style="min-width: 4vw;">
                                                                        <form method="POST" action="{{ route('admin.financial.removeAdditional') }}">
                                                                            @csrf
                                                                            <input type="hidden" name="idPaymentAdditional" value="{{ $itemPayment->id_payment_additional }}">
                                                                            <button type="submit" class="btn btn-sm btn-block btn-primary">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            @empty
                                                                <tr class="text-primary font-weight-bold">
                                                                    <td colspan="6" class="text-center">No payments</td>
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
                            <div class="card-footer">
                                @if($item->payment_exec)
                                    <button type="button" class="btn btn-info btn-block btn-sm font-weight-bold" disabled>Contract #{{ $item->id_contract }} already paid</button>
                                @else
                                    <form action="{{ route('admin.financial.confirm') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="idContract" value="{{ $item->id_contract }}">
                                        <button type="submit" class="btn btn-success btn-block btn-sm font-weight-bold">Confirm payment for contract #{{ $item->id_contract }}</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-center text-primary">No contracts between {{ Carbon\Carbon::now()->subDays(30)->format('m/d/Y') }} and {{ Carbon\Carbon::now()->format('m/d/Y') }}</h6>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection


@section('layout')
    
@endsection

@section('script')
    <script src="/legacy/vendor/jquery-mask/dist/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            //$('.value-legacy').mask('##############0.00', {reverse: true});
            $(".value-legacy").mask("Z999999999990.00", {
                reverse: true,
                translation: {
                    'Z': {pattern: /[\-\+]/, optional: true}
                }

            });
        });
    </script>
@endsection