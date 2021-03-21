<?php

namespace App\Http\Controllers\Student;

use App\EnroleeCourses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Academicyear;


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

        $ay = Academicyear::where('active', 1)->first();

        $student_id = Auth::user()->StudID;
//        return EnroleeCourses::with(['schedule', 'course'])
//            ->where('EnrIDNum', $student_id)
//            ->get();

        //query from registrar_gadtc and evaluation database.
        //database must be on the same host (evaluation and registrar_gadtc)
        $data = DB::connection('registrar_gadtc')->table('tblenrdtl202 as a')
            ->join('tblsched202 as b', 'a.EnrSchedCode', 'b.SchedCode')
            ->join('tblsubject as c', 'a.EnrSubjCode', 'c.SubjCode')
            ->select('a.EnrIDNum', 'a.EnrSchedCode', 'a.EnrSubjCode', 'a.EnrSubjStats',
                'b.SchedTimeFrm', 'b.SchedTimeTo', 'b.SchedDays', 'b.SchedInsCode', 'b.SchedSubjSet',
                'c.SubjName', 'c.SubjDesc', 'c.subjClass', 'ratings.schedule_code as nSchedule_Code')
            ->leftJoin('evaluation.ratings', 'a.EnrSchedCode', 'ratings.schedule_code')
            ->where('a.EnrIDNum', $student_id)
            ->where('b.SchedSubjSet', $set->set)
            ->get();

            // DB::table('ratings')
            //     ->where('ratings.student_id', $student_id)
            //     ->where('ratings.ay_code', $ay->ay_code)


        return $data;
    }

}
