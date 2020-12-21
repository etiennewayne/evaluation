<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //


    protected $primaryKey = 'course_id';

    protected $table = 'courses';

    public $timestamps = 'false';

    protected $fillable = ['course_code', 'course_name', 'course_desc', 'course_class', 'unit'];



}
