<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force HTTPS in production or when force_https is enabled
        if ((app()->environment('production') || config('app.force_https', false)) && !$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        // Set HTTPS headers
        $response = $next($request);
        
        // Add security headers
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Force HTTPS for all responses in production
        if (app()->environment('production') || config('app.force_https', false)) {
            $response->headers->set('Content-Security-Policy', "upgrade-insecure-requests");
        }
        
        return $response;
    }
}
