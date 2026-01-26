<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user has sanctum token in session
        if (!$request->session()->has('sanctum_token')) {
            // Redirect to login if not authenticated
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        return $next($request);
    }
}
