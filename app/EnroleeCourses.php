<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnroleeCourses extends Model
{
    //

    protected $fillable = ['student_id', 'schedule_code', 'course_code', 'course_status'];

    public $timestamps = false;

    protected $primaryKey = 'enrolee_course_id';

    protected $table = 'enrolee_courses';

    public function schedules(){
        return $this->hasMany('App\Schedule', 'schedule_code','schedule_code');
    }


    

}
