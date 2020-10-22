<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;


    use DB;
    use Carbon\Carbon;
    
    use App\User;
    use App\Models\Payment;
    use App\Models\Contract;
    use App\Models\PaymentAdditional;

    class FinancialContract extends Controller
    {
        private $monthsPrev =   1;

        public function list(Request $request) {
            try {
                $contractList   =   Contract::where('created_at','>=',Carbon::now()->subMonths(1))
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
                    $contractList[$key]->allPayments                =   Payment::where('id_contract',$value->id_contract)
                                                                        ->orderBy('id_user','asc')
                                                                        ->get();

                    $contractList[$key]->allAdditionals             =   PaymentAdditional::where('id_contract',$value->id_contract)
                                                                        ->orderBy('id_user','asc')
                                                                        ->get();
                } // foreach ($contractList as $key => $value) { ... }

                return view('pages.admin.financial.contract',[
                    'payments'  =>  $contractList,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }


        public function additional(Request $request) {
            try {
                if(!isset($request->id_payment) || is_null($request->id_payment)) return redirect()->route('admin.financial.perContract');
                $payment    =   Payment::find($request->id_payment);

                Payment::where('id_payment',$request->id_payment)
                ->update([
                    'additional'    =>  doubleval($request->additional),
                ]);

                return redirect()->route('admin.financial.perContract');
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('admin.financial.perContract');
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