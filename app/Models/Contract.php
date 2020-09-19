<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Contract extends Model {
        protected $table        =   'contract';
        protected $primaryKey   =   'id_contract';
        protected $fillable     =   ['type','start_contract','end_contract','payment_date','payment_exec','value','id_user_seller','description'];
    } // class Contract extends Model { ... }
