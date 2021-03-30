<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    //
    public function __construct(){
        //$this->middleware('auth');
        $this->middleware('auth:web');
    }

	public function index(){
        return view('student/home');
    }

//		if(Auth::check()){
//
//			$student_id = Auth::user()->student_id;
//			$ay = AcademicYear::where('active', 1)->first();
//			$coursesNoRate = DB::select('call proc_view_noratecourses(?, ?)', array($ay->ay_id, $student_id));
//
//			//return $coursesNoRate;
//			return view('student/home')
//			->with('coursesNoRate', $coursesNoRate);
//		}
//		else{
//
//		}






}
