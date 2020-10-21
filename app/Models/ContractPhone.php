<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class ContractPhone extends Model
    {
        protected $table        =   'contract_phone';
        protected $primaryKey   =   'id_contract_phone';
        protected $fillable     =   [
            'id_contract',
            'reference',
            'phone',
        ];
    }
