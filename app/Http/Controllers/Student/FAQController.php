<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\AcademicYear;
use Illuminate\Support\Facades\DB;


class FAQController extends Controller
{
    //


    public function index(){
		
		if(Auth::check()){
			$user_id = Auth::user()->user_id;
			$ay = AcademicYear::where('active', 1)->first();
			$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $user_id));
			
			return view('student/faq')
			->with('coursesNoRate', $coursesNoRate);
		}else{
			return view('student/faq');
		}
		
    }


}
