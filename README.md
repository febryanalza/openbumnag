# 🏢 BUMNag Lubas Mandiri - Website & Admin Panel

Website resmi **Badan Usaha Milik Nagari (BUMNag) Lubas Mandiri** yang dibangun dengan Laravel 12 dan custom admin panel.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.5+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📖 Tentang Project

Website ini menyediakan:
- **Portal Informasi** - Berita, laporan transparansi, dan informasi umum BUMNag
- **Katalog Produk** - Showcase produk dan layanan dari unit-unit usaha BUMNag
- **Galeri** - Dokumentasi foto dan video kegiatan
- **Admin Panel** - Dashboard untuk mengelola seluruh konten website
- **Role & Permission** - Sistem role-based access control untuk multi-admin

## 🚀 Fitur Utama

### Frontend (Public)
- ✅ Homepage dengan hero slider
- ✅ Berita & artikel dengan kategori
- ✅ Laporan transparansi (PDF download)
- ✅ Katalog produk per unit usaha
- ✅ Galeri foto dan video
- ✅ Formulir kontak
- ✅ Profil unit usaha BUMNag
- ✅ Responsive design (mobile-friendly)

### Backend (Admin Panel)
- ✅ Dashboard dengan statistik
- ✅ CRUD Berita dengan WYSIWYG editor
- ✅ CRUD Laporan (upload PDF)
- ✅ CRUD Promosi dengan periode dan diskon
- ✅ CRUD Galeri (foto & video)
- ✅ CRUD Katalog produk
- ✅ CRUD Kategori
- ✅ CRUD Profil BUMNag
- ✅ CRUD Tim/Anggota
- ✅ Manajemen pesan kontak
- ✅ Pengaturan website (settings)
- ✅ Role & Permission management
- ✅ User management
- ✅ Query caching untuk performa optimal

## 🛠️ Tech Stack

- **Framework:** Laravel 12.47.0
- **PHP:** 8.5.2
- **Database:** MySQL 8.0
- **Authentication:** Laravel Breeze
- **Authorization:** Spatie Laravel Permission
- **Frontend:** Tailwind CSS (CDN), Alpine.js
- **Cache:** File/Redis cache
- **File Storage:** Local storage dengan symlink

## 📚 Dokumentasi

Dokumentasi lengkap tersedia dalam bahasa Indonesia:

### 👥 Untuk Pengguna
📖 **[User Guide](USER_GUIDE.md)** - Panduan lengkap penggunaan website untuk pengunjung
- Navigasi website
- Membaca berita & laporan
- Melihat katalog produk
- Menggunakan formulir kontak
- FAQ & troubleshooting

### 🔐 Untuk Administrator
📖 **[Admin Guide](ADMIN_GUIDE.md)** - Panduan komprehensif admin panel
- Login & keamanan
- Dashboard overview
- Kelola berita, laporan, promosi
- Kelola galeri & katalog
- Pengaturan website
- Role & permission management
- Best practices & tips optimasi

### ⚙️ Untuk Developer
📖 **[Quick Start Guide](QUICK_START.md)** - Deployment & setup
- Installation steps
- Configuration
- Migration guide
- Deployment checklist

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0 / MariaDB >= 10.3
- Node.js & NPM (untuk build assets)
- Web server (Apache/Nginx)

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0 / MariaDB >= 10.3
- Node.js & NPM (untuk build assets)
- Web server (Apache/Nginx)

## 🔧 Installation

### 1. Clone Repository
```bash
git clone https://github.com/febryanalza/openbumnag.git
cd openbumnag
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy .env.example
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bumnag
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration
```bash
# Run migrations
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed
```

### 5. Storage Setup
```bash
# Create storage symlink
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### 6. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Run Application
```bash
# Development server
php artisan serve

# Visit: http://localhost:8000
# Admin: http://localhost:8000/admin/login
```

## 🔐 Default Credentials

**Super Admin:**
- Email: admin@example.com
- Password: password

⚠️ **IMPORTANT:** Ganti password default setelah login pertama kali!

## ⚡ Performance Optimization

Project ini sudah dilengkapi dengan optimasi performa:

### Query Caching
```bash
# Clear application cache
php artisan app:clear-cache

# Clear specific cache
php artisan app:clear-cache --type=homepage
php artisan app:clear-cache --type=settings
php artisan app:clear-cache --type=permissions
```

### Database Indexes
Semua index database sudah diterapkan melalui migration `optimize_database_indexes_safe`.

### Cache Configuration
- **Homepage Data:** 5 menit TTL
- **Settings:** 1 jam TTL
- **Permissions/Roles:** 1 jam TTL
- Auto cache invalidation saat content di-update

## 🔍 Development

### Slow Query Logging
Enable slow query logging di development:
```env
LOG_QUERIES=true
```

Query > 100ms akan di-log sebagai warning, > 500ms sebagai error.

### Artisan Commands
```bash
# Clear all caches
php artisan optimize:clear

# Cache config & routes (production)
php artisan optimize

# List all routes
php artisan route:list

# Create admin user
php artisan tinker
> User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')])
```

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` di `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure proper database
- [ ] Set up SSL certificate
- [ ] Configure email SMTP
- [ ] Run `php artisan optimize`
- [ ] Set proper file permissions
- [ ] Configure backup schedule
- [ ] Set up monitoring

### Cache Optimization
```bash
# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## 📊 Project Structure

```
bumnag/
├── app/
│   ├── Console/Commands/        # Custom artisan commands
│   ├── Http/Controllers/
│   │   ├── Admin/               # Admin panel controllers
│   │   └── HomeController.php   # Frontend controllers
│   ├── Models/                  # Eloquent models
│   ├── Services/
│   │   └── CacheService.php     # Centralized caching
│   ├── Observers/               # Model observers
│   └── Providers/               # Service providers
├── database/
│   └── migrations/              # Database migrations
├── resources/
│   └── views/
│       ├── admin/               # Admin panel views
│       └── *.blade.php          # Frontend views
├── routes/
│   ├── web.php                  # Frontend routes
│   └── admin.php                # Admin routes
├── public/
│   └── storage/                 # Symlink to storage
└── storage/
    └── app/public/              # Uploaded files
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 Changelog

### [Latest] - 2026-02-01
- ✅ Comprehensive query caching implementation
- ✅ Homepage optimization (20+ queries → 1-2 cached queries)
- ✅ CacheService for centralized caching
- ✅ Auto cache invalidation via observers
- ✅ Slow query logging for development
- ✅ Complete documentation (User & Admin guides)

### Previous Updates
- Permission & Role management system
- Auth facade refactoring for better type hints
- PHP error fixes and optimization
- Admin panel CRUDs (News, Reports, Promotions, etc.)

## 🐛 Known Issues

None at the moment. Report issues di GitHub Issues.

## 📞 Support

- **Email:** admin@lubasmandiri.id
- **GitHub Issues:** [Report Bug](https://github.com/febryanalza/openbumnag/issues)
- **Documentation:** See guides in this repository

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🙏 Credits

- Built with [Laravel](https://laravel.com)
- Authentication by [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
- Permissions by [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- UI with [Tailwind CSS](https://tailwindcss.com)

---

**Developed with ❤️ for BUMNag Lubas Mandiri**

*Last Updated: February 2026*
