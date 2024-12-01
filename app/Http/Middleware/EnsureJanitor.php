<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureJanitor
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'janitor') {
            return $next($request);
        }
        
        return redirect()->route('loginForm')->with('error', 'Access denied.');
    }
}
