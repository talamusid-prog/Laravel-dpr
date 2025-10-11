#!/bin/bash

# Script untuk setup database SQLite di production
echo "Setting up database..."

# Buat direktori database jika belum ada
mkdir -p database

# Buat file database SQLite jika belum ada
if [ ! -f "database/database.sqlite" ]; then
    echo "Creating database file..."
    touch database/database.sqlite
    echo "Database file created successfully!"
else
    echo "Database file already exists."
fi

# Set permission yang tepat
chmod 664 database/database.sqlite
chmod 755 database

echo "Database setup completed!"
