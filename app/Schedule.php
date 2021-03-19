<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //

    //using the infosystem database
    protected $connection ='registrar_gadtc';

    protected $primaryKey = 'SchedCode';

    //this table will change according to semester
    protected $table = 'tblsched202';


    // protected $fillable = ['schedule_code', 'program_id',
    // 'institute', 'course_code', 'time_start', 'time_end', 'sched_day', 'room'];

    protected $date = ['SchedTimeFrm', 'SchedTimeTo'];


    public function faculty()
    {
        return $this->hasOne('App\Faculty', 'InsCode', 'InsCode');
    }

    public function course()
    {
        return $this->hasOne('App\Course', 'SubjCode', 'SchedSubjCode');
    }

    // public function comments()
    // {
    //     return $this->hasMany('App\RatingComment', 'schedule_code', 'SchedCode');
    // }




    // public function schedules()
    // {
    //     return $this->belongsTo('App\Enrolee', 'schedule_id', 'schedule_id');
    // }


}
