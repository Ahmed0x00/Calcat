<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
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
        $user = Auth::user();

        // Check if owner or admin in the company
        if ($user && $user->role === 'owner' || $user-> role === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
