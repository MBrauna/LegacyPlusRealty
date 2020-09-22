<?php

    namespace App\Http\Controllers\Pages\Admin\User;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\User;

    class MainUser extends Controller
    {
        public function list(Request $request) {
            try {
                $users  =   User::orderBy('name','asc')->get();

                foreach ($users as $key => $value) {
                    if(is_null($value->id_user_recommend)) {
                        $users[$key]->recommendedBy =   [];
                    } // if(is_null($value->id_user_recommend)) { ... }
                    else {
                        $users[$key]->recommendedBy =   User::find($value->id_user_recommend);
                    } // else { ... }
                } // foreach ($users as $key => $value) { ... }

                return view('pages.admin.user.list',[
                    'users' =>  $users,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }

        public function pageAdd(Request $request) {
            $users  =   User::orderBy('name','asc')->get();
            return view('pages.admin.user.add',[
                'users' =>  $users,
            ]);
        } // public function pageAdd(Request $request) { ... }
    }
