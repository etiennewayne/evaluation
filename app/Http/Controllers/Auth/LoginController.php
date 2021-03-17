<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
        protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function username(){
        return 'username';
    }

//    public function redirectTo()
//    {
//        return '/cpanel-home';
//        // $user = \Auth::user();
//        // if($user->role === 'ADMINISTRATOR'){
//        //     return redirect()->intended('cpanel-home');
//        // }
//
//    //    if($user->role === 'STUDENT'){
//    //        return redirect()->intended('home');
//    //    }
//
//    //    if($user->role === 'FACULTY'){
//    //        return redirect()->intended('faculty');
//    //    }
//
//    }


}
