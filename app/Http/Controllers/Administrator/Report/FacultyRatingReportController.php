<?php

namespace App\Http\Controllers\Administrator\Report;

use App\AcademicYear;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacultyRatingReportController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(Request $req){
        return view('cpanel.report.faculty-rating')
            ->with('code', $req->code);
    }



//    public function ajaxFaculty(Request $req){
//        $sortkey = explode(".",$req->sort_by);
//
//        return DB::connection('registrar_gadtc')->table('tblins as a')
//            ->where('InsLName', 'LIKE', $req->lastname. '%')
//            ->orderBy($sortkey[0], $sortkey[1])
//            ->paginate($req->perpage);
//    }


    public function ajaxRating(Request $req){

        $ay = AcademicYear::where('active', 1)->first();
        $code = $req->code;
        $ay_code = $ay->ay_code;

        //$data = DB::select('call report_faculty_rating_schedule(?, ?)', array($code, $ay_code));
        $data = DB::select('call report_rating_per_category(?, ?)', array($code, $ay_code));
        return $data;
    }

    public function ajaxRater(Request $req){

        $ay = AcademicYear::where('active', 1)->first();
        $code = $req->code;
        $ay_code = $ay->ay_code;
        $data = $data = DB::select('call report_faculty_rating_schedule(?, ?)', array($code, $ay_code));

        return $data;
    }

    public function ajaxSuggestion(Request $req){

        $ay = AcademicYear::where('active', 1)->first();

        $code = $req->code;
        $ay_code = $ay->ay_code;
        $data = $data = DB::select('call report_comments(?, ?)', array($code, $ay_code));

        return $data;
    }

    public function ajaxSignatory(Request $req){
        $data = DB::table('evaluation.signatories as a')
        ->get();
        return $data;
    }





}
