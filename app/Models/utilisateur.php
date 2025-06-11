<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class utilisateur extends Authenticatable
{
    protected $table = 'utilisateur';
    protected $fillable = ['email', 'password'];
}
