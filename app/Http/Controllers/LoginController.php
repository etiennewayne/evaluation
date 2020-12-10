<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


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
			$position = Auth::user()->positions->position;
			if($position == "ADMINISTRATOR"){
				return redirect()->intended('cpanel-home');
			}

			if($position == "STUDENT"){
				return redirect()->intended('home');
			}
		}
		return view('student/home');
	}


	public function auth(Request $req){

		$credentials = $req->only('username', 'password');
		//return $credentials;
        if (Auth::attempt($credentials)) {
            // Authentication passed...

			$position = Auth::user()->positions->position;

			if($position == "ADMINISTRATOR"){
				return redirect()->intended('cpanel-home');
			}

			if($position == "STUDENT"){
				return redirect()->intended('home');
			}

			//return $position;
			//return Auth::user()->positions->position;

        }else{
			 return redirect('/')
			 ->with('pwderror','Username and password error!');
		}
    }

}
