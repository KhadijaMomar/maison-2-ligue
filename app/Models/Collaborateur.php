<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Collaborateur extends Authenticatable
{

    protected $guard = 'collaborateur';
    protected $fillable = ['email', 'password'];
    // use HasFactory;

    // protected $primaryKey = 'id_collaborateur'; // si tu veux garder ce nom de clé primaire

    // protected $fillable = [
    //     'name',
    //     'surname',
    //     'mail',
    //     'password',
    //     'city',
    //     'country',
    //     'phone',
    //     'photo',
    //     'birthdate',
    //     'est_admin'
    // ];
}
