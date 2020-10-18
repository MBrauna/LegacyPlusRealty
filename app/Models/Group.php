<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Group extends Model {
        protected $table        =   'group';
        protected $primaryKey   =   'id_group';
        protected $fillable     =   ['name','icon','status'];
    }