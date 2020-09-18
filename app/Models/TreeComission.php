<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class TreeComission extends Model
    {
        protected $table        =   'tree_comission';
        protected $primaryKey   =   'id_tree_comission';

        public function childs() {
            return $this->hasMany('App\Models\TreeComission','id_tree_comission_prev', 'id_tree_comission') ;
        }

        public function parents() {
            return $this->hasMany('App\Models\TreeComission','id_tree_comission', 'id_tree_comission_prev') ;
        }
    }
