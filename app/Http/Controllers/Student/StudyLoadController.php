<?php

namespace App\Http\Controllers\Student;

use App\Category;
use App\Criteria;
use App\Enrolee;
use App\EnroleeCourses;
use App\RatingComment;
use App\Schedule;
use App\Rating;
use App\AcademicYear;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\DB;

class StudyLoadController extends Controller
{
    //

	public function __construct()
	{
		$this->middleware('student');
	}



	public function index(){

		$student_id = Auth::user()->student_id;
		$ay = AcademicYear::where('active', 1)->first();
		$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $student_id));

		return view('student/home');

	}


	public function studyload(){
		$student_id = Auth::user()->student_id;
		$ay = AcademicYear::where('active', 1)->first();

		$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $student_id));

		$count = DB::table('enrolee_courses')
		    ->where('student_id', $student_id)->count();

		$enroleeCourses = EnroleeCourses::orderBy('enrolee_course_id', 'asc')
            ->where('student_id', $student_id)
            ->get();


        $countCourses = EnroleeCourses::where('student_id', $student_id)
            ->count();

        $countRated = Rating::where('student_id', $student_id)
            ->distinct('schedule_code')
            ->count();

        if(!isset($countCourses)){
            $countCourses = 0;
        }
        if(!isset($countRated)){
            $countRated = 0;
        }

		$user = DB::table('users')
			->leftJoin('enrolees', 'users.student_id', 'enrolees.student_id')
            ->where('enrolees.student_id', $student_id)
            ->first();

		return view('student.studyload')
		    ->with('count', $count)
            ->with('user', $user)
		    ->with('enroleeCourses' , $enroleeCourses)
            ->with('countcourse', $countCourses)
            ->with('countrated', $countRated)
		    ->with('ay', $ay)
			->with('coursesNoRate', $coursesNoRate);

        //return $countRated;
	}


	public function rate($sched_code){

		$allowrate = DB::table('allow_rate')
		    ->where('allow_rate', 1)->count();

		if($allowrate < 1){
			return redirect('/studyload')
			->with('error', 'Rating is now allowed this time.');
		}

		$student_id = Auth::user()->student_id;

		$count = DB::table('enrolee_courses')
		->where('schedule_code', $sched_code)
		->where('student_id', $student_id)->count();



		$ay = AcademicYear::where('active', 1)->first();

		$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $student_id));

		$criteria = Criteria::where('ay_id', $ay->ay_id)->get();
		//get all criteria by academic year

		if($count > 0){

			$categories = Category::orderBy('order_no', 'asc');

			dd($categories);


            return $categories->criteria;
			$schedule = Schedule::where('schedule_code', $sched_code)->get();

			//return $schedule;

			return view('student/rate')
				->with('categories', $categories)
				->with('schedule', $schedule)
				->with('ay', $ay)
				->with('criteria', $criteria)
				->with('coursesNoRate', $coursesNoRate);
		}else{

			$enrolees = EnroleeCourses::orderBy('enrolee_course_id', 'asc')
			->where('student_id', $student_id)
			->get();

			return redirect('/studyload')
			->with('enrolees' , $enrolees)
			->with('error', 'Your not allowed to rate this subject.')
			->with('ay', $ay);
		}

    }


	public function save(Request $req){

		$user_id = Auth::user()->user_id;
		$ay = AcademicYear::where('active', 1)->first();

		//$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $user_id));

		 $count = DB::table('ratings')
		 ->where('schedule_id', $req->sched_id)
		 ->where('user_id', $user_id)->count();

		 if($count > 0){

		 	return redirect('/studyload')
		 	//->with('enrolees' , $enrolees)
		 	->with('warning', 'You are not allowed to evaluate twice.')
		 	->with('ay', $ay);
		 }


		$dataArray = array();
		$commentArray = array();
		//create array for ratings
		 foreach ($req->rate as $key => $rate){
		 	//echo $key . '<br>';

		 	$temp = array([
		 		'user_id' => $user_id,
		 		'criterion_id' => $key,
		 		'schedule_id' => $req->sched_id,
		 		'rate' => $rate
		 	]);

		 	$dataArray = array_merge($dataArray, $temp);
		 }

		//crete array for comments
		foreach ($req->comment as $key => $data){
			$temp = array([
				'user_id' => $user_id,
				'category_id' => $key,
				'schedule_id' => $req->sched_id,
				'user_remark' => $data['remark'],

			]);

			$commentArray = array_merge($commentArray, $temp);

		}


		Rating::insert($dataArray);
		RatingComment::insert($commentArray);

		 return redirect('/studyload')
		 	->with('success', 'Ratings submitted successfully.');
	}



	public function isRated($sched_id){

		$user_id = Auth::user()->user_id;

		$count = DB::table('enrolees')
		->where('schedule_id', $sched_id)
		->where('user_id', $user_id)->count();

		return $count;
	}



}
