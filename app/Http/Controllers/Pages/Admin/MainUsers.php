<?php
    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\User;
    use Hash;

    class MainUsers extends Controller {
        public function list(Request $request) {
            try {
                $allUsers   =   User::where('admin',false)
                                ->orderBy('name','asc')
                                ->get();
                $allAdmin   =   User::where('admin',true)
                                ->orderBy('name','asc')
                                ->get();

                return view('pages.admin.user',[
                    'users' =>  $allUsers,
                    'admins'=>  $allAdmin,
                ]);
            }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            }
        } // public function list(Request $request) { ... }

        public function save(Request $request) {
            try {
                $name       =   $request->nameForm;
                $email      =   $request->emailForm;
                $password   =   $request->passwordForm;
                $admin      =   (intval($request->adminForm) == 1) ? true : false;

                if(is_null($name) || is_null($email) || is_null($password)) return redirect()->route('admin.users.list');

                // Controlador para criação de usuário
                $user           =   new User();
                $user->name     =   $name;
                $user->email    =   $email;
                $user->password =   Hash::make($password);
                $user->admin    =   $admin;
                $user->save();

                return redirect()->route('admin.users.list');
            }
            catch(Exception $error) {
                return redirect()->route('admin.users.list');
            } // catch(Exception $error) { ... }
        } // public function save(Request $request) { ... }


        public function update(Request $request) {
            try {
                $id         =   $request->input('idUserForm');
                $name       =   $request->input('nameForm');
                $email      =   $request->input('emailForm');
                $password   =   $request->input('passwordForm');
                $admin      =   (intval($request->input('adminForm',0)) == 1) ? true : false;

                if(is_null($id) || is_null($name) || is_null($email)) return redirect()->route('admin.users.list');

                
                if(is_null($password)) {
                    User::find($id)->update([
                        'name'  =>  $name,
                        'email' =>  $email,
                        'admin' =>  $admin,
                    ]);
                }
                else {
                    User::find($id)->update([
                        'name'      =>  $name,
                        'email'     =>  $email,
                        'admin'     =>  $admin,
                        'password'  =>  Hash::make($password),
                    ]);
                }

                return redirect()->route('admin.users.list');

            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('admin.users.list');
            } // catch(Exception $error) { ... }
        } // public function update(Request $request) { ... }
    } // class MainUsers extends Controller { ... }
