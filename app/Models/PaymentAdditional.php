<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class PaymentAdditional extends Model
    {
        protected $table        =   'payment_additional';
        protected $primaryKey   =   'id_payment_additional';
        protected $fillable     =   [
            'processing_date',
            'payment_date',
            'id_contract',
            'id_user',
            'id_user_payment',
            'value',
        ];
    }
