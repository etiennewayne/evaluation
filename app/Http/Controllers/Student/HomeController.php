<?php

namespace App\Http\Controllers\Student;

use App\Category;
use App\Criteria;
use App\Enrolee;
use App\RatingComment;
use App\Schedule;
use App\Rating;
use App\AcademicYear;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

	public function index(){
		
		if(Auth::check()){
			
			$student_id = Auth::user()->student_id;
			$ay = AcademicYear::where('active', 1)->first();
			$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $student_id));
			
			return view('student/home')
			->with('coursesNoRate', $coursesNoRate);
		}	
		else{
				return view('student/home');
		}

	}




}
