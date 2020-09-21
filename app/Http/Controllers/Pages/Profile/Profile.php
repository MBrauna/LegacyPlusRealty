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
                $group  =   Group::whereIn('id_group',GroupUser::where('id_user',Auth::user()->id)->select('id_group')->distinct())->get();


                return view('pages.profile.profile',[
                    'groups'            =>  $group,
                    'id_user_recommend' =>  is_null(Auth::user()->id_user_recommend) ? null : User::find(Auth::user()->id_user_recommend),
                ]);
            }
            catch(Exception $error) {
                return redirect()->route('dashboard.home');
            }
        } // public function profile(Request $request) { ... }
    }
