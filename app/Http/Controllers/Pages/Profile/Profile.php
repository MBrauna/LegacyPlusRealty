<?php

    namespace App\Http\Controllers\Pages\Profile;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\User;
    use App\Models\Group;
    use App\Models\GroupUser;
    use App\Models\UserAddress;
    use App\Models\UserCompensation;
    use App\Models\UserPhone;

    use Auth;

    class Profile extends Controller
    {
        public function profile(Request $request) {
            try {
                $user       =   User::find(Auth::user()->id);
                $users      =   User::orderBy('name','asc')->get();
                $groups     =   Group::join('group_user','group_user.id_group','group.id_group')
                                ->where('group_user.id_user',Auth::user()->id)
                                ->orderBy('group.name','asc')
                                ->select('group.*')
                                ->distinct()
                                ->get();
                $groupList  =   Group::where('status',true)->orderBy('name','asc')->get();
                $userAddress=   UserAddress::where('id_user',Auth::user()->id)->orderBy('id_user_address','asc')->get();
                $userPhone  =   UserPhone::where('id_user',Auth::user()->id)->orderBy('id_user_phone','asc')->get();
                $userComp   =   UserCompensation::where('id_user',Auth::user()->id)->orderBy('id_user_compensation','asc')->get();

                return view('pages.profile.profile',[
                    'users'     =>  $users,
                    'user'      =>  $user,
                    'groups'    =>  $groupList,
                    'group'     =>  $groups,
                    'address'   =>  $userAddress,
                    'phone'     =>  $userPhone,
                    'usercomp'  =>  $userComp,
                ]);
            }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            }
        } // public function profile(Request $request) { ... }
    }
