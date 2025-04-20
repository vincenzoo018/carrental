<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and has admin role
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        // If the user is not an admin, abort with an Unauthorized status
        return redirect()->route('login')->withErrors('You are not authorized to access this page.');
    }
}
