<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Auth;

    use App\User;
    use App\Models\UsersGroup;
    use App\Models\Archive;

    class MainArchive extends Controller
    {
        public function list(Request $request) {
            try {
                $users          =   User::all();
                $groups         =   UsersGroup::where('status',true)->orderBy('name','asc')->get();
                $contacts       =   [];

                $listUsers      =   Archive::whereNotNull('id_user')->where('id_user_created',Auth::user()->id)->orderBy('name_file','desc')->get();
                $listGroups     =   Archive::whereNotNull('id_group')->orderBy('name_file','desc')->get();
                $listContract   =   Archive::whereNotNull('id_contract')->orderBy('name_file','desc')->get();

                foreach ($listUsers as $key => $value) {
                    $listUsers[$key]->user  =   User::find($value->id_user);
                } // foreach ($listUsers as $key => $value) { ... }

                foreach ($listGroups as $key => $value) {
                    $listGroups[$key]->group  =   UsersGroup::find($value->id_group);
                } // foreach ($listUsers as $key => $value) { ... }

                return view('pages.admin.archive',[
                    'users'     =>  $users,
                    'groups'    =>  $groups,
                    'archiveU'  =>  $listUsers,
                    'archiveG'  =>  $listGroups,
                    'archiveC'  =>  $listContract,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dasboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }
    }