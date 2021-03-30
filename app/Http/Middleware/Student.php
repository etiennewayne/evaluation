<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;



class Student
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(auth()->guard('admin')){
            return redirect('/cpanel-home');
        }

        if(auth()->guard('web')){
            return redirect('/home');
        }

        return $next($request)
        ->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
        ->header('Pragma','no-cache');
        //no cache so user cant use prev button in browser

    }
}
