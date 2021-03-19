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

        $role = strtolower(Auth::user()->role);
        if($role != 'administrator'){
            abort(403);
            //no cache so user cant use prev button in browser
        }
        return $next($request)
        ->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
        ->header('Pragma','no-cache');

        // if($role == 'student'){
        //     return $next($request)
        //     ->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
        //     ->header('Pragma','no-cache');

        // }


    }
}
