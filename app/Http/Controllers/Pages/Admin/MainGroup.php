<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\User;
    use App\Models\UsersGroup;
    use App\Models\UsersGroupUser;

    class MainGroup extends Controller {
        public function list(Request $request) {
            try {
                $groups =   UsersGroup::orderBy('name','asc')->get();

                foreach ($groups as $key => $group) {
                    $groups[$key]->users_in =   UsersGroupUser::where('id_users_group',$group->id_users_group)->get();
                } // foreach ($groups as $group) { ... }

                return view('pages.admin.group',[
                    'groups'    =>  $groups,
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function list(Request $request) { ... }

        public function userGroups(Request $request) {
            try {
                $idUser     =   $request->input('idUser');
                $existGroup =   UsersGroupUser::where('id_user',intval($idUser))->select('id_users_group');
                $groupsUser =   UsersGroup::whereIn('id_users_group',$existGroup)->orderBy('name','asc')->get();


                $existGroup =   UsersGroupUser::where('id_user',intval($idUser))->select('id_users_group');
                $group      =   UsersGroup::whereNotIn('id_users_group',$existGroup)->orderBy('name','asc')->get();

                if(is_null($idUser)) return redirect()->route('admin.users.list');

                return view('pages.admin.userGroup',[
                    'groupsUser'=>  $groupsUser,
                    'groups'    =>  $group,
                    'idUser'    =>  User::find(intval($idUser)),
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function userGroups(Request $request) { ... }

        public function groupUsers(Request $request) {
            try {
                $idGroup    =   $request->input('idGroup');

                if(is_null($idGroup)) return redirect()->route('admin.groups.list');

                $existGroup =   UsersGroupUser::where('id_users_group',intval($idGroup))->select('id_user');
                $groupsUser =   User::whereIn('id',$existGroup)->orderBy('name','asc')->get();


                $existGroup =   UsersGroupUser::where('id_users_group',intval($idGroup))->select('id_user');
                $group      =   User::whereNotIn('id',$existGroup)->orderBy('name','asc')->get();

                return view('pages.admin.groupUser',[
                    'UsersGroup'=>  $groupsUser,
                    'users'     =>  $group,
                    'idGroup'   =>  UsersGroup::find(intval($idGroup)),
                ]);
            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function groupUsers(Request $request) { ... }

        // # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- # -- //

        public function save(Request $request) {
            try {
                $name   =   $request->input('nameForm');
                $icon   =   $request->input('iconForm');
                $percent=   str_replace(',','.',$request->input('percentual',0));
                $status =   (intval($request->input('statusForm',0)) == 1) ? true : false;

                if(is_null($name) || is_null($status)) return redirect()->route('admin.groups.list');

                $usersGroup         =   new UsersGroup;

                $usersGroup->name   =   $name;
                $usersGroup->icon   =   is_null($icon) ? 'fas fa-users' : $icon;
                $usersGroup->status =   $status;
                $usersGroup->percent=   doubleval($percent);

                $usersGroup->save();

                return redirect()->route('admin.groups.list');

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
                $percent=   str_replace(',','.',$request->input('percentual',0));
                $status =   (intval($request->input('statusForm',0)) == 1) ? true : false;

                if(is_null($idForm) || is_null($name) || is_null($status)) return redirect()->route('admin.groups.list');

                UsersGroup::find($idForm)->update([
                    'name'      =>  $name,
                    'icon'      =>  $icon,
                    'status'    =>  $status,
                    'percent'   =>  doubleval($percent)
                ]);

                return redirect()->route('admin.groups.list');

            } // try { ... }
            catch(Exception $erro) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $erro) { ... }
        } // public function save(Request $request) { ... }

        public function addGroupUser(Request $request) {
            try {
                $idUser =   $request->input('idUser');
                $idGroup=   $request->input('idGroup');
                $idRed  =   $request->input('redirectTo',0);

                if(is_null($idUser) || is_null($idGroup)) return redirect()->route('admin.users.list');

                $addGroup                   =   new UsersGroupUser;
                $addGroup->id_users_group   =   intval($idGroup);
                $addGroup->id_user          =   intval($idUser);
                $addGroup->save();

                if(intval($idRed) == 0) {
                    return redirect()->route('admin.users.group',[
                        'idUser'    =>  intval($idUser),
                    ]);
                }
                else {
                    return redirect()->route('admin.groups.user',[
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
    
                    if(is_null($idUser) || is_null($idGroup)) return redirect()->route('admin.users.list');
    
                    UsersGroupUser::where('id_user',intval($idUser))
                                    ->where('id_users_group',intval($idGroup))
                                    ->delete();
    
                    if(intval($idRed) == 0) {
                        return redirect()->route('admin.users.group',[
                            'idUser'    =>  intval($idUser),
                        ]);
                    }
                    else {
                        return redirect()->route('admin.groups.user',[
                            'idGroup'    =>  intval($idGroup),
                        ]);
                    }
                }
                catch(Exception $error) {
                    return redirect()->route('admin.users.list');
                } // catch(Exception $error) { ... }
            }
            catch(Exception $error) {
                return redirect()->route('admin.users.list');
            } // catch(Exception $error) { ... }
        } // public function removeGroup(Request $request) { ... }
    } // class MainGroup extendsupdate Controller { ... }
