<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;



class LoginController extends Controller
{
    //

	use AuthenticatesUsers;

	// public function __construct(){
	// 	$this->middleware('guest');
	// }

	// protected $redirectTo = '/';


	public function index(){

		if(Auth::check()){
			$role = Auth::user()->role;
			if($role == "ADMINISTRATOR"){
				return redirect()->intended('cpanel-home');
			}

			if($role == "STUDENT"){
				return redirect()->intended('home');
			}
		}
		return view('student/home');
	}


	public function auth(Request $req){


        //check if this student already login....
        //user cannot rate after logout...
//        $login = \DB::table('users')
//            ->where('student_id', $req->username)
//            ->where('is_login', 1)
//            ->count();
//
//	    if($login > 0){
//	        //already rated
//            return redirect('/')
//                ->with('notallowed','You already rated courses. Unable to login.');
//        }

		$credentials = $req->only('username', 'password');
		//return $credentials;

        if (Auth::attempt($credentials)) {
            // Authentication passed...

            $role = Auth::user()->role;
			if($role == "ADMINISTRATOR"){
				return redirect()->intended('cpanel-home');
			}

			if($role == "STUDENT"){
				return redirect()->intended('home');
			}

        }else{
			 return redirect('/')
			 ->with('pwderror','Username and password error!');
		}
    }



}
