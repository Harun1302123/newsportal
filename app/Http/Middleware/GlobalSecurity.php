<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GlobalSecurity
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->auth_token_allow == 1 and Auth::user()->auth_token != '') {
            Auth::logout();
            Session::flush();
            Session::flash('error', "2nd Step verification not match properly. Please login again.");
            return redirect('login');
        }

        return $next($request);
    }
}
