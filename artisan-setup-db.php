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
    echo "Database directory created.\n";
}

// Buat file database SQLite jika belum ada
$databaseFile = $databaseDir . '/database.sqlite';
if (!file_exists($databaseFile)) {
    touch($databaseFile);
    chmod($databaseFile, 0664);
    echo "Database file created: {$databaseFile}\n";
} else {
    echo "Database file already exists.\n";
}

// Set permission yang tepat
chmod($databaseDir, 0755);
chmod($databaseFile, 0664);

echo "Database setup completed!\n";
echo "You can now run: php artisan migrate\n";
