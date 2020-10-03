<?php

    namespace App\Http\Controllers\Pages\Dashboard;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;
    use DB;

    use Carbon\Carbon;
    use App\Models\Payment;

    class MainDashboard extends Controller {
        public function index(Request $request) {
            $dataContract   =   Payment::where('payment_date','>=',Carbon::now()->subMonths(12))
                                ->where('payment_date','<=',Carbon::now())
                                ->where('id_user',Auth::user()->id)
                                ->groupByRaw("date_trunc('month', payment.payment_date)")
                                ->select(
                                    DB::raw('count(payment.id_payment) as count_comission'),
                                    DB::raw('(sum(payment.comission) + sum(payment.additional)) as sum_comission'),
                                    DB::raw("date_trunc('month', payment.payment_date) as month_date"),
                                )
                                ->get();
            
            foreach ($dataContract as $key => $value) {
                $dataContract[$key]->desc_date  =   Carbon::parse($value->month_date)->format('m/Y');
                $dataContract[$key]->value      =   'US$ '.number_format($value->sum_comission,2,'.',',');
            } // foreach ($dataContract as $key => $value) { ... }

            $sumMonth       =   Payment::where('payment_date','>=',Carbon::now()->subMonths(1))->where('id_user',Auth::user()->id)->where('payment_date','<=',Carbon::now())->selectRaw('(sum(payment.comission) + sum(payment.additional)) as comission')->first();
            $sumYear        =   Payment::where('payment_date','>=',Carbon::now()->subMonths(1))->where('id_user',Auth::user()->id)->where('payment_date','<=',Carbon::now())->selectRaw('(sum(payment.comission) + sum(payment.additional)) as comission')->first();
            $sumMonth       =   'US$ '.number_format($sumMonth->comission,2,'.',',');
            $sumYear        =   'US$ '.number_format($sumYear->comission,2,'.',',');

            $monthMin       =   Carbon::now()->subMonths(1)->format('m/d/Y');
            $monthMax       =   Carbon::now()->format('m/d/Y');

            $yearMin        =   Carbon::now()->subMonths(12)->format('m/d/Y');
            $yearMax        =   Carbon::now()->format('m/d/Y');

            return view('pages.dashboard.dashboard',[
                'contracts' =>  $dataContract,
                'monthSum'  =>  $sumMonth,
                'yearSum'   =>  $sumYear,
                // -------------------- //
                'monthMin'  =>  $monthMin,
                'monthMax'  =>  $monthMax,
                'yearMin'   =>  $yearMin,
                'yearMax'   =>  $yearMax,
            ]);
        } // public function index(Request $request) { ... }
    } // class MainDashboard extends Controller { ... }