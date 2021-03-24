<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Admin;


class LoginController extends Controller
{
    //


    protected $redirectTo = '/cpanel';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function index(){
        return view('cpanel.login');
    }

//
//    public function username()
//    {
//        return 'username';
//    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:1'
        ]);

        $credentials = $request->only('username', 'password');

        if ($this->guard('admin')->attempt(['username'=>$request->username, 'password' => $request->password])) {
            // Authentication passed...
            //return redirect()->intended('cpanel');
            return [['status' => 'login_success']];
        }
        else{
            return [['status' => 'login_error']];
        }
    }



    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }



}
