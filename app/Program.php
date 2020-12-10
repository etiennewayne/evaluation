<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //


    protected $fillable = ['program_code', 'program_desc', 'institute_id'];


    protected $primaryKey = 'program_id';

    public function position(){
        return $this->hasOne('App\Institute');
    }


}
