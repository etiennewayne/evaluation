<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\AcademicYear;

class ViewRatingController extends Controller
{
    //


	public function __construct()
	{
		$this->middleware('student');
	}


	public function viewRating($sched_id){
		$user_id = Auth::user()->user_id;
		$ay = AcademicYear::where('active', 1)->first();

		$data = DB::select('call proc_viewrating_perstudent(?, ?)',array($user_id, $sched_id));
		$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $user_id));

		return view('student/viewrating')
		->with('coursesNoRate', $coursesNoRate)
		->with('data',$data)
		->with('ay', $ay);
	}


	

}
