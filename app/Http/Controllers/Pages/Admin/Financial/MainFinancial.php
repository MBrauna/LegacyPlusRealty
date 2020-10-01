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
                $payment    =   User::join('payment','payment.id_user','users.id')
                                ->where('payment.payment_date','>=',Carbon::now()->subMonths($this->monthsPrev))
                                ->orderBy('users.name','desc')
                                ->select(
                                    'users.id',
                                    'users.name',
                                    'users.percent',
                                    DB::raw('count(1) as count_payment'),
                                    DB::raw('sum(payment.comission) as comission'),
                                    DB::raw('max(payment.payment_date) as min_date'),
                                    DB::raw('min(payment.payment_date) as max_date'),
                                )
                                ->groupBy('users.id')
                                ->groupBy('users.name')
                                ->groupBy('users.percent')
                                ->get();

                foreach($payment as $key => $value) {
                    $payment[$key]->allDesc             =   (object)[];
                    $payment[$key]->allDesc->percent    =   number_format($value->percent,2,'.',',').'%';
                    $payment[$key]->allDesc->value      =   'US$ '.number_format($value->comission,2,'.',',');
                    $payment[$key]->allDesc->min_date   =   Carbon::parse($value->min_date)->format('m/d/Y');
                    $payment[$key]->allDesc->max_date   =   Carbon::parse($value->max_date)->format('m/d/Y');
                    $payment[$key]->allDesc->comission  =   Payment::where('payment_date','>=',Carbon::now()->subMonths($this->monthsPrev))
                                                            ->where('id_user',$value->id)
                                                            ->orderBy('payment_date','asc')
                                                            ->orderBy('id_contract','asc')
                                                            ->get();
                    
                    foreach ($payment[$key]->allDesc->comission as $keyData => $valueData) {
                        $payment[$key]->allDesc->comission[$keyData]->allDesc               =   (object)[];
                        $payment[$key]->allDesc->comission[$keyData]->allDesc->id_user      =   User::find($valueData->id_user);
                        $payment[$key]->allDesc->comission[$keyData]->allDesc->value        =   'US$ '.number_format($valueData->value,2,'.',',');
                        $payment[$key]->allDesc->comission[$keyData]->allDesc->comission    =   'US$ '.number_format($valueData->comission,2,'.',',');
                        $payment[$key]->allDesc->comission[$keyData]->allDesc->percent      =   number_format($valueData->percent,2,'.',',').' %';
                        $payment[$key]->allDesc->comission[$keyData]->allDesc->payment_date =   Carbon::parse($valueData->payment_date)->format('m/d/Y');
                    } // foreach ($payment[$key]->allDesc->comission as $keyData => $valueData) { ... }
                } // foreach($payment as $key => $value) { ... }

                return view('pages.admin.financial.payment',[
                    'payments'  =>  $payment,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }
    }
