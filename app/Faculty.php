<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    //

    protected $connection = 'registrar_gadtc';
    protected $table = 'tblins';


    //protected $fillable = ['faculty_code','lname', 'fname', 'mname', 'institute'];

    public $timestamps = false;

    protected $primaryKey = 'InsCode';

    protected $keyType = 'string';


    protected $hidden = [
        'password', 'remember_token', 'GSIS', 'PAGIBIGNo', 'PHILHEALTHNo', 'SSSNo', 'TIN'
    ];

    public function schedules()
    {
        return $this->hasMany('App\Schedule', 'SchedInsCode', 'InsCode');
    }


    //The first argument passed to the hasOneThrough method is the name of the final model
    // we wish to access, while the second argument is the name of the intermediate model (Schedule).
    //Using hasOneThrough if no direct relationship from Faculty to Course,
    //But we can use Schedule to connect them
//    public function course(){
//        return $this->hasOneThrough('App\Course', 'App\Schedule',
//            'faculty_code', //Foreign key of Schedule table (intermediate)
//            'course_code', // Foreign key of Course Table (final table)
//            'schedule_code', // key for this Model (Faculty)
//            'schedule_code' //key related to this model to intermediate Model (Schedule)
//        );
//    }



}
