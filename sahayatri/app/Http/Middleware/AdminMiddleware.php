<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
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
        
        return $next($request);
        if (Auth::user()->type == 'admin'){
            return $next($request);
          } 
        return redirect()->back()->withErrors(__('Non Authorized Access.'));
    }
}
