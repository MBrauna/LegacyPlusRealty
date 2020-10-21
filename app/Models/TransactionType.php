<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class TransactionType extends Model
    {
        protected $table        =   'transaction_type';
        protected $primaryKey   =   'id_transaction_type';
        protected $fillable     =   [
            'description',
            'status',
        ];
    }
