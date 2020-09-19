<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UserCompensation extends Model {
        protected $table        =   'user_compensation';
        protected $primaryKey   =   'id_user_compensation';
        protected $fillable     =   ['id_user','type','percentual','init_date','end_date'];
    }