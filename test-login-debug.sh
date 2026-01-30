#!/bin/bash

echo "🔍 Comprehensive Login Debugging"
echo "=================================="
echo ""

# Pull latest code
echo "[1/5] Pulling latest debugging code..."
git pull origin main

# Clear all caches
echo "[2/5] Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan optimize:clear

# Ensure log files exist and are writable
echo "[3/5] Preparing log files..."
touch storage/logs/laravel.log
touch storage/logs/filament-debug.log
touch storage/logs/filament-login-direct.log
chmod 666 storage/logs/*.log

echo "✅ Log files ready:"
ls -lh storage/logs/*.log

# Check Filament configuration
echo ""
echo "[4/5] Checking Filament configuration..."
curl -s https://bumnag.fazcreateve.app/debug/filament/config | jq '.'

echo ""
echo "[5/5] Test Instructions"
echo "======================="
echo ""
echo "Now perform these steps:"
echo ""
echo "1. Open browser: https://bumnag.fazcreateve.app/admin/login"
echo "2. Enter credentials:"
echo "   Email: admin@bumnag.com"
echo "   Password: bumagbersatu24"
echo "3. Click 'Sign in'"
echo ""
echo "Then run these commands to check logs:"
echo ""
echo "# Main Laravel log"
echo "tail -20 storage/logs/laravel.log"
echo ""
echo "# Middleware debug log"
echo "tail -20 storage/logs/filament-debug.log"
echo ""
echo "# Direct login method log"
echo "tail -20 storage/logs/filament-login-direct.log"
echo ""
echo "Waiting for you to try login..."
echo "Press Enter after attempting login to view logs..."
read

echo ""
echo "📋 SHOWING LOGS"
echo "==============="
echo ""

echo "🔵 Middleware Log (filament-debug.log):"
echo "----------------------------------------"
tail -30 storage/logs/filament-debug.log
echo ""

echo "🔴 Direct Login Log (filament-login-direct.log):"
echo "-------------------------------------------------"
if [ -f storage/logs/filament-login-direct.log ]; then
    cat storage/logs/filament-login-direct.log
else
    echo "❌ File does not exist - Login class NOT CALLED!"
fi
echo ""

echo "🟢 Laravel Log (last 30 lines):"
echo "--------------------------------"
tail -30 storage/logs/laravel.log | grep -i "login\|auth\|filament" || echo "No login-related entries found"
echo ""

echo "📊 Analysis:"
echo "============"
echo ""

if [ -f storage/logs/filament-login-direct.log ] && [ -s storage/logs/filament-login-direct.log ]; then
    echo "✅ Custom Login class WAS called"
    echo "   → Check logs above for error details"
else
    echo "❌ Custom Login class NOT called"
    echo "   → Filament might be using default login"
    echo "   → Check Filament config above"
fi

echo ""
echo "Next steps based on results above..."
