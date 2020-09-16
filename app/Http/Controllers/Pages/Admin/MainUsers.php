<?php
    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\User;

    class MainUsers extends Controller {
        public function list(Request $request) {
            try {
                $allUsers   =   User::where('admin',false)->get();
                $allAdmin   =   User::where('admin',true)->get();

                return view('pages.admin.user',[
                    'users' =>  $allUsers,
                    'admins'=>  $allAdmin,
                ]);
            }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            }
        } // public function list(Request $request) { ... }
    } // class MainUsers extends Controller { ... }
