<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Zeabur Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi khusus untuk deployment di Zeabur
    | Memastikan aplikasi dapat berjalan tanpa blokir
    |
    */

    'enabled' => env('ZEABUR_ENABLED', false),
    
    'database' => [
        'fallback_to_sqlite' => env('DB_FALLBACK_SQLITE', true),
        'timeout' => env('DB_TIMEOUT', 60),
        'retry_attempts' => env('DB_RETRY_ATTEMPTS', 3),
    ],
    
    'cors' => [
        'enabled' => true,
        'allow_all_origins' => true,
        'allow_all_methods' => true,
        'allow_all_headers' => true,
    ],
    
    'security' => [
        'disable_csrf' => env('ZEABUR_DISABLE_CSRF', false),
        'trust_all_proxies' => true,
        'disable_rate_limiting' => env('ZEABUR_DISABLE_RATE_LIMITING', false),
    ],
    
    'logging' => [
        'level' => env('LOG_LEVEL', 'debug'),
        'channels' => ['single', 'stderr'],
    ],
    
    'cache' => [
        'driver' => env('CACHE_DRIVER', 'file'),
        'disable_redis' => env('ZEABUR_DISABLE_REDIS', true),
    ],
    
    'session' => [
        'driver' => env('SESSION_DRIVER', 'file'),
        'secure' => false, // Disable untuk development
        'same_site' => 'lax',
    ],
];
