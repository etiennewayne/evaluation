<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\AcademicYear;


class AcademicYearController extends Controller
{
    //
    public function __contruct(){
        $this->middleware('auth');
    }

    public function index(Request $req){
        $sortkey = explode(".",$req->sort_by);

        return AcademicYear::orderBy($sortkey[0], $sortkey[1])
            ->paginate($req->perpage);
    }


}
