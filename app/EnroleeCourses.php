<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnroleeCourses extends Model
{
    //

    //from infosystem
    protected $connection = 'registrar_gadtc';
    protected $table = 'tblenrdtl202';

     //protected $primaryKey = 'EnrIDNum';

    //protected $fillable = ['student_id', 'schedule_code', 'course_code', 'course_status'];

    public $timestamps = false;

    public function schedule(){
        return $this->hasOne('App\Schedule', 'SchedCode','EnrSchedCode');
    }

    public function course(){
        return $this->hasOne('App\Course', 'SubjCode','EnrSubjCode');
    }

//    public function course(){
//        return $this->hasOneThrough(Course::class, Schedule::class,
//            'EnrSchedCode', 'SubjCode',
//            'EnrSchedCode', 'Sched'
//        );
//    }






}
