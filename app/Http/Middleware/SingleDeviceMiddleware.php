<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleDeviceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->current_access_token !== $request->bearerToken()) {
            return response()->json([
                'status' => 401,
                'message' => 'You have been logged in from another device.',
                'data' => (object)[]
            ], 401);
        }

        return $next($request);
    }
}
