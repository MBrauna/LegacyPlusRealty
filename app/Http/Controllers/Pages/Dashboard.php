<?php

    namespace App\Http\Controllers\Pages;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;
    use Carbon\Carbon;
    use DB;

    

    class Dashboard extends Controller {
        public function index(Request $request) {
            try {
                $percComission      =   DB::table('user_compensation')
                                        ->where('id_user', Auth::user()->id)
                                        ->orderBy('id_transaction_type','asc')
                                        ->orderBy('min_value','asc')
                                        ->orderBy('max_value','asc')
                                        ->get();

                foreach ($percComission as $key => $value) {
                    $percComission[$key]->allDesc   =   (object)[];

                    $percComission[$key]->allDesc->type =   ($value->id_transaction_type == 1) ? 'Salle' : 'Rent';
                    $percComission[$key]->allDesc->min  =   'US$ '.number_format($value->min_value,2,'.',',');
                    $percComission[$key]->allDesc->max  =   'US$ '.number_format($value->max_value,2,'.',',');
                    $percComission[$key]->allDesc->perc =   number_format($value->percentual).'%';
                }

                // -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- //

                $infoMonth          =   DB::table('payment')
                                        ->where('payment_date','>=',Carbon::now()->startOfYear())
                                        ->where('payment_date','<=',Carbon::now()->endOfYear())
                                        ->where('id_user',Auth::user()->id)
                                        ->groupByRaw("date_trunc('month', payment.payment_date)")
                                        ->select(
                                            DB::raw('sum(payment.value_split) as value_split'),
                                            DB::raw("date_trunc('month', payment.payment_date) as payment_date"),
                                        )
                                        ->get();

                $infoYear           =   DB::table('payment')
                                        ->where('payment_date','>=',Carbon::now()->startOfYear())
                                        ->where('payment_date','<=',Carbon::now()->endOfYear())
                                        ->where('id_user',Auth::user()->id)
                                        ->groupByRaw("date_trunc('year', payment.payment_date)")
                                        ->select(
                                            DB::raw('sum(payment.value_split) as value_split'),
                                            DB::raw("date_trunc('year', payment.payment_date) as payment_date"),
                                        )
                                        ->get();

                $additionalMonth    =   DB::table('payment_additional')
                                        ->where('payment_date','>=',Carbon::now()->startOfYear())
                                        ->where('payment_date','<=',Carbon::now()->endOfYear())
                                        ->where('id_user',Auth::user()->id)
                                        ->groupByRaw("date_trunc('month', payment_date)")
                                        ->select(
                                            DB::raw('sum(value) as value_split'),
                                            DB::raw("date_trunc('month', payment_date) as payment_date"),
                                        )
                                        ->get();

                $additionalYear     =   DB::table('payment_additional')
                                        ->where('payment_date','>=',Carbon::now()->startOfYear())
                                        ->where('payment_date','<=',Carbon::now()->endOfYear())
                                        ->where('id_user',Auth::user()->id)
                                        ->groupByRaw("date_trunc('year', payment_date)")
                                        ->select(
                                            DB::raw('sum(value) as value_split'),
                                            DB::raw("date_trunc('year', payment_date) as payment_date"),
                                        )
                                        ->get();


                // -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- //
                
                $infoMonthTotal     =   DB::table('payment')
                                        ->where('payment_date','>=',Carbon::now()->startOfMonth())
                                        ->where('payment_date','<=',Carbon::now()->endOfMonth())
                                        ->where('id_user',Auth::user()->id)
                                        ->sum('value_split');

                $infoYearTotal      =   DB::table('payment')
                                        ->where('payment_date','>=',Carbon::now()->startOfYear())
                                        ->where('payment_date','<=',Carbon::now()->endOfYear())
                                        ->where('id_user',Auth::user()->id)
                                        ->sum('value_split');

                $additionalMonthTot =   DB::table('payment_additional')
                                        ->where('payment_date','>=',Carbon::now()->startOfMonth())
                                        ->where('payment_date','<=',Carbon::now()->endOfMonth())
                                        ->where('id_user',Auth::user()->id)
                                        ->sum('value');

                $additionalYearTot  =   DB::table('payment_additional')
                                        ->where('payment_date','>=',Carbon::now()->startOfYear())
                                        ->where('payment_date','<=',Carbon::now()->endOfYear())
                                        ->where('id_user',Auth::user()->id)
                                        ->sum('value');
                
                return view('pages.dashboard',[
                    'totalComissionMonth'   =>  'US$ '.number_format($infoMonthTotal,2,'.',','),
                    'totalAdditionalMonth'  =>  'US$ '.number_format($additionalMonthTot,2,'.',','),
                    'totalComissionYear'    =>  'US$ '.number_format($infoYearTotal,2,'.',','),
                    'totalAdditional'       =>  'US$ '.number_format($additionalYearTot,2,'.',','),
                    'comissionMonth'        =>  $infoMonth,
                    'additionalMonth'       =>  $additionalMonth,
                    'comissionYear'         =>  $infoYear,
                    'additionalYear'        =>  $additionalYear,
                    'totalMonth'            =>  'US$ '.number_format(($infoMonthTotal + $additionalMonthTot),2,'.',','),
                    'totalYear'             =>  'US$ '.number_format(($infoYearTotal + $additionalYearTot),2,'.',','),
                    'monthMin'              =>  Carbon::now()->startOfMonth()->format('m/d/Y'),
                    'monthMax'              =>  Carbon::now()->format('m/d/Y'),
                    'yearMin'               =>  Carbon::now()->startOfYear()->format('m/d/Y'),
                    'yearMax'               =>  Carbon::now()->format('m/d/Y'),
                    'dataComission'         =>  $percComission,
                ]);
            } // try { ... }
            catch(Exception $error) {

            } // catch(Exception $error) { ... }
        } // public function index(Request $request) { ... }
    }