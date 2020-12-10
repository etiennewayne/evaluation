<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class Admin
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


        if (!Auth::check()) {
            return redirect('/');
        }


        $position = strtolower(Auth::user()->positions->position);

        if($position == 'administrator'){
        return $next($request)
            ->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache');

            //no cache so user cant use prev button in browser
    }

        if($position == 'student'){
            return redirect('/home')->with('error', 'You dont\'t have admin access.');
        }

        return redirect('/');
    }
}
