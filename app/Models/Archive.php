<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Archive extends Model
    {
        protected $table        =   'archive';
        protected $primaryKey   =   'id_archive';
        protected $fillable     =   ['id_user','id_group','id_contract','id_user_created','repository','local','name_server','name_file','extension','mine','length'];
    }
