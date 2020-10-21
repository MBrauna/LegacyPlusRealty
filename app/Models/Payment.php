<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Payment extends Model
    {
        protected $table        =   'payment';
        protected $primaryKey   =   'id_payment';
        protected $fillable     =   [
            'processing_date',
            'payment_date',
            'id_contract',
            'id_user',
            'percentual',
            'value_total',
            'value_split',
        ];
    }
