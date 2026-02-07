# 📚 Panduan Deployment BUMNag dengan PHP 8.1

Repositori ini berisi website BUMNag (Badan Usaha Milik Nagari) yang dibangun dengan Laravel 10 dan memerlukan **PHP 8.1**.

---

## 🎯 Requirements

### Server Requirements
- **PHP**: 8.1.x (CRITICAL - tidak support 8.0 atau 8.5+)
- **Database**: MySQL 5.7+ atau MariaDB 10.3+
- **Web Server**: Apache 2.4+ atau Nginx 1.18+
- **Composer**: 2.x

### PHP Extensions Required
```
mbstring, xml, curl, zip, gd, pdo, pdo_mysql, openssl, 
tokenizer, json, bcmath, ctype, fileinfo
```

---

## 🚀 Quick Start (Deployment)

### Option 1: Automated Deployment (Recommended)

```bash
# 1. Clone repository
git clone <repository-url> bumnag
cd bumnag

# 2. Make scripts executable
chmod +x check-requirements.sh deploy.sh switch-php-81.sh

# 3. Check if PHP 8.1 is installed
./check-requirements.sh

# 4. If PHP is not 8.1, switch to it
./switch-php-81.sh

# 5. Deploy automatically
./deploy.sh
```

### Option 2: Manual Deployment

```bash
# 1. Install dependencies
composer install --no-dev --optimize-autoloader

# 2. Setup environment
cp .env.example .env
nano .env  # Edit database credentials

# 3. Generate key
php artisan key:generate

# 4. Set permissions
chmod -R 775 storage bootstrap/cache

# 5. Run migrations
php artisan migrate --force

# 6. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 7. Create storage link
php artisan storage:link
```

---

## 📋 Available Scripts

### 1. `check-requirements.sh`
Memeriksa apakah server memenuhi semua requirements.

```bash
./check-requirements.sh
```

**Output:**
- ✅ PHP version & extensions
- ✅ Composer availability
- ✅ Laravel project structure
- ✅ File permissions
- ✅ Database connection

### 2. `switch-php-81.sh`
Mengganti PHP default dari versi lain (8.5, 8.3, dll) ke PHP 8.1.

```bash
./switch-php-81.sh
```

**Fitur:**
- Deteksi otomatis PHP versions yang terinstall
- Switch PHP CLI ke 8.1
- Switch PHP-FPM ke 8.1
- Update konfigurasi Apache/Nginx
- Verifikasi hasil switching

### 3. `deploy.sh`
Automated deployment script lengkap.

```bash
./deploy.sh
```

**Proses:**
1. Verifikasi PHP 8.1
2. Check extensions
3. Backup .env (jika ada)
4. Install dependencies
5. Setup .env
6. Generate APP_KEY
7. Set permissions
8. Clear caches
9. Run migrations (optional)
10. Optimize application
11. Create storage link
12. Final verification

---

## 📖 Dokumentasi Lengkap

### File Dokumentasi

1. **`README_DEPLOYMENT.md`** (file ini)
   - Quick start guide
   - Overview scripts

2. **`INSTALASI_PHP_8.1.md`**
   - Panduan lengkap instalasi PHP 8.1
   - Untuk Ubuntu/Debian, CentOS/RHEL, Windows
   - Konfigurasi cPanel
   - Troubleshooting

### Cara Membaca Dokumentasi

```bash
# Baca di terminal (jika ada less/cat)
less README_DEPLOYMENT.md
cat INSTALASI_PHP_8.1.md

# Atau buka di text editor
nano README_DEPLOYMENT.md

# Atau clone dan buka di VS Code
code .
```

---

## 🔧 Troubleshooting

### Problem: "PHP 8.1 not found"

**Solution:**
```bash
# Ubuntu/Debian
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php8.1 php8.1-cli php8.1-fpm php8.1-mysql \
    php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd

# Set as default
sudo update-alternatives --set php /usr/bin/php8.1
```

Atau jalankan: `./switch-php-81.sh`

### Problem: "Extension xxx not found"

**Solution:**
```bash
# Check missing extensions
./check-requirements.sh

# Install missing extension
sudo apt-get install php8.1-<extension-name>

# Restart PHP-FPM
sudo systemctl restart php8.1-fpm
```

### Problem: "Permission denied on storage/"

**Solution:**
```bash
# Set proper permissions
chmod -R 775 storage bootstrap/cache

# Set proper ownership (Ubuntu/Debian)
sudo chown -R www-data:www-data storage bootstrap/cache

# For cPanel
sudo chown -R <username>:<username> storage bootstrap/cache
```

### Problem: "Route not found / 404 errors"

**Solution:**
```bash
# Apache: Enable mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2

# Check .htaccess exists in public/
ls -la public/.htaccess

# Nginx: Use proper config (see INSTALASI_PHP_8.1.md)
```

### Problem: "Class not found errors"

**Solution:**
```bash
# Regenerate autoload
composer dump-autoload

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Reinstall dependencies
rm -rf vendor composer.lock
composer install --no-dev --optimize-autoloader
```

---

## 🔐 Security Checklist

Sebelum go-live di production:

- [ ] Set `APP_ENV=production` di `.env`
- [ ] Set `APP_DEBUG=false` di `.env`
- [ ] Generate unique `APP_KEY`
- [ ] Use HTTPS (SSL/TLS)
- [ ] Set proper file permissions (755/644)
- [ ] Remove `.env.example` dari public access
- [ ] Configure firewall
- [ ] Regular backups (database & files)
- [ ] Update dependencies regularly
- [ ] Monitor error logs

