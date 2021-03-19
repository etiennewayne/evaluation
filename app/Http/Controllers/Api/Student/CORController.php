<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use User;

class CORController extends Controller
{
    //

    public function __construct(){
        //$this->middleware('auth:api');
    }


    public function index(Request $req){
        return $req->user('web');
//        return EnroleeCourse::with(['schedule'])
//            ->where('EnrIDNum', $student_id)
//            ->get();
    }
}
