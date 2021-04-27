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
        $this->middleware('auth:admin');
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
                'student_id' => trim($item->username),
                'username' => trim($item->username),
                'lname' => trim($item->lname),
                'fname' => trim($item->fname),
                'mname' => trim($item->mname),
                'sex' => trim($item->sex),
                'email' => trim($item->email),
                'password' => Hash::make($item->password),
                'yearlevel' => trim($item->year_level),
                'role' => trim($item->role)
            ]);
        }

        return redirect()->back()
        ->with('success', 'Successfully uploaded');
    }
}
