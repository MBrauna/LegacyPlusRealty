<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable =   ['name', 'email', 'photo','license','id_user_recommend','admin', 'broker','realtor','percent'];
    protected $hidden   =   ['password', 'remember_token'];
    protected $casts    =   ['email_verified_at' => 'datetime'];
}
