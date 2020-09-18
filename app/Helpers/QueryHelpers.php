<?php

    if(!function_exists('query_group')) {
        function query_group($data) {
            return DB::table('users_group')->where('id_users_group',$data)->first();
        } // function query_group($idGroup) { ... }
    } // if(!function_exists('query_group')) { ... }