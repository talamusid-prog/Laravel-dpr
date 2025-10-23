#!/bin/bash

# Script untuk rebuild assets dan deploy
echo "🔄 Memulai rebuild assets..."

# Hapus build lama
echo "🗑️  Menghapus build lama..."
rm -rf public/build/*

# Install dependencies jika diperlukan
echo "📦 Menginstall dependencies..."
npm ci

# Build assets
echo "🔨 Building assets..."
npm run build

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 public/build

echo "✅ Build selesai! Assets tersedia di public/build/"
echo "📁 File yang di-build:"
ls -la public/build/assets/ | head -10
