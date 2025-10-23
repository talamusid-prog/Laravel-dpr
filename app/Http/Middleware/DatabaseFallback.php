<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class DatabaseFallback
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Test database connection
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            // If database connection fails, switch to SQLite
            if (Config::get('database.default') === 'mysql') {
                Config::set('database.default', 'sqlite');
                Config::set('database.connections.sqlite.database', database_path('database.sqlite'));
                
                // Create SQLite database if not exists
                $databaseFile = database_path('database.sqlite');
                if (!file_exists($databaseFile)) {
                    touch($databaseFile);
                    chmod($databaseFile, 0664);
                }
                
                // Clear config cache
                try {
                    \Artisan::call('config:clear');
                } catch (\Exception $artisanError) {
                    // Ignore artisan errors
                }
            }
        }

        return $next($request);
    }
}
