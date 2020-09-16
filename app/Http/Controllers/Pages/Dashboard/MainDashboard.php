<?php

    namespace App\Http\Controllers\Pages\Dashboard;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;

    class MainDashboard extends Controller {
        public function index(Request $request) {
            $dataContract   =   [];

            return view('pages.dashboard.dashboard',[
                'contracts' =>  $dataContract,
            ]);
        } // public function index(Request $request) { ... }
    } // class MainDashboard extends Controller { ... }