<?php

    namespace App\Http\Controllers\Pages\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    
    use Validator;
    use Hash;
    use Carbon\Carbon;

    use App\User;
    use App\Models\Group;
    use App\Models\UserAddress;
    use App\Models\UserPhone;
    use App\Models\UserType;
    use App\Models\UserCompensation;
    use App\Models\Archive;

    class Users extends Controller
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

                    $users[$key]->descUserType      =   UserType::find($value->id_user_type);
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
            $groups =   Group::where('status',true)->orderBy('name','asc')->get();
            $type   =   UserType::where('status',true)->orderBy('description','asc')->get();

            return view('pages.admin.user.add',[
                'users'     =>  $users,
                'groups'    =>  $groups,
                'type'      =>  $type,
            ]);
        } // public function pageAdd(Request $request) { ... }

        public function pageView(Request $request) {
            $validator  =   Validator::make($request->all(),[
                'idUser'    =>  'required',
            ]);

            if($validator->fails()) {
                return back();
            } // if($validator->fails()) { ... }

            $user       =   User::find($request->idUser);
            $users      =   User::orderBy('name','asc')->get();
            $type       =   UserType::where('status',true)->orderBy('description','asc')->get();
            $groups     =   Group::join('group_user','group_user.id_group','group.id_group')
                            ->where('group_user.id_user',$user->id)
                            ->orderBy('group.name','asc')
                            ->select('group.*')
                            ->distinct()
                            ->get();
            $groupList  =   Group::where('status',true)->orderBy('name','asc')->get();
            $userAddress=   UserAddress::where('id_user',$user->id)->orderBy('id_user_address','asc')->get();
            $userPhone  =   UserPhone::where('id_user',$user->id)->orderBy('id_user_phone','asc')->get();
            $userComp   =   UserCompensation::where('id_user',$user->id)->orderBy('min_value','asc')->orderBy('max_value','asc')->get();
            $archive    =   Archive::where('id_user',$user->id)->orderBy('name_file')->get();

            return view('pages.admin.user.view',[
                'users'     =>  $users,
                'user'      =>  $user,
                'groups'    =>  $groupList,
                'group'     =>  $groups,
                'address'   =>  $userAddress,
                'phone'     =>  $userPhone,
                'usercomp'  =>  $userComp,
                'archive'   =>  $archive,
                'type'      =>  $type,
            ]);
        }

        public function pageEdit(Request $request) {
            $validator  =   Validator::make($request->all(),[
                'idUser'    =>  'required',
            ]);

            if($validator->fails()) {
                return back();
            } // if($validator->fails()) { ... }

            $user       =   User::find($request->idUser);
            $users      =   User::orderBy('name','asc')->get();
            $type       =   UserType::where('status',true)->orderBy('description','asc')->get();
            $groups     =   Group::join('group_user','group_user.id_group','group.id_group')
                            ->where('group_user.id_user',$user->id)
                            ->orderBy('group.name','asc')
                            ->select('group.*')
                            ->distinct()
                            ->get();
            $groupList  =   Group::where('status',true)->orderBy('name','asc')->get();
            $userAddress=   UserAddress::where('id_user',$user->id)->orderBy('id_user_address','asc')->get();
            $userPhone  =   UserPhone::where('id_user',$user->id)->orderBy('id_user_phone','asc')->get();
            $userComp   =   UserCompensation::where('id_user',$user->id)->orderBy('min_value','asc')->orderBy('max_value','asc')->get();
            $archive    =   Archive::where('id_user',$user->id)->orderBy('name_file')->get();

            return view('pages.admin.user.edit',[
                'users'     =>  $users,
                'user'      =>  $user,
                'groups'    =>  $groupList,
                'group'     =>  $groups,
                'address'   =>  $userAddress,
                'phone'     =>  $userPhone,
                'usercomp'  =>  $userComp,
                'archive'   =>  $archive,
                'type'      =>  $type,
            ]);
        }

        public function save(Request $request) {
            try {
                $validator  =   Validator::make($request->all(),[
                    'name'      =>  'required',
                    'email'     =>  'required',
                    'password'  =>  'required',
                ]);

                if($validator->fails()) {
                    return back();
                } // if($validator->fails()) { ... }

                $existEmail =   User::where('email',$request->email)->count();
                if($existEmail > 0 || strlen($request->password) < 3 || strlen($request->password) > 16) {
                    return redirect()->route('admin.user.list');
                } // if($existEmail > 0 || strlen($request->password) < 3 || strlen($request->password) > 16) { ... }

                $user                       =   new User;
                $user->name                 =   $request->name.' '.$request->second_name.' '.$request->last_name;
                $user->first_name           =   $request->name;
                $user->middle_name          =   $request->second_name;
                $user->last_name            =   $request->last_name;
                $user->email                =   $request->email;
                $user->license              =   $request->license;
                $user->license_date         =   $request->license_date;
                $user->license_due          =   $request->license_due;
                $user->password             =   Hash::make($request->password);
                $user->id_user_recommend    =   is_null($request->id_user_recommend) ? null : intval($request->id_user_recommend);
                $user->id_user_type         =   $request->id_user_type;
                $user->percent              =   round(doubleval($request->percent),2);

                $user->save();

                // Sale
                if(isset($request->min_sale)) {
                    foreach ($request->min_sale as $key => $value) {
                        $userCompensation                       =   new UserCompensation;
                        $userCompensation->id_user              =   $user->id;
                        $userCompensation->id_transaction_type  =   1;
                        $userCompensation->min_value            =   round(doubleval($request->min_sale[$key]),2);
                        $userCompensation->max_value            =   round(doubleval($request->max_sale[$key]),2);
                        $userCompensation->percentual           =   round(doubleval($request->perc_sale[$key]),2);
                        $userCompensation->save();
                    } // foreach ($request->min_sale as $key => $value) { ... }
                } // if(isset($request->min_sale)) { ... }

                // Rent
                if(isset($request->min_rent)) {
                    foreach ($request->min_rent as $key => $value) {
                        $userCompensation                       =   new UserCompensation;
                        $userCompensation->id_user              =   $user->id;
                        $userCompensation->id_transaction_type  =   2;
                        $userCompensation->min_value            =   round(doubleval($request->min_rent[$key]),2);
                        $userCompensation->max_value            =   round(doubleval($request->max_rent[$key]),2);
                        $userCompensation->percentual           =   round(doubleval($request->perc_rent[$key]),2);
                        $userCompensation->save();
                    } // foreach ($request->min_sale as $key => $value) { ... }
                } // if(isset($request->min_sale)) { ... }

                // Save address
                if(isset($request->address)) {
                    foreach ($request->address as $key => $value) {
                        $userAddress                =   new UserAddress;
                        $userAddress->id_user       =   $user->id;
                        $userAddress->address       =   $request->address[$key];
                        $userAddress->city          =   $request->city[$key];
                        $userAddress->state         =   $request->state[$key];
                        $userAddress->country       =   $request->country[$key];
                        $userAddress->zip_code      =   $request->zip_code[$key];
                        $userAddress->save();
                    } // foreach ($request->address as $key => $value) { ... }
                }

                // Save phone
                if(isset($request->phone)) {
                    foreach ($request->phone as $key => $value) {
                        $userPhone              =   new UserPhone;
                        $userPhone->id_user     =   $user->id;
                        $userPhone->reference   =   $request->reference[$key];
                        $userPhone->phone       =   $request->phone[$key];
                        $userPhone->save();
                    } // foreach ($request->phone as $key => $value) { ... }
                }

                return redirect()->route('admin.user.list');

            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function save(Request $request) { ... }

        public function update(Request $request) {
            try {
                
                $validator  =   Validator::make($request->all(),[
                    'idUser'    =>  'required',
                    'name'      =>  'required',
                    'email'     =>  'required',
                ]);

                if($validator->fails()) {
                    return redirect()->route('home');
                } // if($validator->fails()) { ... }

                $existEmail =   User::where('email',$request->email)->where('id','!=',$request->idUser)->count();
                if($existEmail > 0) {
                    return redirect()->route('home');
                } // if($existEmail > 0 || strlen($request->password) < 3 || strlen($request->password) > 16) { ... }


                $user                       =   User::find($request->idUser);
                $user->name                 =   $request->name.' '.$request->second_name.' '.$request->last_name;
                $user->first_name           =   $request->name;
                $user->middle_name          =   $request->second_name;
                $user->last_name            =   $request->last_name;
                $user->email                =   $request->email;
                $user->license              =   $request->license;
                $user->license_date         =   $request->license_date;
                $user->license_due          =   $request->license_due;
                $user->password             =   (!isset($request->password) || is_null($request->password)) ? $user->password : Hash::make($request->password);
                $user->id_user_recommend    =   is_null($request->id_user_recommend) ? null : intval($request->id_user_recommend);
                $user->id_user_type         =   $request->id_user_type;
                $user->percent              =   round(doubleval($request->percent),2);

                $user->save();

                UserCompensation::where('id_user',$user->id)->delete();
                // Sale
                if(isset($request->min_sale)) {
                    foreach ($request->min_sale as $key => $value) {
                        $userCompensation                       =   new UserCompensation;
                        $userCompensation->id_user              =   $user->id;
                        $userCompensation->id_transaction_type  =   1;
                        $userCompensation->min_value            =   round(doubleval($request->min_sale[$key]),2);
                        $userCompensation->max_value            =   round(doubleval($request->max_sale[$key]),2);
                        $userCompensation->percentual           =   round(doubleval($request->perc_sale[$key]),2);
                        $userCompensation->save();
                    } // foreach ($request->min_sale as $key => $value) { ... }
                } // if(isset($request->min_sale)) { ... }
                if(isset($request->min_rent)) {

                    foreach ($request->min_rent as $key => $value) {
                        $userCompensation                       =   new UserCompensation;
                        $userCompensation->id_user              =   $user->id;
                        $userCompensation->id_transaction_type  =   2;
                        $userCompensation->min_value            =   round(doubleval($request->min_rent[$key]),2);
                        $userCompensation->max_value            =   round(doubleval($request->max_rent[$key]),2);
                        $userCompensation->percentual           =   round(doubleval($request->perc_rent[$key]),2);
                        $userCompensation->save();
                    } // foreach ($request->min_sale as $key => $value) { ... }
                } // if(isset($request->min_sale)) { ... }

                // Save address
                UserAddress::where('id_user',$user->id)->delete();
                // Save address
                if(isset($request->address)) {
                    foreach ($request->address as $key => $value) {
                        $userAddress                =   new UserAddress;
                        $userAddress->id_user       =   $user->id;
                        $userAddress->address       =   $request->address[$key];
                        $userAddress->city          =   $request->city[$key];
                        $userAddress->state         =   $request->state[$key];
                        $userAddress->country       =   $request->country[$key];
                        $userAddress->zip_code      =   $request->postal_code[$key];
                        $userAddress->save();
                    } // foreach ($request->address as $key => $value) { ... }
                }

                // Save phone
                UserPhone::where('id_user',$user->id)->delete();
                if(isset($request->phone)) {
                    foreach ($request->phone as $key => $value) {
                        $userPhone              =   new UserPhone;
                        $userPhone->id_user     =   $user->id;
                        $userPhone->reference   =   $request->reference[$key];
                        $userPhone->phone       =   $request->phone[$key];
                        $userPhone->save();
                    } // foreach ($request->phone as $key => $value) { ... }
                }

                return redirect()->route('profile');

            } // try { ... }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            } // catch(Exception $error) { ... }
        } // public function update(Request $request) { ... }
    }
