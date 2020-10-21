<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UserAddress extends Model
    {
        protected $table        =   'user_address';
        protected $primaryKey   =   'id_user_address';
        protected $fillable     =   [
            'id_user',
            'address',
            'city',
            'state',
            'country',
            'zip_code'
        ];
    }
