<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolee extends Model
{
    //

    protected $fillable = ['user_id', 'schedule_id'];

    public $timestamps = false;

    protected $primaryKey = 'enrolee_id';

    protected $table = 'enrolees';



    public function schedules(){
        return $this->hasMany('App\Schedule', 'schedule_id','schedule_id');
    }


    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }

    // public function isRated(){
        
    //     $user_id = Auth::user()->user_id;


    //     $rating = Rating::where('user_id', )
    //             ->where('schedule_id')
    //                 ->exists();

    //     retrun  
    // }


}
