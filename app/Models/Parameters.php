<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Parameters extends Model {
        protected $table        =   'parameters';
        protected $primaryKey   =   'id';
        protected $fillable     =   ['parameter_name','name','value'];
    } // class Archive extends Model { ... }