<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;
    use DB;
    use Carbon\Carbon;
    
    use App\User;
    use App\Models\Payment;
    use App\Models\Contract;
    use App\Models\PaymentAdditional;
    use App\Models\TransactionType;

    class FinancialContract extends Controller
    {
        private $monthsPrev =   1;

        public function list(Request $request) {
            try {
                $contractList   =   Contract::orderBy('id_contract','asc')
                                    ->get();
                $listUser       =   [];

                foreach ($contractList as $key => $value) {
                    $contractList[$key]->allDesc                    =   (object)[];
                    $contractList[$key]->allDesc->start_contract    =   Carbon::parse($value->start_contract)->format('m/d/Y');
                    $contractList[$key]->allDesc->end_contract      =   Carbon::parse($value->end_contract)->format('m/d/Y');
                    $contractList[$key]->allDesc->payment_date      =   Carbon::parse($value->payment_date)->format('m/d/Y');
                    $contractList[$key]->allDesc->payment_exec      =   $value->payment_exec ? 'Treated' : 'UnTreated';
                    $contractList[$key]->allDesc->value             =   'US$ '.number_format($value->value, 2, '.', ',');
                    $contractList[$key]->allDesc->id_user_seller    =   User::find($value->id_user_seller);
                    $contractList[$key]->allDesc->type              =   TransactionType::find($value->id_transaction_type);
                    $contractList[$key]->allPayments                =   Payment::where('id_contract',$value->id_contract)
                                                                        ->orderBy('id_user','asc')
                                                                        ->get();

                    $contractList[$key]->total                      =   (object)[];
                    $contractList[$key]->total->split_value         =   0;
                    $contractList[$key]->total->split_value_desc    =   'US$ 0.00';
                    $contractList[$key]->total->additional          =   0;
                    $contractList[$key]->total->additional_desc     =   'US$ 0.00';
                    $contractList[$key]->total->total               =   0;
                    $contractList[$key]->total->total_desc          =   'US$ 0.00';

                    $contractList[$key]->realtor                    =   (object)[];
                    $contractList[$key]->realtor->split_value       =   0;
                    $contractList[$key]->realtor->split_value_desc  =   'US$ 0.00';
                    $contractList[$key]->realtor->additional        =   0;
                    $contractList[$key]->realtor->additional_desc   =   'US$ 0.00';
                    $contractList[$key]->realtor->total             =   0;
                    $contractList[$key]->realtor->total_desc        =   'US$ 0.00';

                    $contractList[$key]->broker                     =   (object)[];
                    $contractList[$key]->broker->split_value        =   0;
                    $contractList[$key]->broker->split_value_desc   =   'US$ 0.00';
                    $contractList[$key]->broker->additional         =   0;
                    $contractList[$key]->broker->additional_desc    =   'US$ 0.00';
                    $contractList[$key]->broker->total              =   0;
                    $contractList[$key]->broker->total_desc         =   'US$ 0.00';

                    foreach ($contractList[$key]->allPayments as $keyPay => $valuePay) {
                        $contractList[$key]->allPayments[$keyPay]->processing_date_desc =   Carbon::parse($valuePay->procesing_date)->format('m/d/Y');
                        $contractList[$key]->allPayments[$keyPay]->payment_date_desc    =   is_null($valuePay->payment_date) ? null : Carbon::parse($valuePay->payment_date)->format('m/d/Y');
                        $contractList[$key]->allPayments[$keyPay]->id_user_desc         =   User::find($valuePay->id_user);
                        $contractList[$key]->allPayments[$keyPay]->percentual_desc      =   number_format($valuePay->percentual,2,'.',',').'%';
                        $contractList[$key]->allPayments[$keyPay]->split_total_desc     =   'US$ '.number_format($valuePay->value_total,2,'.',',');
                        $contractList[$key]->allPayments[$keyPay]->split_value_desc     =   'US$ '.number_format($valuePay->value_split,2,'.',',');

                        if(!is_null($valuePay->id_user)) {
                            $tmpData    =   (object)[
                                'id'    =>  $contractList[$key]->allPayments[$keyPay]->id_user_desc->id,
                                'name'  =>  $contractList[$key]->allPayments[$keyPay]->id_user_desc->name
                            ];
                            
                            if(!in_array($tmpData, $listUser)){
                                array_push($listUser,$tmpData);
                            } // if(in_array($contractList[$key]->allPayments[$keyPay]->id_user_desc, $listUser)){ ... }
                        }

                        if(is_null($valuePay->id_user)) {
                            $contractList[$key]->broker->split_value    =   $contractList[$key]->broker->split_value + $valuePay->value_split;
                        }
                        else {
                            $contractList[$key]->realtor->split_value   =   $contractList[$key]->realtor->split_value + $valuePay->value_split;
                        }

                        $contractList[$key]->total->split_value         =   $contractList[$key]->total->split_value + $valuePay->value_split;
                        $contractList[$key]->total->total               =   $contractList[$key]->total->total + $valuePay->value_split;
                    } // foreach ($contractList[$key]->allPayments as $keyPay => $valuePay) { ... }

                    $contractList[$key]->allAdditionals             =   PaymentAdditional::where('id_contract',$value->id_contract)
                                                                        ->orderBy('id_user','asc')
                                                                        ->get();

                    foreach ($contractList[$key]->allAdditionals as $keyAdit => $valueAdit) {
                        $contractList[$key]->allAdditionals[$keyAdit]->processing_date_desc  =   Carbon::parse($valueAdit->procesing_date)->format('m/d/Y');
                        $contractList[$key]->allAdditionals[$keyAdit]->payment_date_desc     =   is_null($valueAdit->payment_date) ? null : Carbon::parse($valueAdit->payment_date)->format('m/d/Y');
                        $contractList[$key]->allAdditionals[$keyAdit]->id_user_desc          =   User::find($valueAdit->id_user);
                        $contractList[$key]->allAdditionals[$keyAdit]->percentual_desc       =   number_format($valueAdit->percentual,2,'.',',').'%';
                        $contractList[$key]->allAdditionals[$keyAdit]->value_desc            =   'US$ '.number_format($valueAdit->value,2,'.',',');

                        if(is_null($valuePay->id_user)) {
                            $contractList[$key]->broker->additional     =   $contractList[$key]->broker->additional + $valueAdit->value;
                        }
                        else {
                            $contractList[$key]->realtor->additional    =   $contractList[$key]->realtor->additional + $valueAdit->value;
                        }

                        $contractList[$key]->total->additional          =   $contractList[$key]->total->additional + $valueAdit->value;
                        $contractList[$key]->total->total               =   $contractList[$key]->total->total + $valueAdit->value;
                    } // foreach ($contractList[$key]->allPayments as $keyPay => $valuePay) { ... }

                    $contractList[$key]->total->split_value_desc    =   'US$ '.number_format($contractList[$key]->total->split_value,2,'.',',');
                    $contractList[$key]->total->additional_desc     =   'US$ '.number_format($contractList[$key]->total->additional,2,'.',',');
                    $contractList[$key]->total->total               =   $contractList[$key]->total->split_value + $contractList[$key]->total->additional;
                    $contractList[$key]->total->total_desc          =   'US$ '.number_format($contractList[$key]->total->total,2,'.',',');

                    $contractList[$key]->realtor->split_value_desc  =   'US$ '.number_format($contractList[$key]->realtor->split_value,2,'.',',');
                    $contractList[$key]->realtor->additional_desc   =   'US$ '.number_format($contractList[$key]->realtor->additional,2,'.',',');
                    $contractList[$key]->realtor->total             =   $contractList[$key]->realtor->split_value + $contractList[$key]->realtor->additional;
                    $contractList[$key]->realtor->total_desc        =   'US$ '.number_format($contractList[$key]->realtor->total,2,'.',',');

                    $contractList[$key]->broker->split_value_desc   =   'US$ '.number_format($contractList[$key]->broker->split_value,2,'.',',');
                    $contractList[$key]->broker->additional_desc    =   'US$ '.number_format($contractList[$key]->broker->additional,2,'.',',');
                    $contractList[$key]->broker->total              =   $contractList[$key]->broker->split_value + $contractList[$key]->broker->additional;
                    $contractList[$key]->broker->total_desc         =   'US$ '.number_format($contractList[$key]->broker->total,2,'.',',');

                } // foreach ($contractList as $key => $value) { ... }



                return view('pages.admin.financial.contract',[
                    'payments'  =>  $contractList,
                    'users'     =>  $listUser,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }


        public function additional(Request $request) {
            try {
                if(is_null($request->idContract) || is_null($request->idUser)) return redirect()->route('admin.financial.perContract');
                PaymentAdditional::create([
                    'processing_date'   =>  Carbon::now(),
                    'id_contract'       =>  intval($request->idContract),
                    'id_user'           =>  intval($request->idUser),
                    'id_user_payment'   =>  Auth::user()->id,
                    'value'             =>  floatval($request->value),
                ]);

                return redirect()->route('admin.financial.perContract');
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('admin.financial.perContract');
            } // catch(Exception $error) { ... }
        } // public function additional(Request $request) { ... }

        public function remove(Request $request)  {
            try {
                PaymentAdditional::where('id_payment_additional',$request->idPaymentAdditional)->delete();

                return redirect()->route('admin.financial.perContract');
            }
            catch(Exception $error) {
                return redirect()->route('admin.financial.perContract');
            }
        }

        public function confirm(Request $request) {
            try {
                if(is_null($request->idContract)) return redirect()->route('admin.financial.perContract');

                Payment::where('id_contract',$request->idContract)
                ->update([
                    'payment_date'  =>  Carbon::now(),
                ]);

                PaymentAdditional::where('id_contract',$request->idContract)
                ->update([
                    'payment_date'  =>  Carbon::now(),
                ]);

                Contract::where('id_contract',$request->idContract)
                ->update([
                    'payment_date'  =>  Carbon::now(),
                    'payment_exec'  =>  true,
                ]);

                return redirect()->route('admin.financial.perContract');
            } // try { ... }
            catch(Exception $error) {
                dd($error);
                return redirect()->route('admin.financial.perContract');
            } // catch(Exception $error) { ... }
        } // public function additional(Request $request) { ... }
    }