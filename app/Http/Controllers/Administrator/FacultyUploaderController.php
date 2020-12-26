<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacultyUploaderController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('cpanel.faculty.facultyuploader');
    }


    public function store(Request $req){
        set_time_limit(1080);
        $arr = json_decode($req->faculty_json);

        //return $arr;

        foreach($arr as $item) { //foreach element in $arr
            \DB::table('faculties')->insertOrIgnore([
                'faculty_code' => trim($item->faculty_code),
                'lname' => trim($item->lname),
                'fname' => trim($item->fname),
                'mname' => trim($item->mname),
                'institute' => trim($item->institute),
                'status' => trim($item->status),
            ]);

        }

        return redirect()->back()
            ->with('success', "Successfully uploaded.");
    }




}
