<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AndroidLoginController extends Controller
{
    //

 
   

   public function checkLogin(Request $request){

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            //return redirect()->intended('dashboard');
            return 'login';
        }

        

      // return $username;
   }



}
