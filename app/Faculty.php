<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    //

    protected $fillable = ['lname', 'fname', 'mname', 'institute_id'];

    public $timestamps = false;

    protected $primaryKey = 'faculty_id';

    protected $table = 'faculties';



}
