<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class utilisateur extends Authenticatable
{
    protected $table = 'utilisateur';
    protected $fillable = ['surname', 'name', 'email', 'phone',
     'birthdate', 'fonction', 'city', 'country', 'photo',
     'password'];
     
}
