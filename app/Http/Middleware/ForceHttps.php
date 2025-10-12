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
        // Skip HTTPS redirect for certain paths to avoid loops
        $skipPaths = ['admin/login', 'admin/logout', 'up'];
        
        if (app()->environment('production') && 
            !$request->secure() && 
            !in_array($request->path(), $skipPaths) &&
            !$request->header('X-Forwarded-Proto') === 'https') {
            
            return redirect()->secure($request->getRequestUri());
        }

        $response = $next($request);
        
        // Add security headers
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        return $response;
    }
}
