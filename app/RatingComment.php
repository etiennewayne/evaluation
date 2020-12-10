<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Category;



class RatingComment extends Model
{
    //

    protected $fillable = ['user_id', 'category_id', 'schedule_id', 'user_remark', 'user_suggestion'];

    public $timestamps = false;

    protected $primaryKey = 'ratingcomment_id';

    protected $table = 'rating_comments';


    public function user(){
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }

    public function categories(){
    	return $this->belongsTo('App\Category', 'category_id','category_id');
    }


    public function schedules(){
    	return $this->belongsTo('App\Schedule', 'schedule_id','schedule_id');
    }

    
}
