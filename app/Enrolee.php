<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolee extends Model
{
    //

    protected $fillable = ['student_id', 'program_code', 'enr_class', 'enr_yearlevel', 'enr_units', 'enr_section', 'enr_status'];

    public $timestamps = false;

    protected $primaryKey = 'enrolee_id';

    protected $table = 'enrolees';



    public function schedules(){
        return $this->hasMany('App\Schedule', 'schedule_code','schedule_code');
    }


    public function student_id()
    {
        return $this->hasOne('App\User', 'student_id', 'student_id');
    }

    // public function isRated(){
        
    //     $user_id = Auth::user()->user_id;


    //     $rating = Rating::where('user_id', )
    //             ->where('schedule_id')
    //                 ->exists();

    //     retrun  
    // }


}
