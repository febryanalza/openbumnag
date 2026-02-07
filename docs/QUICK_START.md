# 🚀 Quick Start Guide - Manual Admin Panel

## Deployment ke Production Server

### OPTION 1: Automatic Migration (Recommended)

```bash
# SSH ke server
ssh -i "C:\Users\Lenovo\.ssh\dropletsshkey" deployer@159.89.195.62

# Navigate ke project
cd /var/www/bumnag

# Make scripts executable
chmod +x create-backup.sh remove-filament-files.sh migrate-to-manual-admin.sh

# Run migration script
./migrate-to-manual-admin.sh
```

Script akan:
1. ✅ Create backup
2. ✅ Pull latest code
3. ✅ Remove Filament files
4. ✅ Remove Filament packages
5. ✅ Install Laravel Breeze
6. ✅ Install & build assets
7. ✅ Run migrations
8. ✅ Clear caches
9. ✅ Set permissions

### OPTION 2: Manual Step-by-Step

```bash
# 1. Backup first
cd /var/www/bumnag
./create-backup.sh

# 2. Pull latest code
git pull origin main

# 3. Remove Filament packages
composer remove filament/filament \
    bezhansalleh/filament-shield \
    filament/spatie-laravel-media-library-plugin \
    filament/spatie-laravel-settings-plugin \
    filament/spatie-laravel-tags-plugin

# 4. Install Breeze
composer require laravel/breeze --dev
php artisan breeze:install blade

# 5. Install and build assets
npm install
npm run build

# 6. Clear caches
php artisan optimize:clear

# 7. Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Accessing Admin Panel

### Login
```
URL: https://bumnag.fazcreateve.app/login
Email: admin@bumnag.com (or admin@admin.com)
Password: bumagbersatu24
```

### Dashboard
```
URL: https://bumnag.fazcreateve.app/admin
```

## What's Included

✅ **Authentication**: Login, Logout, Password Reset (Laravel Breeze)
✅ **Dashboard**: Stats overview with user, news, catalog counts
✅ **Responsive Layout**: Mobile-friendly Tailwind CSS design
✅ **All Data Preserved**: Database tables and models intact
✅ **Clean Structure**: Ready for CRUD implementation

## What's NOT Included (Yet)

❌ CRUD pages for resources (news, catalogs, etc.) - currently showing "Coming Soon"
❌ File uploads - needs implementation
❌ User management UI - needs implementation
❌ Settings page - needs implementation

## Next Development Steps

### 1. Build News CRUD (Example)

```bash
# Create controller
php artisan make:controller Admin/NewsController --resource

# Create views
mkdir -p resources/views/admin/news
# Create: index.blade.php, create.blade.php, edit.blade.php
```

Edit `routes/admin.php`:
```php
use App\Http\Controllers\Admin\NewsController;

Route::resource('news', NewsController::class);
```

### 2. Use CRUD Generator (Optional)

```bash
# Install generator
composer require infyomlabs/laravel-generator --dev

# Generate CRUD
php artisan infyom:scaffold News --fieldsFile=news_fields.json
```

### 3. Use Laravel Backpack (Alternative)

If you want a ready-made admin panel (lighter than Filament):

```bash
composer require backpack/crud
php artisan backpack:install
```

## Troubleshooting

### "Class Filament not found"
```bash
composer dump-autoload
php artisan optimize:clear
```

### Login redirect loop
```bash
php artisan optimize:clear
# Check .env SESSION_DRIVER=database
```

### CSS not loading
```bash
npm run build
php artisan optimize:clear
```

### Can't access /admin
```bash
php artisan route:list | grep admin
# Should show admin routes
```

## File Structure

```
app/
├── Http/Controllers/Admin/
│   └── DashboardController.php
├── Models/                        # All preserved
│   ├── User.php
│   ├── News.php
│   └── ...
routes/
├── web.php                        # Public routes
└── admin.php                      # Admin routes
resources/
├── views/
│   ├── admin/
│   │   ├── layouts/app.blade.php  # Main layout
│   │   ├── dashboard.blade.php    # Dashboard
│   │   └── coming-soon.blade.php  # Placeholder
│   └── auth/                      # Breeze auth views
database/
└── migrations/                    # All preserved
```

## Rollback Plan

If you need to go back to Filament:

```bash
# Find your backup
ls backups/

# Restore
cp backups/pre-filament-removal-TIMESTAMP/composer.json .
composer install
php artisan optimize:clear

# Or use git
git revert HEAD
git push origin main
```

## Support & Documentation

📖 **Full Documentation**: [ADMIN_PANEL_README.md](ADMIN_PANEL_README.md)
📋 **Migration Plan**: [FILAMENT_REMOVAL_PLAN.md](FILAMENT_REMOVAL_PLAN.md)

## Key Points

1. ✅ **All data is safe** - database untouched
2. ✅ **Public website works** - /, /catalog, /gallery routes preserved
3. ✅ **Users can login** - existing credentials work
4. ⏳ **CRUD needs implementation** - currently placeholder pages
5. 🎯 **Clean slate** - build admin features as needed

## Testing Checklist

After deployment, verify:

- [ ] Can access login page: `/login`
- [ ] Can login with existing credentials
- [ ] Dashboard loads: `/admin`
- [ ] Stats show correct numbers
- [ ] Can logout
- [ ] Public website still works: `/`
- [ ] No Filament errors in logs

Run tests:
```bash
php artisan test
tail -50 storage/logs/laravel.log
```

## Success! 🎉

Your admin panel is now manual and fully customizable!

Start building CRUD pages or install a CRUD generator to speed up development.
