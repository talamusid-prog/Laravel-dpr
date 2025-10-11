# Laravel DPR Project

Aplikasi web untuk DPR (Dewan Perwakilan Rakyat) dengan fitur admin panel, blog, aspirasi, dan manajemen event.

## 🚀 Deployment ke Zeabur

### Environment Variables yang Diperlukan:

```bash
# Laravel Configuration
APP_NAME="Laravel DPR"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.zeabur.app

# Database (SQLite)
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (Optional)
MAIL_MAILER=log
```

### 🔑 Generate APP_KEY:

Jalankan command berikut untuk generate APP_KEY:

```bash
php artisan key:generate --show
```

Copy hasilnya dan set sebagai environment variable `APP_KEY` di Zeabur.

### 📁 File Structure:

```
├── app/                 # Laravel application
├── database/            # Database files
├── public/             # Public assets
├── resources/           # Vue.js components
├── routes/             # Route definitions
└── storage/            # Storage directory
```

### 🛠️ Build Commands:

```bash
# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Run seeders (optional)
php artisan db:seed --force
```

### 🔧 Zeabur Configuration:

1. **Environment Variables**: Set semua environment variables di Zeabur dashboard
2. **Build Command**: `composer install --optimize-autoloader --no-dev && npm install && npm run build`
3. **Start Command**: `php artisan serve --host=0.0.0.0 --port=8000`
4. **Database**: SQLite file akan dibuat otomatis di `/var/www/database/database.sqlite`

### 📝 Notes:

- Pastikan `APP_KEY` sudah di-set sebelum deployment
- Database SQLite akan dibuat otomatis
- Storage link akan dibuat otomatis untuk file uploads
- Semua environment variables harus di-set di Zeabur dashboard
