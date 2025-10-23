<?php

/**
 * Script untuk setup environment dan database
 * Jalankan dengan: php scripts/setup-env.php
 */

echo "🔧 Setting up environment and database...\n";

// Buat file .env jika belum ada
$envFile = __DIR__ . '/../.env';
$envExampleFile = __DIR__ . '/../.env.example';

if (!file_exists($envFile)) {
    echo "📝 Creating .env file...\n";
    
    $envContent = 'APP_NAME="Dr. Ir. H. AGUS AMBO DJIWA, M.P."
APP_ENV=production
APP_KEY=base64:ObZwuispQlqu8/Tt2aVSF5o67x2q6EnDOTTxE3m1Cyk=
APP_DEBUG=false
APP_URL=https://agus-ambo-djiwa.zeabur.app

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Database Configuration - SQLite untuk production
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Force HTTPS
FORCE_HTTPS=true';

    file_put_contents($envFile, $envContent);
    echo "✅ .env file created successfully!\n";
} else {
    echo "✅ .env file already exists!\n";
}

// Buat direktori database jika belum ada
$databaseDir = __DIR__ . '/../database';
if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0755, true);
    echo "📁 Database directory created: {$databaseDir}\n";
} else {
    echo "✅ Database directory already exists: {$databaseDir}\n";
}

// Buat file database SQLite jika belum ada
$databaseFile = $databaseDir . '/database.sqlite';
if (!file_exists($databaseFile)) {
    touch($databaseFile);
    chmod($databaseFile, 0664);
    echo "🗄️  Database file created: {$databaseFile}\n";
} else {
    echo "✅ Database file already exists: {$databaseFile}\n";
}

// Set permission yang tepat
chmod($databaseDir, 0755);
if (file_exists($databaseFile)) {
    chmod($databaseFile, 0664);
}

// Verifikasi file database
if (file_exists($databaseFile)) {
    echo "✅ Database file verified: {$databaseFile}\n";
    echo "✅ File size: " . filesize($databaseFile) . " bytes\n";
    echo "✅ Permissions: " . substr(sprintf('%o', fileperms($databaseFile)), -4) . "\n";
} else {
    echo "❌ Database file creation failed!\n";
    exit(1);
}

echo "\n🎉 Environment setup completed!\n";
echo "\nNext steps:\n";
echo "1. Run: php artisan migrate\n";
echo "2. Run: php artisan db:seed\n";
echo "3. Run: php artisan config:clear\n";
echo "4. Run: php artisan cache:clear\n";
