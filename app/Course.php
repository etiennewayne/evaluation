<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //

    protected $connection ='registrar_gadtc';

    protected $primaryKey = 'SubjCode';

    protected $table = 'tblsubject';

    public $timestamps = 'false';

    //protected $fillable = ['course_code', 'course_name', 'course_desc', 'course_class', 'unit'];



}
