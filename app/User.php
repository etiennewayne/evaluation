<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
   // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'lname', 'fname', 'mname', 'sex', 'email', 'password',
        'student_id', 'lname', 'fname', 'mname', 'sex', 'username', 'password', 'role'
    ];
    
    protected $primaryKey = 'user_id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	//protected $table = 'vw_users';

    public function positions(){
        return $this->hasOne('App\Position', 'position_id', 'position_id');
    }



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/
}
