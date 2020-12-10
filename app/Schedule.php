<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //

    protected $primaryKey = 'schedule_id';
    protected $table = 'schedules';

    protected $fillable = [];

    protected $date = ['time_start', 'time_end'];

    public function academicYear(){
        return $this->hasOne('App\ay', 'ay_id', 'ay_id');
    }


    public function faculty()
    {
        return $this->hasOne('App\Faculty', 'faculty_id', 'faculty_id');
    }

    public function course()
    {
        return $this->hasOne('App\Course', 'course_id', 'course_id');
    }

    public function comments()
    {
        return $this->hasMany('App\RatingComment', 'schedule_id', 'schedule_id');
    }

    


    // public function schedules()
    // {
    //     return $this->belongsTo('App\Enrolee', 'schedule_id', 'schedule_id');
    // }


}
