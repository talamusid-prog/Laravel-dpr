<?php

/**
 * Script untuk setup database di Zeabur
 * Otomatis fallback ke SQLite jika MySQL tidak tersedia
 */

echo "🚀 Setting up database for Zeabur...\n";

// Load Laravel environment
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    // Test MySQL connection first
    echo "📡 Testing MySQL connection...\n";
    
    try {
        $mysqlConnection = DB::connection('mysql');
        $pdo = $mysqlConnection->getPdo();
        
        echo "✅ MySQL connection successful!\n";
        echo "✅ Database: " . $mysqlConnection->getDatabaseName() . "\n";
        
        // Test query
        $result = DB::select('SELECT 1 as test');
        echo "✅ MySQL test query successful!\n";
        
        // Run migrations if needed
        echo "🔄 Running migrations...\n";
        Artisan::call('migrate', ['--force' => true]);
        echo "✅ Migrations completed!\n";
        
        // Run seeders
        echo "🌱 Running seeders...\n";
        Artisan::call('db:seed', ['--force' => true]);
        echo "✅ Seeders completed!\n";
        
    } catch (Exception $mysqlError) {
        echo "❌ MySQL connection failed: " . $mysqlError->getMessage() . "\n";
        echo "🔄 Switching to SQLite fallback...\n";
        
        // Update .env to use SQLite
        $envFile = __DIR__ . '/../.env';
        $envContent = file_get_contents($envFile);
        
        // Replace MySQL config with SQLite
        $envContent = preg_replace('/^DB_CONNECTION=mysql$/m', 'DB_CONNECTION=sqlite', $envContent);
        $envContent = preg_replace('/^DB_DATABASE=.*$/m', 'DB_DATABASE=database/database.sqlite', $envContent);
        $envContent = preg_replace('/^DB_HOST=.*$/m', '# DB_HOST=127.0.0.1', $envContent);
        $envContent = preg_replace('/^DB_PORT=.*$/m', '# DB_PORT=3306', $envContent);
        $envContent = preg_replace('/^DB_USERNAME=.*$/m', '# DB_USERNAME=root', $envContent);
        $envContent = preg_replace('/^DB_PASSWORD=.*$/m', '# DB_PASSWORD=root', $envContent);
        
        file_put_contents($envFile, $envContent);
        echo "✅ Updated .env to use SQLite\n";
        
        // Create SQLite database
        $databaseDir = __DIR__ . '/../database';
        if (!is_dir($databaseDir)) {
            mkdir($databaseDir, 0755, true);
            echo "📁 Created database directory\n";
        }
        
        $databaseFile = $databaseDir . '/database.sqlite';
        if (!file_exists($databaseFile)) {
            touch($databaseFile);
            chmod($databaseFile, 0664);
            echo "🗄️  Created SQLite database file\n";
        }
        
        // Clear config cache
        Artisan::call('config:clear');
        echo "🧹 Cleared config cache\n";
        
        // Test SQLite connection
        $sqliteConnection = DB::connection('sqlite');
        $pdo = $sqliteConnection->getPdo();
        
        echo "✅ SQLite connection successful!\n";
        echo "✅ Database: " . $sqliteConnection->getDatabaseName() . "\n";
        
        // Run migrations
        echo "🔄 Running migrations...\n";
        Artisan::call('migrate', ['--force' => true]);
        echo "✅ Migrations completed!\n";
        
        // Run seeders
        echo "🌱 Running seeders...\n";
        Artisan::call('db:seed', ['--force' => true]);
        echo "✅ Seeders completed!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Setup failed: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "1. Check if database service is running\n";
    echo "2. Verify database credentials\n";
    echo "3. Check network connectivity\n";
    exit(1);
}

echo "\n🎉 Database setup completed successfully!\n";
echo "✅ Application is ready to run on Zeabur!\n";
