<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:admin');
    }


    public function index(){
        return view('cpanel.report.faculty-rating');
    }




    public function ajaxFaculty(Request $req){
        $sortkey = explode(".",$req->sort_by);

        return DB::connection('registrar_gadtc')->table('tblins as a')
            ->where('InsLName', 'LIKE', $req->lastname. '%')
            ->orderBy($sortkey[0], $sortkey[1])
            ->paginate($req->perpage);
    }
}
