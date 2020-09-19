<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Payment extends Model {
        protected $table        =   'payment';
        protected $primaryKey   =   'id_payment';
        protected $fillable     =   ['id_contract','id_user','value','comission','comission_additional','payment_date'];
    }