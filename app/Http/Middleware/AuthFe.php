<?php

namespace App\Http\Middleware;

use Closure;

class AuthFe
{
    public function handle($request, Closure $next)
    {
        if (!feGuard()->check()) {
            return redirect()->route('get.login');
        }
        return $next($request);
    }
}
