<?php

    namespace App\Http\Controllers\Pages\Admin\Utilities;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use Auth;

    use App\User;
    use App\Models\Archive;
    use App\Models\Group;
    use App\Models\GroupUser;


    class MainArchive extends Controller
    {
        public function list(Request $request) {
            try {
                $users          =   User::all();

                $archive        =   Archive::where('id_user',Auth::user()->id)->orderBy('name_file','asc')->get();
                $contentGroup   =   GroupUser::where('id_user',Auth::user()->id)->select('id_group')->distinct();
                $groups         =   Group::whereIn('id_group',$contentGroup)->get();
                $groupReturn    =   [];

                foreach($groups as $group) {
                    $tmpContent             =   $group;
                    $tmpContent->archive    =   Archive::where('id_group',$group->id_users_group)->orderBy('name_file','asc')->get();

                    array_push($groupReturn,(object)$tmpContent);
                } // foreach (user_group(Auth::user()-id) as $group) { ... }

                $listUsers      =   Archive::whereNotNull('id_user')->where('id_user_created',Auth::user()->id)->orderBy('name_file','desc')->get();
                $listGroups     =   Archive::whereNotNull('id_group')->orderBy('name_file','desc')->get();
                $listContract   =   Archive::whereNotNull('id_contract')->orderBy('name_file','desc')->get();

                foreach ($listUsers as $key => $value) {
                    $listUsers[$key]->user  =   User::find($value->id_user);
                } // foreach ($listUsers as $key => $value) { ... }

                foreach ($listGroups as $key => $value) {
                    $listGroups[$key]->group  =   UsersGroup::find($value->id_group);
                } // foreach ($listUsers as $key => $value) { ... }

                return view('pages.admin.utilities.archive',[
                    'users'     =>  $users,
                    'groups'    =>  $groupReturn,
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
