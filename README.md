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

# Database (MySQL untuk production)
DB_CONNECTION=mysql
DB_HOST=43.157.224.164
DB_PORT=80
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (Optional)
MAIL_MAILER=log
```

### 🔑 Generate APP_KEY:

**IMPORTANT**: Set environment variable `APP_KEY` di Zeabur dashboard dengan nilai berikut:

```
APP_KEY=base64:ObZwuispQlqu8/Tt2aVSF5o67x2q6EnDOTTxE3m1Cyk=
```

**Langkah-langkah:**
1. Buka Zeabur dashboard
2. Pilih project Laravel DPR
3. Masuk ke tab "Environment Variables"
4. Tambah variable baru:
   - **Name**: `APP_KEY`
   - **Value**: `base64:ObZwuispQlqu8/Tt2aVSF5o67x2q6EnDOTTxE3m1Cyk=`
5. Save dan redeploy aplikasi

### 🗄️ Database Setup:

**Untuk MySQL (Production - Recommended):**
```bash
# Set environment variables di Zeabur:
DB_CONNECTION=mysql
DB_HOST=your-mysql-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

**Untuk SQLite (Development):**
```bash
# Set environment variables di Zeabur:
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

**Untuk PostgreSQL (Alternative):**
```bash
# Set environment variables di Zeabur:
DB_CONNECTION=pgsql
DB_HOST=your-postgres-host
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

**Setup Database:**
1. Set environment variables di Zeabur (MySQL)
2. Jalankan migration: `php artisan migrate`
3. Jalankan seeder: `php artisan db:seed`

**Setup Database (SQLite - Development):**
1. Set environment variables di Zeabur (SQLite)
2. Jalankan setup database: `php artisan-setup-db.php`
3. Jalankan migration: `php artisan migrate`
4. Jalankan seeder: `php artisan db:seed`

**Quick Setup (Manual):**
```bash
# Buat direktori dan file database
mkdir -p database
touch database/database.sqlite
chmod 664 database/database.sqlite
chmod 755 database

# Jalankan migration dan seeder
php artisan migrate
php artisan db:seed
```

### 🚨 Troubleshooting Database Error:

**Untuk MySQL (Production):**
1. **Set Environment Variables di Zeabur:**
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=your-mysql-host
   DB_PORT=3306
   DB_DATABASE=your-database-name
   DB_USERNAME=your-username
   DB_PASSWORD=your-password
   ```

2. **Test Database Connection:**
   ```bash
   php artisan-test-db.php
   # atau
   npm run test-db
   ```

3. **Setup Database:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

**Untuk SQLite (Development):**
1. **Set Environment Variable di Zeabur:**
   ```bash
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

2. **Jalankan di Zeabur Console/Terminal:**
   ```bash
   php artisan-setup-db.php
   php artisan migrate
   php artisan db:seed
   ```

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
