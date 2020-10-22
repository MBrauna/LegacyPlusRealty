<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Models\QuickAccess;

    class QuickLinks extends Controller
    {
        public function list(Request $request) {
            try {
                $quickAccess    =   QuickAccess::orderBy('description','asc')->get();

                return view('pages.admin.utilities.quickAccess',[
                    'quickAccess'   =>  $quickAccess,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }

        public function add(Request $request) {
            try {
                $description    =   $request->input('description');
                $url            =   $request->input('url');

                if(is_null($description) || is_null($url)) return redirect()->route('admin.utilities.link');

                $quickAccess                =   new QuickAccess;
                $quickAccess->description   =   $description;
                $quickAccess->url           =   $url;
                $quickAccess->status        =   true;
                $quickAccess->save();

                return redirect()->route('admin.utilities.link');
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function add(Request $request) { ... }

        public function remove(Request $request) {
            try {
                $idQuickAccess  =   $request->input('idQuickAccess');
                if(is_null($idQuickAccess)) return redirect()->route('admin.utilities.link');

                QuickAccess::where('id_quick_access',$idQuickAccess)->delete();

                return redirect()->route('admin.utilities.link');
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function remove(Request $request) { ... }
    }
