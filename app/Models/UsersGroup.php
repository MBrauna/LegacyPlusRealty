<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UsersGroup extends Model {
        protected $table        =   'users_group';
        protected $primaryKey   =   'id_users_group';
        protected $fillable     =   ['name','icon','status'];
    } // class UsersGroup extends Model { ... }