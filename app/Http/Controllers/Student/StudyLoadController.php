<?php

namespace App\Http\Controllers\Student;

use App\Category;
use App\Criteria;
use App\Enrolee;
use App\EnroleeCourses;
use App\RatingComment;
use App\Schedule;
use App\Rating;
use App\RatingRate;
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
		//get active AY
		$ay = AcademicYear::where('active', 1)->first();

		//get the courses of the user
		$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $student_id));


		// $count = DB::table('enrolee_courses as a')
		// 	->join('schedules as b', 'a.schedule_code', 'b.schedule_code')
		// 	->where('set_no', 0)
		// 	->where('set_no', 2)
		// 	->where('student_id', $student_id)
		// 	->count();



		$enroleeCourses = EnroleeCourses::orderBy('enrolee_course_id', 'asc')
            ->where('student_id', $student_id)
            ->get();

		//count the courses of a specific student
		//join with the schedules table to access the set no of the course.
        $countCourses = $count = DB::table('enrolee_courses as a')
			->join('schedules as b', 'a.schedule_code', 'b.schedule_code')
			->whereIn('set_no', [2, 0])
			->where('student_id', $student_id)
			->count();

        //return $countCourses;


		//count rated course of the student by set no
		$countRated = DB::table('ratings as a')
			->where('ay_id', $ay->ay_id)
			->where('student_id', $student_id)
            ->distinct('schedule_code')
            ->count();



        if(!isset($countCourses)){
            $countCourses = 0;
		}

        if(!isset($countRated)){
            $countRated = 0;
		}


		//get the user information to display in the studyload page
		$user = DB::table('users')
			->leftJoin('enrolees', 'users.student_id', 'enrolees.student_id')
            ->where('enrolees.student_id', $student_id)
			->first();
		//please add filter if ever no course makuha ang query dere--->

		return view('student.cor')
		    //->with('count', $count)
            ->with('user', $user)
		    ->with('enroleeCourses' , $enroleeCourses)
            ->with('countcourse', $countCourses)
            ->with('countrated', $countRated)
		    ->with('ay', $ay)
			->with('coursesNoRate', $coursesNoRate);

        //return $countRated;
	}


	public function rate($sched_code){

		//if server allow the rate...
        //update to if specific schedule is allow rating
		$allowrate = DB::table('allow_rate')
		    ->where('allow_rate', 1)->count();

		$scheduleAllowRate = DB::table('schedules')
            ->where('schedule_code', $sched_code)
            ->where('allow_rate', 1)->count();


		if($allowrate < 1 && $scheduleAllowRate < 1){
			return redirect('/cor')
			->with('error', 'Rating is now allowed this time.');
		}

		//if server allow the rate ....

		$ay = AcademicYear::where('active', 1)->first();
		$student_id = Auth::user()->student_id;

		$count = DB::table('enrolee_courses')
		->where('schedule_code', $sched_code)
		->where('student_id', $student_id)->count();


		$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $student_id));


		$criteria = Criteria::where('ay_id', $ay->ay_id)->get();
		//get all criteria by academic year

		if($count > 0){

			$categories = Category::with(['criteria'])
			->where('ay_id', $ay->ay_id)->get();


			//$schedule = Schedule::where('schedule_code', $sched_code)->first();
            $schedule = DB::table('schedules as a')
                ->join('faculties as b', 'a.faculty_code', 'b.faculty_code')
                ->join('courses as c', 'a.course_code', 'c.course_code')
                ->where('a.schedule_code', $sched_code)
                ->first();


            if($schedule){
                //if schedule has a faculty assigned
                return view('student/rate')
                    ->with('categories', $categories)
                    ->with('schedule', $schedule)
                    ->with('ay', $ay)
                    ->with('criteria', $criteria)
                    ->with('coursesNoRate', $coursesNoRate);
            }else{
                //if no faculty found. redirect not rated page.
                return view('errors.cantrate');
            }

			//return $schedule->course;
			//return $categories;


		}else{

			$enrolees = EnroleeCourses::orderBy('enrolee_course_id', 'asc')
			->where('student_id', $student_id)
			->get();

			return redirect('/cor')
			->with('enrolees' , $enrolees)
			->with('error', 'Your not allowed to rate this subject.')
			->with('ay', $ay);
		}

    }


	public function save(Request $req){

		$student_id = Auth::user()->student_id;
		$ay = AcademicYear::where('active', 1)->first();

		//return $student_id;

		//$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $user_id));

		 $count = DB::table('ratings')
		 ->where('schedule_code', $req->schedule_code)
		 ->where('student_id', $student_id)->count();

		 if($count > 0){

		 	return redirect()->back()
		 	//->with('enrolees' , $enrolees)
		 	->with('warning', 'You are not allowed to evaluate twice.')
		 	->with('ay', $ay);
		 }


		 try{

			DB::transaction(function () use($req, $student_id, $ay)  {

				//insert rating in ratings table
				$rating = Rating::create([
					'student_id' => $student_id,
					'schedule_code' => $req->schedule_code,
					'remark' => $req->remark,
					'ay_id' => $ay->ay_id
				]);
			   //------------------------------

			   //create array for ratings
			   $dataArray = array();
			   foreach ($req->rate as $key => $rate){
					   $temp = array([
					   'rating_id' => $rating->rating_id,
					   'student_id' => $student_id,
					   'criterion_id' => $key,
					   'schedule_code' => $req->schedule_code,
					   'rate' => $rate
				   ]);
				   $dataArray = array_merge($dataArray, $temp);
			   }

            //save ratings in RatingRate Table in Database
            $ratingRate = RatingRate::insert($dataArray);




			}); //<--close DB Transaction

             return redirect('/cor')
                 ->with('success', 'Ratings submitted successfully.');


		 }catch(\Exception $e){
			return $e->getMessage();
		 }

	}



	public function isRated($sched_id){

		$user_id = Auth::user()->user_id;

		$count = DB::table('enrolees')
		->where('schedule_id', $sched_id)
		->where('user_id', $user_id)->count();

		return $count;
	}



}
