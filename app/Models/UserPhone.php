<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UserPhone extends Model {
        protected $table        =   'user_phone';
        protected $primaryKey   =   'id_user_phone';
        protected $fillable     =   ['id_user','ddi','ddd','phone'];
    }