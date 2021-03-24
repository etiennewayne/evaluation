<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    //
    protected $connection = 'registrar_gadtc';
    protected $table ='users';


    protected $guard = 'admin';


    protected $fillable = ['username', 'email', 'password', 'userType'];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
