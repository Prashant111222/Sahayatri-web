<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //checking if the logged in user is admin
        if (Auth::user() && Auth::user()->type == 'admin'){
            return $next($request);
          } 

        //displaying error and logging out for trying to access unauthorized zone

        $request->session()->flush();

        Auth::logout();

        return redirect('login')->withErrors(__('401 - Unauthorized Access!'));
    }
}
