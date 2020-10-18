<?php

    namespace App\Http\Controllers\Pages\Admin\Financial;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use DB;
    use Carbon\Carbon;
    
    use App\User;
    use App\Models\Payment;
    use App\Models\Contract;

    class MainFinancial extends Controller
    {
        private $monthsPrev =   1;

        public function list(Request $request) {
            try {
                $contractList   =   Contract::where('payment_date','>=',Carbon::now()->subMonths(1))
                                    ->orderBy('payment_date','asc')
                                    ->get();


                foreach ($contractList as $key => $value) {
                    $contractList[$key]->allDesc                    =   (object)[];
                    $contractList[$key]->allDesc->start_contract    =   Carbon::parse($value->start_contract)->format('m/d/Y');
                    $contractList[$key]->allDesc->end_contract      =   Carbon::parse($value->end_contract)->format('m/d/Y');
                    $contractList[$key]->allDesc->payment_date      =   Carbon::parse($value->payment_date)->format('m/d/Y');
                    $contractList[$key]->allDesc->payment_exec      =   $value->payment_exec ? 'Treated' : 'UnTreated';
                    $contractList[$key]->allDesc->value             =   'US$ '.number_format($value->value, 2, '.', ',');
                    $contractList[$key]->allDesc->id_user_seller    =   User::find($value->id_user_seller);
                    $contractList[$key]->allDesc->split_value       =   'US$ 0.00';
                    $contractList[$key]->allDesc->additional        =   'US$ 0.00';
                    $contractList[$key]->allDesc->total             =   'US$ 0.00';

                    $contractList[$key]->total                      =   0;
                    $contractList[$key]->split_value                =   0;
                    $contractList[$key]->additional                 =   0;

                    $contractList[$key]->allPayments                =   Payment::where('id_contract',$value->id_contract)
                                                                        ->orderBy('id_user','asc')
                                                                        ->get();

                    $contractList[$key]->transactions               =   (object)[];
                    $contractList[$key]->transactions->realState    =   (object)[];
                    $contractList[$key]->transactions->officeFee    =   (object)[];
                    $contractList[$key]->transactions->total        =   (object)[];


                    $contractList[$key]->transactions->realState->allDesc   =   (object)[];
                    $contractList[$key]->transactions->officeFee->allDesc   =   (object)[];
                    $contractList[$key]->transactions->total->allDesc       =   (object)[];

                    $contractList[$key]->transactions->realState->title     =   'Real Estate Comission';
                    $contractList[$key]->transactions->officeFee->title     =   'Office Processing Fee';

                    $contractList[$key]->transactions->realState->amount    =   0;
                    $contractList[$key]->transactions->officeFee->amount    =   0;
                    $contractList[$key]->transactions->total->amount        =   0;

                    $contractList[$key]->transactions->realState->apply     =   0;
                    $contractList[$key]->transactions->officeFee->apply     =   0;
                    $contractList[$key]->transactions->total->apply         =   0;

                    $contractList[$key]->transactions->realState->received  =   0;
                    $contractList[$key]->transactions->officeFee->received  =   0;
                    $contractList[$key]->transactions->total->received      =   0;


                    foreach ($contractList[$key]->allPayments as $keyData => $valueData) {
                        if(is_null($valueData->id_user)) {
                            $contractList[$key]->transactions->officeFee->apply     =   $contractList[$key]->transactions->officeFee->apply + $valueData->value;
                            $contractList[$key]->transactions->officeFee->received  =   $contractList[$key]->transactions->officeFee->received + $valueData->comission + $valueData->additional;
                        } // if(is_null($valueData->id_user)) { ... }
                        else {
                            $contractList[$key]->transactions->realState->apply     =   $contractList[$key]->transactions->realState->apply + $valueData->value;
                            $contractList[$key]->transactions->realState->received  =   $contractList[$key]->transactions->realState->received + $valueData->comission + $valueData->additional;
                        } // else { ... }

                        $contractList[$key]->transactions->total->apply             =   $contractList[$key]->transactions->total->apply + $valueData->value;
                        $contractList[$key]->transactions->total->received          =   $contractList[$key]->transactions->total->received + $valueData->comission + $valueData->additional;
                    } // foreach ($contractList[$key]->allPayments as $keyData => $valueData) { ... }

                    $contractList[$key]->transactions->officeFee->amount            =   0;//round((($contractList[$key]->transactions->officeFee->received*100)/$contractList[$key]->transactions->officeFee->apply),2);
                    $contractList[$key]->transactions->realState->amount            =   0;//round((($contractList[$key]->transactions->realState->received*100)/$contractList[$key]->transactions->realState->apply),2);


                    $contractList[$key]->transactions->realState->allDesc->amount   =   number_format($contractList[$key]->transactions->realState->amount,2,'.',',').' %';
                    $contractList[$key]->transactions->officeFee->allDesc->amount   =   number_format($contractList[$key]->transactions->officeFee->amount,2,'.',',').' %';

                    $contractList[$key]->transactions->realState->allDesc->apply    =   'US$ '.number_format($contractList[$key]->transactions->realState->apply,2,'.',',');
                    $contractList[$key]->transactions->officeFee->allDesc->apply    =   'US$ '.number_format($contractList[$key]->transactions->officeFee->apply,2,'.',',');

                    $contractList[$key]->transactions->realState->allDesc->received =   'US$ '.number_format($contractList[$key]->transactions->realState->received,2,'.',',');
                    $contractList[$key]->transactions->officeFee->allDesc->received =   'US$ '.number_format($contractList[$key]->transactions->officeFee->received,2,'.',',');

                    
                    $contractList[$key]->transactions->total->allDesc->amount       =   $contractList[$key]->transactions->total->amount;
                    $contractList[$key]->transactions->total->allDesc->apply        =   'US$ '.number_format($contractList[$key]->transactions->total->apply,2,'.',',');
                    $contractList[$key]->transactions->total->allDesc->received     =   'US$ '.number_format($contractList[$key]->transactions->total->received,2,'.',',');



                    foreach ($contractList[$key]->allPayments as $keyData => $valueData) {
                        $contractList[$key]->allPayments[$keyData]->allDesc                 =   (object)[];
                        $contractList[$key]->allPayments[$keyData]->allDesc->id_user        =   User::find($valueData->id_user);
                        $contractList[$key]->allPayments[$keyData]->allDesc->value          =   'US$ '.number_format($valueData->value,2,'.',',');
                        $contractList[$key]->allPayments[$keyData]->allDesc->comission      =   'US$ '.number_format($valueData->comission,2,'.',',');
                        $contractList[$key]->allPayments[$keyData]->allDesc->percent        =   number_format($valueData->percent,2,'.',',').' %';
                        $contractList[$key]->allPayments[$keyData]->allDesc->additional     =   'US$ '.number_format($valueData->additional,2,'.','');
                        $contractList[$key]->allPayments[$keyData]->allDesc->additionalVal  =   number_format($valueData->additional,2,'.','');
                        $contractList[$key]->allPayments[$keyData]->allDesc->payment_date   =   Carbon::parse($valueData->payment_date)->format('m/d/Y');
                        $contractList[$key]->allPayments[$keyData]->allDesc->total          =   'US$ '.number_format(round(($valueData->value + $valueData->additional),2),2,'.',',');

                        $contractList[$key]->split_value                                    =   $contractList[$key]->split_value + $valueData->comission;
                        $contractList[$key]->additional                                     =   $contractList[$key]->additional + $valueData->additional;
                        $contractList[$key]->total                                          =   $contractList[$key]->total + round(($valueData->comission + $valueData->additional),2);
                        $contractList[$key]->allDesc->split_value                           =   'US$ '.number_format($contractList[$key]->split_value,2,'.',',');
                        $contractList[$key]->allDesc->additional                            =   'US$ '.number_format($contractList[$key]->additional,2,'.',',');
                        $contractList[$key]->allDesc->total                                 =   'US$ '.number_format($contractList[$key]->total,2,'.',',');
                    } // foreach ($payment[$key]->allDesc->comission as $keyData => $valueData) { ... }

                    $contractList[$key]->allDesc->avaiable          =   'US$ '.number_format(round($contractList[$key]->value - $contractList[$key]->total,2),2,'.',',');
                } // foreach ($contractList as $key => $value) { ... }

                return view('pages.admin.financial.payment',[
                    'payments'  =>  $contractList,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }


        public function additional(Request $request) {
            try {
                if(!isset($request->id_payment) || is_null($request->id_payment)) return redirect()->route('admin.financial.list');
                $payment    =   Payment::find($request->id_payment);

                Payment::where('id_payment',$request->id_payment)
                ->update([
                    'additional'    =>  doubleval($request->additional),
                ]);

                return redirect()->route('admin.financial.list');
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('admin.financial.list');
            } // catch(Exception $error) { ... }
        } // public function additional(Request $request) { ... }


        public function confirm(Request $request) {
            try {
                if(!isset($request->id_payment) || is_null($request->id_payment)) return redirect()->route('admin.financial.list');
                $payment    =   Payment::find($request->id_payment);

                Payment::where('id_payment',$request->id_payment)
                ->update([
                    'confirm_payment'    =>  true,
                ]);

                return redirect()->route('admin.financial.list');
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('admin.financial.list');
            } // catch(Exception $error) { ... }
        } // public function additional(Request $request) { ... }
    }
