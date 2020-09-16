<?php
    if(!function_exists('user_group')) {
        function user_group($idUser) {
            $vIdUser    =   (is_null($idUser) ? Auth::user()->id : $idUser);
            $return     =   [];

            $userGroup  =   DB::table('users_group')
                            ->join('users_group_user','users_group_user.id_users_group','users_group.id_users_group')
                            ->where('users_group_user.id_user',$vIdUser)
                            ->where('users_group.status',true)
                            ->select([
                                'users_group.*',
                            ])
                            ->distinct()
                            ->get()
                            ;

            foreach ($userGroup as $value) {
                if(!in_array($value, $return)) {
                    array_push($return, $value);
                } // if(!in_array($value, $return)) { ... }
            } // foreach ($userGroup as $value) { ... }

            return $return;
        } // function user_group($idUser) { ... }
    } // if(!function_exists('user_group')) { ... }

    if(!function_exists('user_data')) {
        function user_data($idUser) {
            $user   =   DB::table('users')->where('users.id',$idUser)->first();

            return $user;
        } // function user_data($idUser) { ... }
    } // if(!function_exists('user_data')) { ... }