<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    //
    protected $table = 'ay';
    protected $connection = 'mysql';
    
    protected $primaryKey = 'ay_id';

    public $timestamps = false;

    protected  $fillable = [
        'ay_code', 'ay_desc'
    ];


}
