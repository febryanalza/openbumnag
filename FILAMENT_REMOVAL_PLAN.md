# Filament Removal Plan

## Date: 2026-02-01

## Current State
- **Filament Version**: 4.0
- **Resources**: 11 resource files
- **Models**: BumnagProfile, Catalog, Category, Contact, Gallery, News, Promotion, Report, Setting, TeamMember, User
- **Database**: MySQL with existing data
- **Authentication**: Spatie Laravel Permission (independent of Filament)

## What Will Be Removed
1. ✅ Filament packages from composer.json
   - filament/filament
   - filament/spatie-laravel-media-library-plugin
   - filament/spatie-laravel-settings-plugin
   - filament/spatie-laravel-tags-plugin
   - bezhansalleh/filament-shield

2. ✅ Filament folders
   - app/Filament/* (all resources, pages, widgets)
   - app/Providers/Filament/*
   - config/filament.php
   - public/css/filament/*
   - public/js/filament/*
   - public/fonts/filament/*

3. ✅ Filament references in code
   - bootstrap/providers.php
   - Any Filament middleware
   - Filament routes

## What Will Be Preserved
1. ✅ All Models (app/Models/*)
2. ✅ All Migrations (database/migrations/*)
3. ✅ All Database Data
4. ✅ Spatie Laravel Permission (roles & permissions)
5. ✅ Controllers (app/Http/Controllers/*)
6. ✅ Public Routes (routes/web.php - non-Filament routes)
7. ✅ Views (resources/views/*)

## What Will Be Created
1. ✅ Laravel Breeze (authentication scaffolding)
2. ✅ Admin Panel Structure
   - routes/admin.php
   - app/Http/Controllers/Admin/*
   - resources/views/admin/*
   - Admin middleware

3. ✅ Admin Dashboard
   - Basic admin layout
   - Navigation
   - CRUD templates

## Migration Steps for Production
```bash
# 1. Backup
./create-backup.sh

# 2. Pull changes
git pull origin main

# 3. Remove Filament packages
composer remove filament/filament bezhansalleh/filament-shield \
    filament/spatie-laravel-media-library-plugin \
    filament/spatie-laravel-settings-plugin \
    filament/spatie-laravel-tags-plugin

# 4. Install Breeze
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build

# 5. Clear caches
php artisan optimize:clear

# 6. Test
# Visit: https://bumnag.fazcreateve.app/admin
```

## Rollback Plan
If something goes wrong:
```bash
# Restore from backup
cp backups/pre-filament-removal-TIMESTAMP/composer.json .
cp backups/pre-filament-removal-TIMESTAMP/composer.lock .
composer install
git checkout app/Filament app/Providers/Filament config/filament.php
php artisan optimize:clear
```

## Notes
- All debugging routes (/debug/*) will be kept temporarily
- Public website routes (/, /catalog, /gallery) will continue working
- Database remains untouched
- User accounts and permissions preserved
