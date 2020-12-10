<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    //

    protected $fillable = ['criterion', 'order_no', 'category_id', 'ay_id'];

    public $timestamps = false;

    protected $table = 'criteria';

    protected $primaryKey = 'criterion_id';


    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'category_id');
    }
}
