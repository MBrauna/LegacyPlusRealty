<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class GroupUser extends Model {
        protected $table        =   'group_user';
        protected $primaryKey   =   'id_group_user';
        protected $fillable     =   ['id_group','id_user'];
    }