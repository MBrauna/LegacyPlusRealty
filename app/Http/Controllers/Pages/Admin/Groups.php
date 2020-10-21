<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Models\Group;
    use App\Models\GroupUser;
    use App\Models\Archive;
    use App\User;

    class Groups extends Controller
    {
        public function list(Request $request) {
            try {
                $groups =   Group::orderBy('name','asc')->get();

                foreach ($groups as $key => $group) {
                    $groups[$key]->users_in =   GroupUser::where('id_group',$group->id_group)->get();
                } // foreach ($groups as $group) { ... }

                return view('pages.admin.group.group',[
                    'groups'    =>  $groups,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }

        public function save(Request $request) {
            try {
                $name   =   $request->input('nameForm');
                $icon   =   $request->input('iconForm');
                $percent=   $request->input('percentual',0);
                $status =   (intval($request->input('statusForm',0)) == 1) ? true : false;

                if(is_null($name) || is_null($status)) return redirect()->route('admin.group.list');

                $usersGroup         =   new Group;

                $usersGroup->name   =   $name;
                $usersGroup->icon   =   is_null($icon) ? 'fas fa-users' : $icon;
                $usersGroup->status =   $status;

                $usersGroup->save();

                return redirect()->route('admin.group.list');

            } // try { ... }
            catch(Exception $erro) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $erro) { ... }
        } // public function save(Request $request) { ... }

        public function update(Request $request) {
            try {
                $idForm =   intval($request->input('idGroupForm'));
                $name   =   $request->input('nameForm');
                $icon   =   $request->input('iconForm');
                $status =   (intval($request->input('statusForm',0)) == 1) ? true : false;

                if(is_null($idForm) || is_null($name) || is_null($status)) return redirect()->route('admin.group.list');

                Group::find($idForm)->update([
                    'name'  =>  $name,
                    'icon'  =>  $icon,
                    'status'=>  $status,
                ]);

                return redirect()->route('admin.group.list');

            } // try { ... }
            catch(Exception $erro) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $erro) { ... }
        } // public function save(Request $request) { ... }

        public function groupUsers(Request $request) {
            try {
                $idGroup    =   $request->input('idGroup');

                if(is_null($idGroup)) return redirect()->route('admin.group.list');

                $existGroup =   GroupUser::where('id_group',intval($idGroup))->select('id_user');
                $groupsUser =   User::whereIn('id',$existGroup)->orderBy('name','asc')->get();


                $existGroup =   GroupUser::where('id_group',intval($idGroup))->select('id_user');
                $group      =   User::whereNotIn('id',$existGroup)->orderBy('name','asc')->get();

                return view('pages.admin.group.groupUsers',[
                    'UsersGroup'=>  $groupsUser,
                    'users'     =>  $group,
                    'idGroup'   =>  Group::find(intval($idGroup)),
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function groupUsers(Request $request) { ... }


        public function addGroupUser(Request $request) {
            try {
                $idUser =   $request->input('idUser');
                $idGroup=   $request->input('idGroup');
                $idRed  =   $request->input('redirectTo',0);

                if(is_null($idUser) || is_null($idGroup)) return redirect()->route('admin.group.list');

                $addGroup                   =   new GroupUser;
                $addGroup->id_group   =   intval($idGroup);
                $addGroup->id_user          =   intval($idUser);
                $addGroup->save();

                if(intval($idRed) == 0) {
                    return redirect()->route('admin.group.list',[
                        'idUser'    =>  intval($idUser),
                    ]);
                }
                else {
                    return redirect()->route('admin.group.user',[
                        'idGroup'    =>  intval($idGroup),
                    ]);
                }
            }
            catch(Exception $error) {
                return redirect()->route('admin.users.list');
            } // catch(Exception $error) { ... }
        } // public function addGroup(Request $request) { ... }

        public function removeGroupUser(Request $request) {
            try {
                try {
                    $idUser =   $request->input('idUser');
                    $idGroup=   $request->input('idGroup');
                    $idRed  =   $request->input('redirectTo',0);
    
                    if(is_null($idUser) || is_null($idGroup)) return redirect()->route('admin.group.list');
    
                    GroupUser::where('id_user',intval($idUser))
                            ->where('id_group',intval($idGroup))
                            ->delete();
    
                    if(intval($idRed) == 0) {
                        return redirect()->route('admin.group.list',[
                            'idUser'    =>  intval($idUser),
                        ]);
                    }
                    else {
                        return redirect()->route('admin.group.user',[
                            'idGroup'    =>  intval($idGroup),
                        ]);
                    }
                }
                catch(Exception $error) {
                    return redirect()->route('admin.group.list');
                } // catch(Exception $error) { ... }
            }
            catch(Exception $error) {
                return redirect()->route('admin.group.list');
            } // catch(Exception $error) { ... }
        } // public function removeGroup(Request $request) { ... }

        public function archive(Request $request) {
            try {
                if(!isset($request->idGroup) || is_null($request->idGroup)) {
                    return redirect()->route('admin.group.list');
                } // if(!isset($request->idGroup) || is_null($request->idGroup)) { ... }

                $idGroup    =   Group::find($request->idGroup);

                if(is_null($idGroup)) return redirect()->route('admin.group.list');

                $archive    =   Archive::where('id_group',$idGroup->id_group)
                                ->orderBy('name_file','asc')
                                ->get();

                return view('pages.admin.group.archive',[
                    'idGroup'   =>  $idGroup,
                    'archive'   =>  $archive,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('admin.group.list');
            } // catch(Exception $error) { ... }
        }
    }
