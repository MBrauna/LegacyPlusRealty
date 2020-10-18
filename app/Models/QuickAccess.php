<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class QuickAccess extends Model {
        protected $table        =   'quick_access';
        protected $primaryKey   =   'id_quick_access';
        protected $fillable     =   ['description','url'];
    }