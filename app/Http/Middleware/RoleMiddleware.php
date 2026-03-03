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

        if (Auth::user()->role->name !== $role) {
            // abort(403, 'Unauthorized Access');

            //or return to home page
            return redirect()->route('home')->with('error', 'Unauthorized Access');


        }

        if ($role === 'employer' && Auth::user()->isSuspended()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Your employer account is suspended. Contact support.');
        }

        return $next($request);
    }
}
