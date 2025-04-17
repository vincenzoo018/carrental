<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role_id !== 2) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
