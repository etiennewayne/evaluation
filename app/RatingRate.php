<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingRate extends Model
{
    //


    protected $fillable = ['rating_id','student_id','criterion_id', 'schedule_code', 'rate'];

    public $timestamps = false;

    protected $primaryKey = 'ratingrate_id';

    protected $table = 'ratings_rate';


}
