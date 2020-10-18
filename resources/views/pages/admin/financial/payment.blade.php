@extends('layouts.legacy')

@section('pageName','Payment')

@section('body')

    <div class="card border-primary">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <div style="min-width: 10vw;"></div>
            <span>Financial - Payment</span>
            <div style="min-width: 10vw;"></div>
        </div>
        <div class="card-body">
            <div class="accordion" id="listPayments">
                @forelse ($payments as $item)
                    <div class="card">
                        <div class="card-header" id="payment-{{ $item->id }}">
                            <div class="mb-0">
                                <span class="text-left" data-toggle="collapse" data-target="#collapsePayment-{{ $item->id_contract }}" aria-expanded="true" aria-controls="collapsePayment-{{ $item->id_contract }}">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <span class="text-decoration-none text-primary"><a href="{{ route('contract.id',['id_contract' => $item->id_contract]) }}">{{ $item->description }}</a></span><br/>
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
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="contractPrice">Contract purchase price</label>
                                            <input type="text" class="form-control form-control-sm form-control-plaintext text-primary" id="exampleFormControlInput1" value="{{ $item->allDesc->value }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <h6 class="text-center text-primary font-weight-bold">Transaction Comission</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover table-striped">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th style="min-width: 30vw;">Item description</th>
                                                        <th>% on $ amount</th>
                                                        <th>Apply % on</th>
                                                        <th>To receive (+) or contribute(-)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><small>{{ $item->transactions->realState->title }}</small></td>
                                                        <td class="text-right"><small>{{ $item->transactions->realState->allDesc->amount }}</small></td>
                                                        <td class="text-right"><small>{{ $item->transactions->realState->allDesc->apply }}</small></td>
                                                        <td class="text-right"><small>{{ $item->transactions->realState->allDesc->received }}</small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><small>{{ $item->transactions->officeFee->title }}</small></td>
                                                        <td class="text-right"><small>{{ $item->transactions->officeFee->allDesc->amount }}</small></td>
                                                        <td class="text-right"><small>{{ $item->transactions->officeFee->allDesc->apply }}</small></td>
                                                        <td class="text-right"><small>{{ $item->transactions->officeFee->allDesc->received }}</small></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="bg-primary text-white">
                                                    <tr>
                                                        <td class="text-right" colspan="3">Net comission to collect for this transaction</td>
                                                        <td class="text-right">{{ $item->transactions->total->allDesc->received }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <h6 class="text-center text-primary font-weight-bold">Distribution to brokerage/agent(s)</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table">
                                                <thead class="bg-primary text-center text-white">
                                                    <tr>
                                                        <th></th>
                                                        <th>Apply % on</th>
                                                        <th>% of $ amount</th>
                                                        <th>Split $</th>
                                                        <th>Additional $</th>
                                                        <th>Total $</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($item->allPayments as $itemPayment)
                                                        <tr>
                                                            <td style="min-width: 20vw"><small>{{ isset($itemPayment->allDesc->id_user->name) ? $itemPayment->allDesc->id_user->name.' '.$itemPayment->allDesc->id_user->second_name.' '.$itemPayment->allDesc->id_user->last_name : 'Legacy Plus Realty' }}</small></td>
                                                            <td class="text-right"><small>{{ $itemPayment->allDesc->value }}</small></td>
                                                            <td class="text-right"><small>{{ $itemPayment->allDesc->percent }}</small></td>
                                                            <td class="text-right"><small>{{ $itemPayment->allDesc->comission }}</small></td>
                                                            @if($itemPayment->confirm_payment)
                                                                <td class="text-right"><small>{{ $itemPayment->allDesc->additional }}</small></td>
                                                            @else
                                                                <td style="min-width: 15vw;" class="font-weight-bold text-right"><small>
                                                                    <form method="POST" action="{{ route('admin.financial.additional') }}" class="was-validated">
                                                                        @csrf
                                                                        <input type="hidden" name="id_payment" value="{{ $itemPayment->id_payment }}">
                                    
                                                                        <div class="input-group mb-2">
                                                                        <input type="number" step="0.01" min="-{{$itemPayment->value}}" max="{{$itemPayment->value}}" class="form-control form-control-sm text-right value-legacy" name="additional" placeholder="additional value US$" value="{{ is_null($itemPayment->allDesc->additionalVal) ? '0.00' : $itemPayment->allDesc->additionalVal }}">
                                                                            <div class="input-group-prepend">
                                                                                <button type="submit" class="btn btn-sm btn-block btn-primary">Apply</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </small></td>
                                                            @endif
                                                            <td class="text-right"><small>{{ $itemPayment->allDesc->total }}</small></td>
                                                            @if($itemPayment->confirm_payment)
                                                                <td><button type="button" class="btn btn-sm btn-block btn-success" disabled>Paid out</button></td>
                                                            @else
                                                                <td style="min-width: 10vw;">
                                                                    <form method="POST" action="{{ route('admin.financial.confirm') }}">
                                                                        @csrf
                                                                        <input type="hidden" name="id_payment" value="{{ $itemPayment->id_payment }}">
                                                                        <button type="submit" class="btn btn-sm btn-block btn-primary">Confirm payment</button>
                                                                    </form>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="bg-primary text-center text-white">
                                                    <tr>
                                                        <th colspan="3">Total:</th>
                                                        <th>{{ $item->allDesc->split_value }}</th>
                                                        <th>{{ $item->allDesc->additional }}</th>
                                                        <th>{{ $item->allDesc->total }}</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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