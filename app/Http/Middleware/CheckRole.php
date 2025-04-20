<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if the user has the required role
        if (Auth::user()->hasRole($role)) {
            return $next($request);
        }

        // Redirect if the user doesn't have the role
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }
}
