<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserUploaderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        return view('cpanel.user.useruploader');
    }

    public function store(Request $req){

        set_time_limit(1080);
        $arr = json_decode($req->user_json);

        //return $arr;

        foreach($arr as $item) { //foreach element in $arr
            \DB::table('users')->insertOrIgnore([
                'student_id' => $item->username,
                'username' => $item->username,
                'lname' => $item->lname,
                'fname' => $item->fname,
                'mname' => $item->mname,
                'sex' => $item->sex,
                'email' => $item->email,
                'password' => Hash::make($item->password),
                'program_id' => $item->program_id,
                'yearlevel' => $item->year_level,
                'position_id' => $item->position_id
            ]);


        }

        return redirect()->back();
    }
}
