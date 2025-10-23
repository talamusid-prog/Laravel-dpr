# Script PowerShell untuk rebuild assets dan deploy
Write-Host "🔄 Memulai rebuild assets..." -ForegroundColor Green

# Hapus build lama
Write-Host "🗑️  Menghapus build lama..." -ForegroundColor Yellow
if (Test-Path "public/build") {
    Remove-Item -Recurse -Force "public/build/*"
}

# Install dependencies jika diperlukan
Write-Host "📦 Menginstall dependencies..." -ForegroundColor Blue
npm ci

# Build assets
Write-Host "🔨 Building assets..." -ForegroundColor Cyan
npm run build

# Set permissions
Write-Host "🔐 Setting permissions..." -ForegroundColor Magenta
if (Test-Path "public/build") {
    Get-ChildItem -Path "public/build" -Recurse | ForEach-Object { $_.Attributes = "Normal" }
}

Write-Host "✅ Build selesai! Assets tersedia di public/build/" -ForegroundColor Green
Write-Host "📁 File yang di-build:" -ForegroundColor White
if (Test-Path "public/build/assets") {
    Get-ChildItem -Path "public/build/assets" | Select-Object -First 10 | Format-Table Name, Length, LastWriteTime
}
