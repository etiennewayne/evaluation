<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //

    protected $primaryKey = 'schedule_id';
    protected $table = 'schedules';

    protected $fillable = ['schedule_code', 'program_id',
    'institute', 'course_code', 'time_start', 'time_end', 'sched_day', 'room'];

    protected $date = ['time_start', 'time_end'];

    public function academicYear(){
        return $this->hasOne('App\ay', 'ay_id', 'ay_id');
    }


    public function faculty()
    {
        return $this->hasOne('App\Faculty', 'faculty_code', 'faculty_code');
    }

    public function course()
    {
        return $this->hasOne('App\Course', 'course_code', 'course_code');
    }

    public function comments()
    {
        return $this->hasMany('App\RatingComment', 'schedule_code', 'schedule_code');
    }

    


    // public function schedules()
    // {
    //     return $this->belongsTo('App\Enrolee', 'schedule_id', 'schedule_id');
    // }


}
