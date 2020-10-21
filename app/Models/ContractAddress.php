<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class ContractAddress extends Model
    {
        protected $table        =   'contract_address';
        protected $primaryKey   =   'id_contract_address';
        protected $fillable     =   [
            'id_contract',
            'address',
            'city',
            'state',
            'country',
            'zip_code',
        ];
    }
