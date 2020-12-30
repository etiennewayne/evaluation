<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class ChangePasswordController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('student');
    }

    public function index(){
        return view('auth.passwords.changepassword');
    }



    public function update(Request $req){

        $req->validate([
            'oldpassword' => ['required', new MatchOldPassword],
            'npassword' => ['required'],
            'rpassword' => ['same:npassword'],
        ],[
            'npassword.required' => 'Please input new password.',
            'rpassword.same' => 'Password not matched.'
        ]);

        $userid = Auth::user()->user_id;

        User::find($userid)->update(['password'=> Hash::make($req->npassword)]);

        return redirect('/home')
            ->with('success', 'Password changed.');
    }

}
