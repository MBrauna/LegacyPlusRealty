<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Models\SplitParameter;

    class Parameters extends Controller
    {
        public function index(Request $request) {
            try {
                $splitParameter    =   SplitParameter::orderBy('visual_name')->get();
                return view('pages.admin.utilities.parameter',[
                    'parameters'    =>  $splitParameter,
                ]);
            }
            catch(Exception $error) {
                return redirect()->route('home');
            }
        } // public function index(Request $request) { ... }

        public function alter(Request $request) {
            try {
                if(is_null($request->idSplitParameter) || is_null($request->param_value)) return redirect()->route('admin.utilities.parameters');

                $parameter          =   SplitParameter::find($request->idSplitParameter);
                $parameter->value   =   round(floatval($request->param_value),2);
                $parameter->save();

                return redirect()->route('admin.utilities.parameters');
            }
            catch(Exception $error) {
                return redirect()->route('home');
            }
        } // public function alter(Request $request) { ... }
    } // class Parameters extends Controller { ... }
