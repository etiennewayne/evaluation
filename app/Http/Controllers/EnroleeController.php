<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnroleeController extends Controller
{
    //

    public function __construct(){
        $this->middleware('admin');
    }

    
}
