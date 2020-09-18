<?php

    if(!function_exists('render_tree')) {
        function render_tree($data) {
            return view('components.renderTree',[
                'data'  =>  $data,
            ]);
        } // function render_tree($idUser) { ... }
    } // if(!function_exists('render_tree')) { ... }