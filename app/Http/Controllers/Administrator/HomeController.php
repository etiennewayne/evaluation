<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

	public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('auth:admin');
    }


    public function index()
    {
        return view('cpanel/cpanel-home');
    }



}
