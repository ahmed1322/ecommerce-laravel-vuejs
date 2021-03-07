<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user()->canAccessSpecificArea( ['seller'] ), 401);

        return $next($request);
    }
}
