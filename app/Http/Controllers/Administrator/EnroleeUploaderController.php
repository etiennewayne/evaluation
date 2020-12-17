<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnroleeUploaderController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        return view('cpanel.enrolee.enrolee-uploader');
    }

    public function store(Request $req){

        set_time_limit(1080);
        $arr = json_decode($req->enrolee_json);

        //return $arr;

        foreach($arr as $item) { //foreach element in $arr
            \DB::table('enrolees')->insertOrIgnore([
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
