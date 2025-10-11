<?php

/**
 * Script untuk setup database SQLite di production
 * Jalankan dengan: php artisan-setup-db.php
 */

echo "Setting up database...\n";

// Buat direktori database jika belum ada
$databaseDir = __DIR__ . '/database';
if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0755, true);
    echo "Database directory created: {$databaseDir}\n";
} else {
    echo "Database directory already exists: {$databaseDir}\n";
}

// Buat file database SQLite jika belum ada
$databaseFile = $databaseDir . '/database.sqlite';
if (!file_exists($databaseFile)) {
    touch($databaseFile);
    chmod($databaseFile, 0664);
    echo "Database file created: {$databaseFile}\n";
} else {
    echo "Database file already exists: {$databaseFile}\n";
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

echo "\nDatabase setup completed!\n";
echo "Next steps:\n";
echo "1. Run: php artisan migrate\n";
echo "2. Run: php artisan db:seed\n";
