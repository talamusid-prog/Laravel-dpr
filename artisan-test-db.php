<?php

/**
 * Script untuk test database connection
 * Jalankan dengan: php artisan-test-db.php
 */

echo "Testing database connection...\n";

try {
    // Load Laravel environment
    require_once __DIR__ . '/vendor/autoload.php';
    
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    // Test database connection
    $connection = DB::connection();
    $pdo = $connection->getPdo();
    
    echo "✅ Database connection successful!\n";
    echo "✅ Driver: " . $connection->getDriverName() . "\n";
    echo "✅ Database: " . $connection->getDatabaseName() . "\n";
    
    // Test query
    $result = DB::select('SELECT 1 as test');
    echo "✅ Test query successful: " . $result[0]->test . "\n";
    
    // Check if tables exist
    $tables = DB::select("SHOW TABLES");
    echo "✅ Tables found: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        echo "📋 Existing tables:\n";
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo "   - {$tableName}\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed!\n";
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "1. Check environment variables\n";
    echo "2. Verify database credentials\n";
    echo "3. Ensure database server is running\n";
    exit(1);
}

echo "\nDatabase connection test completed successfully!\n";
