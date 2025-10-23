# Panduan Deployment

## Masalah yang Diperbaiki

### 1. Error 404 - Asset Tidak Ditemukan
- **Penyebab**: Asset tidak di-build atau tidak tersedia di server
- **Solusi**: 
  - Pastikan menjalankan `npm run build` sebelum deploy
  - Upload folder `public/build/` ke server
  - Pastikan file `.htaccess` ada di `public/build/`

### 2. Error CORS - Cross-Origin Resource Sharing
- **Penyebab**: Server tidak mengizinkan akses dari domain lain
- **Solusi**:
  - Konfigurasi CORS sudah ditambahkan di `config/cors.php`
  - Middleware CORS sudah diaktifkan di `bootstrap/app.php`
  - File `.htaccess` di `public/build/` sudah dikonfigurasi

## Langkah Deployment

### 1. Build Assets
```bash
# Windows PowerShell
.\scripts\rebuild-assets.ps1

# Atau manual
npm run build
```

### 2. Upload ke Server
Pastikan mengupload:
- Folder `public/build/` (termasuk semua file asset)
- File `config/cors.php`
- File `bootstrap/app.php` (yang sudah dimodifikasi)
- File `vite.config.ts` (yang sudah dimodifikasi)

### 3. Verifikasi
Setelah deploy, cek:
- Asset dapat diakses: `https://your-domain.com/build/assets/`
- Tidak ada error CORS di browser console
- Aplikasi berjalan normal

## Konfigurasi Server

### Apache (.htaccess)
File `.htaccess` sudah dibuat di `public/build/.htaccess` untuk:
- Enable CORS
- Cache static assets
- Compress assets

### Nginx
Jika menggunakan Nginx, tambahkan konfigurasi:
```nginx
location /build/ {
    add_header Access-Control-Allow-Origin *;
    add_header Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS";
    add_header Access-Control-Allow-Headers "Content-Type, Authorization, X-Requested-With";
    
    expires 1y;
    add_header Cache-Control "public, immutable";
}
```

## Troubleshooting

### Asset Masih 404
1. Pastikan folder `public/build/` terupload lengkap
2. Cek permission folder (755 untuk folder, 644 untuk file)
3. Pastikan web server dapat membaca file

### CORS Masih Error
1. Pastikan file `config/cors.php` terupload
2. Clear cache Laravel: `php artisan config:clear`
3. Restart web server

### Build Gagal
1. Hapus `node_modules` dan `package-lock.json`
2. Jalankan `npm install`
3. Jalankan `npm run build`
