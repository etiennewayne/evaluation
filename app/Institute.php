<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    //

    protected  $fillable = ['institute_code', 'institute_desc'];


    public $timestamps = false;


    protected $primaryKey = 'insitute_id';



}
