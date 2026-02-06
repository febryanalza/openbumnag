# 🚀 Quick Reference - BUMNag Deployment

## ⚡ Perintah Cepat

### Setup Awal (Pertama Kali)
```bash
# 1. Cek requirements
./check-requirements.sh

# 2. Switch ke PHP 8.1 (jika belum)
./switch-php-81.sh

# 3. Deploy otomatis
./deploy.sh

# 4. Edit konfigurasi database
nano .env
```

### Daily Operations
```bash
# Start development server
php artisan serve

# Clear semua cache
php artisan config:clear && php artisan cache:clear && php artisan view:clear

# Jalankan migrations
php artisan migrate

# Rollback migration terakhir
php artisan migrate:rollback

# Buat cache untuk production
php artisan optimize

# Lihat routes
php artisan route:list
```

### Update Code dari Git
```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan view:cache
```

---

## 🔧 PHP 8.1 Commands

### Cek Versi
```bash
php -v                    # Versi PHP
php -m                    # List extensions
php -i | grep "Loaded"    # Lokasi php.ini
```

### Install PHP 8.1 (Ubuntu)
```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-fpm php8.1-mysql \
    php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd
```

### Switch Default PHP
```bash
sudo update-alternatives --set php /usr/bin/php8.1
sudo systemctl restart php8.1-fpm
```

---

## 📦 Composer Commands

```bash
# Install dependencies (development)
composer install

# Install dependencies (production)
composer install --no-dev --optimize-autoloader

# Update dependencies
composer update

# Add package
composer require nama/package

# Remove package
composer remove nama/package

# Clear composer cache
composer clear-cache

# Check platform requirements
composer check-platform-reqs
```

---

## 🗄️ Database Commands

```bash
# Run migrations
php artisan migrate

# Run migrations (production)
php artisan migrate --force

# Rollback
php artisan migrate:rollback

# Reset & re-migrate
php artisan migrate:fresh

# Run seeders
php artisan db:seed

# Specific seeder
php artisan db:seed --class=UserSeeder

# Fresh + seed
php artisan migrate:fresh --seed

# Backup database
mysqldump -u user -p database > backup.sql

# Restore database
mysql -u user -p database < backup.sql
```

---

## 🔐 Permission Commands

```bash
# Set permissions (Ubuntu/Debian)
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Set permissions (cPanel)
sudo chown -R username:username storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Fix permissions for current user
chmod -R 775 storage bootstrap/cache
```

---

## 🚨 Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Error: "Storage not writable"
```bash
chmod -R 775 storage bootstrap/cache
```

### Error: "Routes not found"
```bash
php artisan route:clear
php artisan route:cache
```

### Error: "Config cached"
```bash
php artisan config:clear
```

### Server Error 500
```bash
# Lihat log
tail -f storage/logs/laravel.log

# Enable debug mode (development only!)
# Edit .env: APP_DEBUG=true
```

---

## 🌐 Web Server

### Apache
```bash
# Enable mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2

# Check syntax
sudo apache2ctl configtest
```

### Nginx
```bash
# Test config
sudo nginx -t

# Restart
sudo systemctl restart nginx
```

### PHP-FPM
```bash
# Restart PHP-FPM
sudo systemctl restart php8.1-fpm

# Status
sudo systemctl status php8.1-fpm

# View logs
sudo tail -f /var/log/php8.1-fpm.log
```

---

## 📊 Monitoring

### Logs
```bash
# Laravel log
tail -f storage/logs/laravel.log

# Apache error log
sudo tail -f /var/log/apache2/error.log

# Nginx error log
sudo tail -f /var/log/nginx/error.log

# PHP-FPM log
sudo tail -f /var/log/php8.1-fpm.log
```

### Performance
```bash
# Enable OPcache (production)
# Edit php.ini: opcache.enable=1

# Clear OPcache
php artisan optimize:clear
```

---

## 🔄 Cache Management

```bash
# Clear all
php artisan optimize:clear

# Individual clears
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 📝 Environment Files

### Development (.env)
```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### Production (.env)
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

---

## 🎯 Deployment Checklist

**Pre-Deployment:**
- [ ] PHP 8.1 installed & configured
- [ ] All extensions installed
- [ ] Composer dependencies updated
- [ ] .env configured correctly
- [ ] Migrations tested
- [ ] File permissions correct

**Deployment:**
- [ ] Upload/Pull code
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `php artisan migrate --force`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] `php artisan storage:link`

**Post-Deployment:**
- [ ] Test website functionality
- [ ] Check error logs
- [ ] Verify database connection
- [ ] Test file uploads
- [ ] Monitor performance

---

## 🆘 Emergency Commands

### Site Down - Quick Fix
```bash
# 1. Check processes
sudo systemctl status php8.1-fpm
sudo systemctl status nginx  # or apache2

# 2. Restart services
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx  # or apache2

# 3. Clear caches
php artisan optimize:clear

# 4. Check logs
tail -n 100 storage/logs/laravel.log
```

### Rollback Deployment
```bash
# 1. Restore code
git reset --hard HEAD~1
# or
git checkout <previous-commit-hash>

# 2. Restore database
mysql -u user -p database < backup.sql

# 3. Clear caches
php artisan optimize:clear
```

---

## 📞 Help

**Check System:**
```bash
./check-requirements.sh
```

**Read Full Documentation:**
```bash
cat INSTALASI_PHP_8.1.md
cat README_DEPLOYMENT.md
```

**Laravel Docs:**
https://laravel.com/docs/10.x

---

**Version:** 1.0  
**Last Updated:** February 6, 2026  
**PHP:** 8.1.34  
**Laravel:** 10.50.0
