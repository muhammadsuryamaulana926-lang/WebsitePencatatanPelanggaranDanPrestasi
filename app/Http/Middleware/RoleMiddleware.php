<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $level)
    {
        if (!auth()->check() || auth()->user()->level !== $level) {
            return redirect('/login');
        }

        return $next($request);
    }
}