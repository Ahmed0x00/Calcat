<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Check if admin of the app
        if (Auth::check() && Auth::user()->role === 'super admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized. Only Admin Can do This Action'], 403);
    }
}
