<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is not authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to access this page');
        }

        // Check if user is authenticated but email is not verified
        if (Auth::user()->email_verified_at === null) {
            Auth::logout();
            return redirect('/login')->with('error', 'Please verify your email address');
        }

        // Prevent back button cache after logout
        $response = $next($request);
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}