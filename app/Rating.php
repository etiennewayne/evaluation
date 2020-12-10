<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //

    protected $fillable = ['user_id', 'criterion_id','schedule_id', 'user_comment', 'user_suggestion'];

    public $timestamps = false;

    protected $primaryKey = 'rating_id';

    protected $table = 'ratings';


    
    // public static function isRated($user_id, $sched_id){
    // 	return $this->where('user_id', $user_id)->where('schedule_id', $sched_id)->exists();
    // }


}
