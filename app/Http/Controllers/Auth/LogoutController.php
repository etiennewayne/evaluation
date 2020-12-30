<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //


    public function logout(Request $req){

        $student_id = Auth::user()->student_id;

        return $student_id;

        \DB::table('users')
            ->where('student_id', $student_id)
            ->update(['is_login', 1]);


        Auth::logout();
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //return $this->loggedOut($request) ?: redirect('/');

        return redirect('/');
    }

}
