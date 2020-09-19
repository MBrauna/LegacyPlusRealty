<?php

    namespace App\Http\Controllers\Pages\Dashboard;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;
    use Carbon\Carbon;
    use App\Models\Payment;

    class MainDashboard extends Controller {
        public function index(Request $request) {
            $dataContract   =   [];

            $sumMonth       =   0;
            $sumYear        =   0;

            return view('pages.dashboard.dashboard',[
                'contracts' =>  $dataContract,
                'monthSum'  =>  $sumMonth,
                'yearSum'   =>  $sumYear,
            ]);
        } // public function index(Request $request) { ... }
    } // class MainDashboard extends Controller { ... }