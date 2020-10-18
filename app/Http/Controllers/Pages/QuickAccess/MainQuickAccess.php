<?php

    namespace App\Http\Controllers\Pages\QuickAccess;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Models\QuickAccess;

    class MainQuickAccess extends Controller {
        public function index(Request $request) {
            try {
                $dataQuickAccess    =   QuickAccess::orderBy('description','asc')
                                        ->orderBy('url','asc')
                                        ->get();

                return view('pages.quickAccess.list',[
                    'quickAccess'   =>  $dataQuickAccess,
                ]);
            }
            catch(Exception $error) {
                return redirect()->route('home');
            } // catch(Exception $error) { ... }
        } // public function index(Request $request) { ... }
    } // class MainQuickAccess extends Controller { ... }
