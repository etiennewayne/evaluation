<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    //

    protected $connection = 'registrar_gadtc';
    protected $table ='users';



    protected $primaryKey = 'id';


    protected $fillable = [
        'username', 'email', 'password', 'userType', 'name', 'institute',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


}
