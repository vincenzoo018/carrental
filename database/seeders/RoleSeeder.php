<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user's role matches required role
        if ($role == 'admin' && $user->role_id != 1) {
            abort(403, 'Unauthorized');
        }

        if ($role == 'user' && $user->role_id != 2) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
