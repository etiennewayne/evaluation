<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnroleeCoursesUploaderController extends Controller
{
    //

    public function __construct()
    {
        $$this->middleware('auth:admin');
    }


    public function index(){
        return view('cpanel.enrolee.enrolee-courses-uploader');
    }

    public function store(Request $req){

       
        set_time_limit(5000);
        $arr = json_decode($req->enrolee_json);

        //return $arr;

        //return $arr;

        foreach($arr as $item) { //foreach element in $arr
            \DB::table('enrolees_courses')->insert([
                'student_id' => $item->student_id,
                'schedule_code' => $item->schedule_code,
                'course_code' => $item->course_code,
                'course_status' => $item->course_status,
            ]);
        }

        return redirect()->back()
        ->with('success', 'Successfully uploaded.');
    }

     
}
