#!/bin/bash

echo "🚨 EMERGENCY FIX: Reset to Default Filament Configuration"
echo "=========================================================="
echo ""

# Pull latest code
echo "[1/4] Pulling emergency fix..."
git pull origin main

# Clear ALL caches aggressively
echo ""
echo "[2/4] Clearing ALL caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
php artisan filament:clear-cached-components 2>/dev/null || true

# Fix permissions
echo ""
echo "[3/4] Fixing permissions..."
chmod -R 775 storage bootstrap/cache
chmod -R 666 storage/logs/*.log 2>/dev/null || true

# List users
echo ""
echo "[4/4] Available users:"
php artisan tinker --execute="App\Models\User::all(['id','email'])->each(fn(\$u) => print(\$u->id . ': ' . \$u->email . PHP_EOL));"

echo ""
echo "============================================"
echo "✅ Configuration reset to DEFAULT Filament"
echo "============================================"
echo ""
echo "Now you have 3 options to login:"
echo ""
echo "OPTION 1: Normal Login (via browser)"
echo "   URL: https://bumnag.fazcreateve.app/admin/login"
echo "   Email: admin@bumnag.com"
echo "   Password: bumagbersatu24"
echo ""
echo "OPTION 2: Emergency Force Login (bypass all auth)"
echo "   URL: https://bumnag.fazcreateve.app/debug/force-login"
echo "   (Auto login as admin@bumnag.com)"
echo ""
echo "OPTION 3: Emergency with different user"
echo "   URL: https://bumnag.fazcreateve.app/debug/force-login/admin@admin.com"
echo ""
echo "⚠️  IMPORTANT: Test OPTION 1 first!"
echo "    Only use OPTION 2/3 if normal login still fails."
echo ""
echo "After successful login, check:"
echo "   tail -50 storage/logs/laravel.log"
echo ""
