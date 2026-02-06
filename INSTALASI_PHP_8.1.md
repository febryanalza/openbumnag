# Panduan Instalasi dan Konfigurasi PHP 8.1

## 📋 Informasi Project
- **PHP Required**: ^8.1 (sesuai composer.json)
- **PHP Saat Ini di VM**: 8.5
- **Target**: Downgrade ke PHP 8.1 untuk kompatibilitas

---

## 🐧 Instalasi PHP 8.1 di Ubuntu/Debian (Recommended untuk cPanel)

### 1️⃣ Hapus PHP 8.5 (Opsional)
```bash
# Cek versi PHP yang terinstall
php -v

# Hapus PHP 8.5 jika ada
sudo apt-get purge php8.5*
sudo apt-get autoremove
```

### 2️⃣ Install PHP 8.1 dengan Repository Ondřej
```bash
# Update system
sudo apt-get update

# Install software-properties-common
sudo apt-get install -y software-properties-common

# Tambahkan repository Ondřej (sumber terpercaya untuk PHP)
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update

# Install PHP 8.1 dan extensions yang dibutuhkan
sudo apt-get install -y php8.1 \
    php8.1-cli \
    php8.1-fpm \
    php8.1-mysql \
    php8.1-pgsql \
    php8.1-sqlite3 \
    php8.1-redis \
    php8.1-xml \
    php8.1-mbstring \
    php8.1-curl \
    php8.1-zip \
    php8.1-gd \
    php8.1-intl \
    php8.1-bcmath \
    php8.1-soap \
    php8.1-readline \
    php8.1-ldap \
    php8.1-msgpack \
    php8.1-igbinary \
    php8.1-opcache
```

### 3️⃣ Set PHP 8.1 sebagai Default
```bash
# Set PHP 8.1 sebagai default CLI
sudo update-alternatives --set php /usr/bin/php8.1

# Verifikasi
php -v
# Output seharusnya: PHP 8.1.x
```

### 4️⃣ Konfigurasi PHP-FPM 8.1
```bash
# Enable dan start PHP 8.1 FPM
sudo systemctl enable php8.1-fpm
sudo systemctl start php8.1-fpm
sudo systemctl status php8.1-fpm

# Jika menggunakan Apache
sudo a2enmod php8.1
sudo systemctl restart apache2

# Jika menggunakan Nginx
# Edit /etc/nginx/sites-available/default atau virtual host config
# Ubah fastcgi_pass menjadi:
# fastcgi_pass unix:/run/php/php8.1-fpm.sock;
sudo systemctl restart nginx
```

---

## 🔴 Instalasi PHP 8.1 di CentOS/RHEL

### 1️⃣ Tambahkan Repository Remi
```bash
# Install EPEL repository
sudo yum install -y epel-release

# Install Remi repository
sudo yum install -y https://rpms.remirepo.net/enterprise/remi-release-$(rpm -E %rhel).rpm

# Enable PHP 8.1 module
sudo dnf module reset php
sudo dnf module enable php:remi-8.1
```

### 2️⃣ Install PHP 8.1
```bash
sudo dnf install -y php \
    php-cli \
    php-fpm \
    php-mysqlnd \
    php-pgsql \
    php-pdo \
    php-xml \
    php-mbstring \
    php-curl \
    php-zip \
    php-gd \
    php-intl \
    php-bcmath \
    php-soap \
    php-opcache \
    php-json \
    php-redis
```

### 3️⃣ Start PHP-FPM
```bash
sudo systemctl enable php-fpm
sudo systemctl start php-fpm
php -v
```

---

## 🪟 Setup PHP 8.1 di Windows Server (Jika Diperlukan)

### 1️⃣ Download PHP 8.1
```powershell
# Download dari https://windows.php.net/download/
# Pilih PHP 8.1 Thread Safe (untuk Apache) atau Non Thread Safe (untuk IIS)

# Atau gunakan Chocolatey
choco install php --version=8.1.34
```

### 2️⃣ Konfigurasi Environment Variable
```powershell
# Tambahkan PHP ke PATH
[Environment]::SetEnvironmentVariable("Path", "$env:Path;C:\php", "Machine")

# Verifikasi
php -v
```

---

## 🎯 Konfigurasi cPanel (Jika Menggunakan cPanel)

### 1️⃣ Login ke WHM (Web Host Manager)
```
1. Login sebagai root ke WHM: https://your-server:2087
2. Menu: Software → EasyApache 4
3. Customize → PHP Extensions
4. Pilih PHP 8.1
5. Aktifkan extensions yang diperlukan:
   - mysqli
   - pdo_mysql
   - mbstring
   - xml
   - curl
   - zip
   - gd
   - intl
   - bcmath
   - soap
   - opcache
6. Provision
```

### 2️⃣ Set PHP 8.1 untuk Domain di cPanel
```
1. Login ke cPanel user
2. Menu: Software → Select PHP Version
3. Pilih PHP 8.1
4. Enable extensions yang sama seperti di atas
5. Save
```

### 3️⃣ Verifikasi via SSH
```bash
# SSH ke cPanel account
ssh cpanel_user@your-domain.com

# Cek PHP version untuk domain
/usr/local/bin/php -v

# Atau buat file info.php
echo "<?php phpinfo(); ?>" > public_html/info.php
# Browse: http://your-domain.com/info.php
# JANGAN LUPA HAPUS setelah cek!
```

---

## 📦 Update Composer untuk Menggunakan PHP 8.1

### 1️⃣ Set PHP Path untuk Composer (Jika Multiple PHP Installed)
```bash
# Cek path PHP 8.1
which php8.1
# Output: /usr/bin/php8.1

# Set composer untuk menggunakan PHP 8.1 spesifik
# Buat alias atau script wrapper
sudo nano /usr/local/bin/composer81
```

