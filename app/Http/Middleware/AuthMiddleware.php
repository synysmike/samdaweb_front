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
        // Ensure session is started
        if (!$request->session()->isStarted()) {
            $request->session()->start();
        }

        // Check if user has sanctum token in session
        $token = $request->session()->get('sanctum_token');

        if (empty($token)) {
            // Return JSON response for AJAX/API requests
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' => 'Authentication token not found. Please login again.'
                ], 401);
            }

            // Redirect to login if not authenticated (for regular requests)
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        return $next($request);
    }
}
