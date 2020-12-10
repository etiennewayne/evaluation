<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Faculty;
use App\AcademicYear;
use App\RatingComment;
use App\Schedule;
use App\Category;


class ReportResultController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('admin');
    }


    public function index()
    {
        return view('cpanel/report/cpanel-report-faculty');

    }

    public function ajaxFaculties(){
    	return Faculty::all();
    }





    public function reportRating($f_id){

    	if(!is_numeric($f_id)){
            return redirect('/cpanel-report-faculty');
        }

        if($f_id==0){
            return redirect('/cpanel-report-faculty');
        }

        $data = DB::select('call report_faculty_rating(?)', array($f_id));


        $faculty = DB::table('faculties')
        ->where('faculty_id',$f_id)->first();

        $remarks_suggestion = Category::all();

        $noCategories = DB::table('categories')->count();

        foreach ($remarks_suggestion as $r) {

            $schedules = DB::table('schedules')
            ->select('schedule_id', 'faculty_id')
            ->where('faculty_id', $f_id)->get();

            $r->schedules = $schedules;

            foreach ($schedules as $sched) {
                $remarks = DB::table('rating_comments')
                ->select('category_id','user_remark', 'user_suggestion')
                ->where('schedule_id', $sched->schedule_id)
                ->where('category_id', $r->category_id)
                ->get();

                $sched->remarks = $remarks;
            }

        }

        $ay = AcademicYear::where('active', 1)->first();

        // $rating_comment = DB::table('rating_comments as a')
        // ->join('schedules as b', 'a.schedule_id', '=', 'b.schedule_id')
        // ->join('categories as c', 'a.category_id', '=', 'c.category_id')
        // ->where('b.faculty_id', $f_id)
        // ->get();

        return view('cpanel/report/cpanel-report-rating-total')
        ->with('data', $data)
        ->with('ay',$ay)
        ->with('faculty', $faculty)
        ->with('noCategories', $noCategories)
        ->with('remarks_suggestion', $remarks_suggestion);
    }

    public function printReportRating($f_id){

        if(!is_numeric($f_id)){
            return redirect('/cpanel-report-faculty');
        }

        if($f_id==0){
            return redirect('/cpanel-report-faculty');
        }

        $data = DB::select('call report_faculty_rating(?)', array($f_id));


        $faculty = DB::table('faculties')
        ->where('faculty_id',$f_id)->first();

        $remarks_suggestion = Category::all();

        $noCategories = DB::table('categories')->count();

        foreach ($remarks_suggestion as $r) {

            $schedules = DB::table('schedules')
            ->select('schedule_id', 'faculty_id')
            ->where('faculty_id', $f_id)->get();

            $r->schedules = $schedules;

            foreach ($schedules as $sched) {
                $remarks = DB::table('rating_comments')
                ->select('category_id','user_remark', 'user_suggestion')
                ->where('schedule_id', $sched->schedule_id)
                ->where('category_id', $r->category_id)
                ->get();

                $sched->remarks = $remarks;
            }

        }

        $ay = AcademicYear::where('active', 1)->first();


        return view('cpanel/report/print-report-rating-total')
        ->with('data', $data)
        ->with('ay',$ay)
        ->with('faculty', $faculty)
        ->with('noCategories', $noCategories)
        ->with('remarks_suggestion', $remarks_suggestion);
    }


    public function facultySchedule($faculty_id){

        $faculty = DB::table('faculties')
        ->where('faculty_id',$faculty_id)->first();

         return view('cpanel/report/faculty_schedule')
         ->with('faculty', $faculty)
         ->with('faculty_id', $faculty_id);
    }



    public function ajaxSchedules(Request $request){

        $fid = $request->query('fid');
        $schedules = DB::table('schedules as a')
        ->join('courses as b', 'a.course_id', 'b.course_id')
        ->select('a.schedule_id' , 'a.sched_code', 'a.course_id', DB::raw('time_format(a.time_start, "%h:%i %p") as time_start'), DB::raw('time_format(a.time_end, "%h:%i %p") as time_end'), 'a.sched_day', 'a.room', 'a.faculty_id', 'b.subjcode', 'b.course_code', 'b.course')
        ->where('faculty_id', $fid)
        ->get();

        return $schedules;

        //return $request->query('keyword') .  ' ' . $request->query('total');
    }

    public function facultyRate(Request $req){

        $faculty_id = $req->fid;
        $schedule_id = $req->sid;

         $faculty = DB::table('faculties')
        ->where('faculty_id',$faculty_id)->first();

        $remarks_suggestion = Category::all();
        foreach ($remarks_suggestion as $r) {

            $schedules = DB::table('schedules')
            ->select('schedule_id', 'faculty_id')
            ->where('faculty_id', $faculty_id)
            ->where('schedule_id', $schedule_id)->get();

            $r->schedules = $schedules;

            foreach ($schedules as $sched) {
                $remarks = DB::table('rating_comments as a')
                ->join('schedules as b', 'a.schedule_id', 'b.schedule_id')
                ->select('category_id','user_remark', 'user_suggestion')
                ->where('a.schedule_id', $schedule_id)
                ->where('a.category_id', $r->category_id)
                ->where('b.faculty_id', $faculty_id)
                ->get();

                $sched->remarks = $remarks;
            }

        }


        $ay = AcademicYear::where('active', 1)->first();

        $no_categories = DB::table('categories')->count();

        $data = DB::select('call report_faculty_rating_persched(?, ?)', array($faculty_id, $schedule_id));

        //return $data;

        return view('cpanel/report/faculty_rate_persched')
        ->with('faculty_id', $faculty_id)
        ->with('faculty', $faculty)
        ->with('schedule_id', $schedule_id)
        ->with('no_categories', $no_categories)
        ->with('data', $data)
        ->with('remarks_suggestion', $remarks_suggestion)
        ->with('ay', $ay);
    }
    
    public function printFacultyRate(Request $req){

        $faculty_id = $req->fid;
        $schedule_id = $req->sid;

         $faculty = DB::table('faculties')
        ->where('faculty_id',$faculty_id)->first();

        $remarks_suggestion = Category::all();
        foreach ($remarks_suggestion as $r) {

            $schedules = DB::table('schedules')
            ->select('schedule_id', 'faculty_id')
            ->where('faculty_id', $faculty_id)
            ->where('schedule_id', $schedule_id)->get();

            $r->schedules = $schedules;

            foreach ($schedules as $sched) {
                $remarks = DB::table('rating_comments as a')
                ->join('schedules as b', 'a.schedule_id', 'b.schedule_id')
                ->select('category_id','user_remark', 'user_suggestion')
                ->where('a.schedule_id', $schedule_id)
                ->where('a.category_id', $r->category_id)
                ->where('b.faculty_id', $faculty_id)
                ->get();

                $sched->remarks = $remarks;
            }

        }


        $ay = AcademicYear::where('active', 1)->first();

        $no_categories = DB::table('categories')->count();

        $data = DB::select('call report_faculty_rating_persched(?, ?)', array($faculty_id, $schedule_id));

        //return $data;

        return view('cpanel/report/print-faculty_rate_persched')
        ->with('faculty_id', $faculty_id)
        ->with('faculty', $faculty)
        ->with('schedule_id', $schedule_id)
        ->with('no_categories', $no_categories)
        ->with('data', $data)
        ->with('remarks_suggestion', $remarks_suggestion)
        ->with('ay', $ay);
    }


    public function studentSchedRated(){

        // $students = DB::table('enrolees as a')
        // ->join('users a b', 'a.user_id', 'b.user_id')
        // ->join('')

        return 'test';
    }


}
