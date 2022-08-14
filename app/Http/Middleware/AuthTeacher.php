<?php

namespace App\Http\Middleware;

use Closure;

class AuthTeacher
{
    public function handle($request, Closure $next)
    {
        if (!tGuard()->check()) {
            return redirect()->route('t.login');
        }
        return $next($request);
    }
}
