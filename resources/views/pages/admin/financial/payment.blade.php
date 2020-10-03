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
                            <span class="text-left" data-toggle="collapse" data-target="#collapsePayment-{{ $item->id }}" aria-expanded="true" aria-controls="collapsePayment-{{ $item->id }}">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <span class="text-decoration-none text-primary">{{ $item->name.' '.$item->second_name.' '.$item->last_name }}</span><br/>
                                        <span><small>Between {{ $item->allDesc->min_date }} and {{ $item->allDesc->max_date }}</small></span>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 text-right text-decoration-none">
                                        <span class="text-primary">{{ $item->allDesc->value }}</span><br/>
                                        <span><small>{{ $item->count_payment }} payments</small></span>
                                    </div>
                                    <div class="col-12 text-center text-primary">
                                        <small>Click to detail</small>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div id="collapsePayment-{{ $item->id }}" class="collapse" aria-labelledby="payment-{{ $item->id }}" data-parent="#listPayments">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-right"><small>#ID</small></td>
                                            <td><small>Contract</small></td>
                                            <td><small>User</small></td>
                                            <td class="text-right"><small>US$ contract value</small></td>
                                            <td class="text-right"><small>US$ comission value</small></td>
                                            <td class="text-right"><small>US$ manual value</small></td>
                                            <td class="text-right"><small>Percentual</small></td>
                                            <td class="text-center"><small>Payment date</small></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($item->allDesc->comission as $itemComission)
                                            <tr class="text-primary">
                                                <td class="text-right"><small><a href="{{ route('contract.id',['id_contract' => $itemComission->id_contract]) }}">{{ $itemComission->id_payment }}</a></small></td>
                                                <td><small><a href="{{ route('contract.id',['id_contract' => $itemComission->id_contract]) }}">Contract #{{ $itemComission->id_contract }}</a></small></td>
                                                <td><small>{{ $itemComission->allDesc->id_user->name ?? 'Legacy Plus Realty' }}</small></td>
                                                <td class="text-right"><small>{{ $itemComission->allDesc->value }}</small></td>
                                                <td class="font-weight-bold text-right"><small>{{ $itemComission->allDesc->comission }}</small></td>
                                                <td style="min-width: 30vw;" class="font-weight-bold text-right"><small>
                                                    <form method="POST" action="{{ route('admin.financial.additional') }}" class="was-validated">
                                                        @csrf
                                                        <input type="hidden" name="id_payment" value="{{ $itemComission->id_payment }}">

                                                        <div class="input-group mb-2">
                                                        <input type="number" step="0.01" min="-{{$itemComission->value}}" max="{{$itemComission->value}}" class="form-control form-control-sm text-right value-legacy" name="additional" placeholder="additional value US$" value="{{ is_null($itemComission->additional) ? '0.00' : $itemComission->allDesc->additional }}">
                                                            <div class="input-group-prepend">
                                                                <button type="submit" class="btn btn-sm btn-block btn-primary">Apply</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </small></td>
                                                <td class="text-right"><small>{{ $itemComission->allDesc->percent }}</small></td>
                                                <td><small>{{ $itemComission->allDesc->payment_date }}</small></td>
                                            </tr>
                                        @empty
                                            <tr class="text-primary">
                                                <td colspan="7">
                                                    No payments
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-primary text-right"><small>Total:</small></th>
                                            <th class="font-weight-bold text-right"><small>US$ {{ number_format($item->comission,2,'.',',') }}</small></th>
                                            <th colspan="2" class="text-primary"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>    
                @empty
                    
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