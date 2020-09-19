<?php

    namespace App\Http\Controllers\Pages\Dashboard;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;
    use Carbon\Carbon;
    use App\Models\Payment;

    class MainDashboard extends Controller {
        public function index(Request $request) {
            $dataContract   =   Payment::where('payment_date','>=',Carbon::now()->subMonths(12))->get();

            $sumMonth       =   Payment::where('payment_date','>=',Carbon::now()->subMonths(1))->sum('comission');
            $sumYear        =   Payment::where('payment_date','>=',Carbon::now()->subMonths(12))->sum('comission');

            return view('pages.dashboard.dashboard',[
                'contracts' =>  $dataContract,
                'monthSum'  =>  $sumMonth,
                'yearSum'   =>  $sumYear,
            ]);
        } // public function index(Request $request) { ... }
    } // class MainDashboard extends Controller { ... }