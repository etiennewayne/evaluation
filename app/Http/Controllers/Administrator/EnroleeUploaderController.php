<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnroleeUploaderController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index(){
        return view('cpanel.enrolee.enrolee-uploader');
    }

    public function store(Request $req){

       
        set_time_limit(5000);
        $arr = json_decode($req->enrolee_json);

        //return $arr;

        //return $arr;

        foreach($arr as $item) { //foreach element in $arr
            \DB::table('enrolees')->insert([
                'student_id' => $item->student_id,
                'program_code' => $item->program_code,
                'enr_class' => $item->enr_class,
                'enr_yearlevel' => $item->enr_yearlevel,
                'enr_units' => $item->enr_units,
                'enr_section' => $item->enr_section,
                'enr_status' => $item->enr_status,
            ]);
        }

        return redirect()->back()
        ->with('success', 'Successfully uploaded.');
    }



}
