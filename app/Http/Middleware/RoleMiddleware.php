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

        return $next($request);
    }
}