**Isi file `/usr/local/bin/composer81`:**
```bash
#!/bin/bash
/usr/bin/php8.1 /usr/local/bin/composer "$@"
```

```bash
# Buat executable
sudo chmod +x /usr/local/bin/composer81

# Test
composer81 --version
```

### 2️⃣ Reinstall Dependencies dengan PHP 8.1
```bash
# Masuk ke direktori project
cd /path/to/bumnag

# Hapus vendor dan composer.lock
rm -rf vendor
rm composer.lock

# Install dengan PHP 8.1
/usr/bin/php8.1 /usr/local/bin/composer install --no-dev --optimize-autoloader

# Atau jika sudah set default ke PHP 8.1:
composer install --no-dev --optimize-autoloader
```

---

## ✅ Verifikasi Instalasi

### 1️⃣ Cek Versi PHP
```bash
php -v
# Harus output: PHP 8.1.x

php -m | grep -E "mbstring|xml|curl|zip|gd|mysql|pdo"
# Harus menampilkan semua extensions
```

### 2️⃣ Cek Composer Dependencies
```bash
cd /path/to/bumnag
composer check-platform-reqs

# Output seharusnya:
# Checking platform requirements for packages in the vendor dir
# php ^8.1 .................... success
```

### 3️⃣ Test Laravel
```bash
# Clear all cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Test artisan
php artisan --version
# Output: Laravel Framework 10.50.0

# Test serve (development)
php artisan serve
# Browse: http://127.0.0.1:8000
```

---

## 🔧 Konfigurasi php.ini untuk Production

### Edit php.ini
```bash
# Find php.ini location
php --ini | grep "Loaded Configuration"

# Edit (Ubuntu/Debian)
sudo nano /etc/php/8.1/fpm/php.ini
sudo nano /etc/php/8.1/cli/php.ini
```

### Recommended Settings untuk Laravel:
```ini
# Memory & Performance
memory_limit = 256M
max_execution_time = 60
max_input_time = 60
post_max_size = 64M
upload_max_filesize = 64M

# OPcache (Production)
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1

# Session
session.driver=database
session.lifetime=120
session.encrypt=true

# Error Reporting (Production)
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php8.1-fpm-errors.log

# Error Reporting (Development)
# display_errors = On
# error_reporting = E_ALL

# Timezone
date.timezone = Asia/Jakarta
```

### Restart PHP-FPM setelah edit php.ini
```bash
sudo systemctl restart php8.1-fpm
```

---

## 📝 Deployment ke cPanel/VM dengan PHP 8.1

### 1️⃣ Upload Files
```bash
# Via FTP/SFTP upload semua files KECUALI:
# - vendor/
# - node_modules/
# - .env (upload .env.example, rename dan edit di server)
# - storage/logs/*
# - bootstrap/cache/*

# Atau via Git (Recommended)
cd /home/username/public_html
git clone https://your-repo.git .
# atau
git pull origin main
```

### 2️⃣ Setup di Server
```bash
# Set permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs
chmod -R 775 storage/framework

# Copy .env
cp .env.example .env
nano .env
# Edit sesuai konfigurasi server (database, etc)

# Install dependencies dengan PHP 8.1
/usr/bin/php8.1 /usr/local/bin/composer install --no-dev --optimize-autoloader

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 3️⃣ Setup Web Server

**Apache (.htaccess sudah ada di public/)**
```bash
# Pastikan DocumentRoot mengarah ke /public
# Edit virtual host atau .htaccess
```

**Nginx**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /home/username/public_html/public;

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

## 🚨 Troubleshooting

### Problem: "PHP 8.1 not found after install"
```bash
# Solution 1: Update alternatives
sudo update-alternatives --config php
# Pilih php8.1

# Solution 2: Create symlink
sudo ln -s /usr/bin/php8.1 /usr/bin/php

# Solution 3: Add to PATH
echo 'export PATH="/usr/bin:$PATH"' >> ~/.bashrc
source ~/.bashrc
```

### Problem: "Extension xxx not loaded"
```bash
# Cek extensions yang terinstall
php -m

# Install extension yang kurang
sudo apt-get install php8.1-xxx

# Restart PHP-FPM
sudo systemctl restart php8.1-fpm
```

### Problem: "Composer requires PHP 8.2+"
```bash
# Upgrade composer itu sendiri (bukan PHP)
sudo composer self-update --2

# Atau download composer terbaru
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
sudo rm composer-setup.php
```

### Problem: "Permission denied di storage/"
```bash
# Fix permissions
cd /path/to/bumnag
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Jika cPanel
sudo chown -R username:username storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## 📌 Checklist Deployment

- [ ] PHP 8.1 terinstall dan jadi default
- [ ] Extensions PHP terinstall lengkap
- [ ] Composer menggunakan PHP 8.1
- [ ] Dependencies terinstall tanpa error
- [ ] `.env` sudah dikonfigurasi dengan benar
- [ ] `APP_KEY` sudah di-generate
- [ ] Database migrations sudah dijalankan
- [ ] Folder permissions sudah benar
- [ ] Web server dikonfigurasi ke `/public`
- [ ] Cache sudah di-generate
- [ ] Website bisa diakses tanpa error

---

## 🔗 Resources

- **PHP 8.1 Downloads**: https://www.php.net/downloads
- **Ondřej PPA**: https://launchpad.net/~ondrej/+archive/ubuntu/php
- **Remi Repository**: https://rpms.remirepo.net/
- **Laravel Deployment**: https://laravel.com/docs/10.x/deployment
- **cPanel Documentation**: https://docs.cpanel.net/

---

**Update Terakhir**: February 6, 2026  
**Versi PHP**: 8.1.34  
**Versi Laravel**: 10.50.0
