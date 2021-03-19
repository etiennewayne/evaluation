<?php

namespace App\Http\Controllers\Student;

use App\EnroleeCourses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('student');
    }


    public function index(){
        //return Auth::user()->StudID;
        return view('student.schedule');
    }









    //AJAX
    public function ajaxSchedule(){
        $set = DB::connection('mysql')->table('sets')
            ->where('active', 1)->first();

        $student_id = Auth::user()->StudID;
//        return EnroleeCourses::with(['schedule', 'course'])
//            ->where('EnrIDNum', $student_id)
//            ->get();
        $data = DB::connection('registrar_gadtc')->table('tblenrdtl202 as a')
            ->join('tblsched202 as b', 'a.EnrSchedCode', 'b.SchedCode')
            ->join('tblsubject as c', 'a.EnrSubjCode', 'c.SubjCode')
            ->select('a.EnrIDNum', 'a.EnrSchedCode', 'a.EnrSubjCode', 'a.EnrSubjStats',
                'b.SchedTimeFrm', 'b.SchedTimeTo', 'b.SchedDays', 'b.SchedInsCode', 'b.SchedSubjSet',
                'c.SubjName', 'c.SubjDesc', 'c.subjClass')
            ->where('a.EnrIDNum', $student_id)
            ->where('b.SchedSubjSet', $set->set)
            ->get();
        return $data;
    }

}
