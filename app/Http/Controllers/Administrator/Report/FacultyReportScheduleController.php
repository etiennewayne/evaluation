<?php

namespace App\Http\Controllers\Administrator\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacultyReportScheduleController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:admin');
    }


    public function index(Request $req){
        return view('cpanel.report.faculty-rating')
            ->with('code', $req->code)
            ->with('schedule', $req->schedule);
    }



    public function ajaxSchedule(Request $req){
        $sortkey = explode(".",$req->sort_by);
        return DB::connection('registrar_gadtc')->table('tblsched202 as a')
            ->join('tblsubject as b', 'a.SchedSubjCode', 'b.SubjCode')
            ->join('tblins as c', 'a.SchedInsCode', 'c.InsCode')
            ->where('SchedInsCode', '=', $req->code)
            ->orderBy($sortkey[0], $sortkey[1])
            ->paginate($req->perpage);
    }


}
