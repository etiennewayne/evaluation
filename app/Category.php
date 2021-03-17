<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $table = 'categories';

    protected $fillable = ['category', 'order_no','ay_id'];

    public $timestamps = false;

    protected $primaryKey = 'category_id';


    public function criteria()
    {
        return $this->hasMany('App\Criteria', 'category_id', 'category_id')
            ->orderBy('order_no', 'asc');
    }

    public function categories()
    {
        return $this->hasOne('App\AcademicYear', 'ay_id', 'ay_id');
    }


    public function comments(){
        return $this->hasMany('App\RatingComment', 'category_id', 'category_id');
    }




}
