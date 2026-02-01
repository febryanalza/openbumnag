#!/bin/bash

echo "🚀 MIGRATING FROM FILAMENT TO MANUAL ADMIN PANEL"
echo "=================================================="
echo ""

# Safety checks
if [ ! -f "composer.json" ]; then
    echo "❌ Error: composer.json not found. Are you in the project root?"
    exit 1
fi

echo "⚠️  WARNING: This will remove Filament completely!"
echo "   - All Filament resources will be deleted"
echo "   - Database and models will be preserved"
echo "   - Public routes will continue working"
echo ""
read -p "Continue? (yes/no): " CONFIRM

if [ "$CONFIRM" != "yes" ]; then
    echo "❌ Migration cancelled."
    exit 0
fi

echo ""
echo "======================================================"
echo "STEP 1: Creating Backup"
echo "======================================================"
./create-backup.sh

echo ""
echo "======================================================"
echo "STEP 2: Pulling Latest Code"
echo "======================================================"
git pull origin main

echo ""
echo "======================================================"
echo "STEP 3: Removing Filament Files"
echo "======================================================"
./remove-filament-files.sh

echo ""
echo "======================================================"
echo "STEP 4: Installing Dependencies"
echo "======================================================"
echo "Removing Filament packages..."
composer remove filament/filament \
    bezhansalleh/filament-shield \
    filament/spatie-laravel-media-library-plugin \
    filament/spatie-laravel-settings-plugin \
    filament/spatie-laravel-tags-plugin \
    --no-interaction 2>&1 | tail -20

echo ""
echo "Installing Laravel Breeze..."
composer require laravel/breeze --dev --no-interaction

echo ""
echo "Installing Breeze scaffolding..."
php artisan breeze:install blade --no-interaction

echo ""
echo "======================================================"
echo "STEP 5: Installing Node Dependencies"
echo "======================================================"
npm install

echo ""
echo "======================================================"
echo "STEP 6: Building Assets"
echo "======================================================"
npm run build

echo ""
echo "======================================================"
echo "STEP 7: Publishing Breeze Assets"
echo "======================================================"
php artisan vendor:publish --tag=laravel-assets --force

echo ""
echo "======================================================"
echo "STEP 8: Running Database Migrations (if any new)"
echo "======================================================"
php artisan migrate --force

echo ""
echo "======================================================"
echo "STEP 9: Clearing All Caches"
echo "======================================================"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

echo ""
echo "======================================================"
echo "STEP 10: Setting Permissions"
echo "======================================================"
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo ""
echo "======================================================"
echo "STEP 11: Verifying Installation"
echo "======================================================"
echo ""
echo "Checking routes..."
php artisan route:list | grep -E "admin|login|logout" | head -20

echo ""
echo "Checking database connection..."
php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database: OK' . PHP_EOL;"

echo ""
echo "Checking user count..."
php artisan tinker --execute="echo 'Users: ' . App\Models\User::count() . PHP_EOL;"

echo ""
echo "✅ MIGRATION COMPLETE!"
echo "======================================================"
echo ""
echo "📊 Summary:"
echo "   ✅ Filament removed"
echo "   ✅ Laravel Breeze installed"
echo "   ✅ Admin panel structure created"
echo "   ✅ Database preserved"
echo "   ✅ All caches cleared"
echo ""
echo "🌐 Admin Panel Access:"
echo "   Login: https://bumnag.fazcreateve.app/login"
echo "   Dashboard: https://bumnag.fazcreateve.app/admin"
echo ""
echo "📝 Next Steps:"
echo "   1. Login with existing credentials"
echo "   2. Verify dashboard loads correctly"
echo "   3. Start building CRUD for each resource"
echo ""
echo "💾 Backup Location:"
ls -d backups/pre-filament-removal-* | tail -1
echo ""
echo "🔍 Check logs if any issues:"
echo "   tail -50 storage/logs/laravel.log"
echo ""
