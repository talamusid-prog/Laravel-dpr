<?php

namespace App\Http\Middleware;

use App\Models\Aspiration;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareAspirationStats
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only share stats for admin routes
        if ($request->is('admin*')) {
            $aspirationStats = [
                'new' => Aspiration::where('status', 'baru')->count(),
                'processing' => Aspiration::where('status', 'diproses')->count(),
                'completed' => Aspiration::where('status', 'selesai')->count(),
                'total' => Aspiration::count(),
            ];

            Inertia::share('aspirationStats', $aspirationStats);
        }

        return $next($request);
    }
}
