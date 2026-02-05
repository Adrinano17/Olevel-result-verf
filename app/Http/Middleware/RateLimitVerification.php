<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitVerification
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'verification:' . $request->ip();
        $maxAttempts = config('services.rate_limit_per_minute', 10);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many verification attempts. Please try again later.',
            ], 429);
        }

        RateLimiter::hit($key, 60); // 60 seconds decay

        return $next($request);
    }
}




