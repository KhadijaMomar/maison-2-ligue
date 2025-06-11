<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $primaryKey = 'id_admin';
    protected $table = 'admins';
    protected $fillable = ['email', 'password'];
}
