<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class SplitParameter extends Model
    {
        protected $table        =   'split_parameter';
        protected $primaryKey   =   'id_split_parameter';
        protected $fillable     =   [
            'visual_name',
            'param_name',
            'value',
        ];
    }
