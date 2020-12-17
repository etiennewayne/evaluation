<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CourseController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        return view('cpanel.course.course-uploader');
    }

    public function store(Request $req){

        set_time_limit(1080);
        $arr = json_decode($req->course_json);

        //return $arr;

        foreach($arr as $item) { //foreach element in $arr
            \DB::table('courses')->insertOrIgnore([
                'course_code' => $item->course_code,
                'course_name' => $item->course_name,
                'course_desc' => $item->course_desc,
                'course_class' => $item->course_class,
                'unit' => $item->unit,
            ]);

        }

        return redirect()->back()
            ->with('success', "Successfully uploaded.");
    }


}
