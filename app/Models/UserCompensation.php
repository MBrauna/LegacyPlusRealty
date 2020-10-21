<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UserCompensation extends Model
    {
        protected $table        =   'user_compensation';
        protected $primaryKey   =   'id_user_compensation';
        protected $fillable     =   [
            'id_user',
            'id_transaction_type',
            'min_value',
            'max_value',
            'percentual',
        ];
    }
