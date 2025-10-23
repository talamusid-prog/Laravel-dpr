# Script PowerShell untuk deployment ke Zeabur
Write-Host "🚀 Deploying to Zeabur..." -ForegroundColor Green

# 1. Build assets
Write-Host "🔨 Building assets..." -ForegroundColor Yellow
npm run build

# 2. Setup database
Write-Host "🗄️  Setting up database..." -ForegroundColor Blue
php scripts/zeabur-db-setup.php

# 3. Clear all caches
Write-Host "🧹 Clearing caches..." -ForegroundColor Cyan
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 4. Set permissions
Write-Host "🔐 Setting permissions..." -ForegroundColor Magenta
if (Test-Path "storage") {
    Get-ChildItem -Path "storage" -Recurse | ForEach-Object { $_.Attributes = "Normal" }
}
if (Test-Path "bootstrap/cache") {
    Get-ChildItem -Path "bootstrap/cache" -Recurse | ForEach-Object { $_.Attributes = "Normal" }
}

# 5. Create necessary directories
Write-Host "📁 Creating directories..." -ForegroundColor White
$directories = @("storage/logs", "storage/framework/cache", "storage/framework/sessions", "storage/framework/views", "bootstrap/cache")
foreach ($dir in $directories) {
    if (!(Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force
        Write-Host "   Created: $dir" -ForegroundColor Gray
    }
}

# 6. Test application
Write-Host "🧪 Testing application..." -ForegroundColor Green
try {
    php artisan route:list | Select-Object -First 5
    Write-Host "✅ Application test successful!" -ForegroundColor Green
} catch {
    Write-Host "❌ Application test failed!" -ForegroundColor Red
}

Write-Host "🎉 Deployment completed!" -ForegroundColor Green
Write-Host "📋 Next steps:" -ForegroundColor White
Write-Host "1. Upload all files to Zeabur" -ForegroundColor Gray
Write-Host "2. Run: php scripts/zeabur-db-setup.php" -ForegroundColor Gray
Write-Host "3. Check application logs" -ForegroundColor Gray