---

## 📊 Project Structure

```
bumnag/
├── app/                    # Application code
│   ├── Http/
│   │   ├── Controllers/   # Controllers
│   │   └── Middleware/    # Middleware
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── bootstrap/             # Bootstrap files
├── config/                # Configuration files
├── database/              # Migrations & seeders
├── public/                # Web root (DocumentRoot harus ke sini!)
├── resources/             # Views, assets
├── routes/                # Route definitions
├── storage/               # Logs, cache, uploads
├── tests/                 # Tests
├── vendor/                # Composer dependencies
├── .env.example           # Environment template
├── composer.json          # PHP dependencies
├── artisan               # Laravel CLI
├── check-requirements.sh  # Requirements checker
├── deploy.sh             # Deployment script
├── switch-php-81.sh      # PHP version switcher
├── INSTALASI_PHP_8.1.md  # Installation guide
└── README_DEPLOYMENT.md  # This file
```

---

## 🌐 Web Server Configuration

### Apache

File `.htaccess` sudah disediakan di `public/`.

**VirtualHost example:**
```apache
<VirtualHost *:80>
    ServerName bumnag.example.com
    DocumentRoot /path/to/bumnag/public

    <Directory /path/to/bumnag/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/bumnag-error.log
    CustomLog ${APACHE_LOG_DIR}/bumnag-access.log combined
</VirtualHost>
```

### Nginx

**Config example:**
```nginx
server {
    listen 80;
    server_name bumnag.example.com;
    root /path/to/bumnag/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 📱 cPanel Deployment

1. **Upload via File Manager atau FTP**
   - Upload semua files ke `public_html/`
   - JANGAN upload: `vendor/`, `node_modules/`, `.env`

2. **Setup via Terminal (SSH)**
   ```bash
   cd public_html
   ./switch-php-81.sh   # Jika belum PHP 8.1
   ./deploy.sh          # Auto deployment
   ```

3. **Configure Domain**
   - Point DocumentRoot ke `public_html/public`
   - Atau gunakan `.htaccess` redirect

4. **Select PHP Version di cPanel**
   - Software → Select PHP Version
   - Pilih 8.1
   - Enable semua extensions yang diperlukan

---

## 🔄 Update/Maintenance

### Pull Latest Changes
```bash
cd /path/to/bumnag
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Backup Database
```bash
# Manual
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# Via Laravel
php artisan db:backup  # (jika ada package backup)
```

### Clear All Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

### View Logs
```bash
# Latest errors
tail -f storage/logs/laravel.log

# Last 50 lines
tail -n 50 storage/logs/laravel.log

# Search for errors
grep -i error storage/logs/laravel.log
```

---

## �️ Fix Storage Images (Shared Hosting Issue)

**Problem:** Gambar yang diupload tidak tampil setelah deploy ke shared hosting.

**Root Cause:**
1. ❌ `APP_URL=http://localhost` di `.env` production
2. ❌ Symlink `public/storage` tidak berfungsi di cPanel/shared hosting

**Quick Fix (Automated):**
```bash
chmod +x fix-storage-images.sh
./fix-storage-images.sh
```

**Then update `.env`:**
```bash
nano .env
# Change:
APP_URL=https://your-domain.com  # Production URL!
```

**Clear cache:**
```bash
php artisan config:cache
php artisan optimize
```

**After uploading new images via admin panel:**
```bash
./sync-storage.sh
```

**Manual Fix (Step-by-Step):**
```bash
# 1. Remove symlink
rm -f public/storage

# 2. Create physical directory
mkdir -p public/storage

# 3. Copy files
rsync -av storage/app/public/ public/storage/

# 4. Set permissions
chmod -R 755 public/storage
chmod -R 775 storage/app/public

# 5. Update .env APP_URL
nano .env

# 6. Clear caches
php artisan config:cache
```

**Verify:**
```bash
# Check files copied
ls -la public/storage/

# Test image URL
curl -I https://your-domain.com/storage/test.jpg
# Should return: HTTP/1.1 200 OK
```

**📖 For complete troubleshooting guide, see: [FIX_STORAGE_IMAGES.md](FIX_STORAGE_IMAGES.md)**

---

## �📞 Support

Jika mengalami masalah:

1. Jalankan `./check-requirements.sh` untuk diagnosa
2. Periksa logs di `storage/logs/laravel.log`
3. **Gambar tidak tampil?** → [FIX_STORAGE_IMAGES.md](FIX_STORAGE_IMAGES.md)
4. **Buat admin user?** → [CREATE_USER_GUIDE.md](CREATE_USER_GUIDE.md)
5. **502 Bad Gateway?** → [FIX_502_ERROR.md](FIX_502_ERROR.md)
6. Baca dokumentasi lengkap di [INSTALASI_PHP_8.1.md](INSTALASI_PHP_8.1.md)
7. Check web server error logs:
   - Apache: `/var/log/apache2/error.log`
   - Nginx: `/var/log/nginx/error.log`

---

## 📄 License

[Sesuaikan dengan license project Anda]

---

## 🙏 Credits

- **Laravel Framework**: https://laravel.com
- **Spatie Permission**: https://spatie.be/docs/laravel-permission
- **Filament**: https://filamentphp.com (jika digunakan)

---

**Last Updated**: February 6, 2026  
**PHP Version**: 8.1.34  
**Laravel Version**: 10.50.0
