#!/bin/bash

echo "🔧 Quick Diagnostic Check"
echo "========================="
echo ""

# Check if files exist
echo "1. Checking if Login class file exists..."
if [ -f app/Filament/Pages/Auth/Login.php ]; then
    echo "✅ Login.php exists"
    echo "   Class name: $(grep 'class Login' app/Filament/Pages/Auth/Login.php)"
else
    echo "❌ Login.php NOT FOUND!"
fi

echo ""
echo "2. Checking if AdminPanelProvider registers Login..."
if grep -q "Login::class" app/Providers/Filament/AdminPanelProvider.php; then
    echo "✅ Login::class registered in AdminPanelProvider"
    grep "login(" app/Providers/Filament/AdminPanelProvider.php
else
    echo "❌ Login::class NOT registered!"
fi

echo ""
echo "3. Checking if DebugFilamentLogin middleware exists..."
if [ -f app/Http/Middleware/DebugFilamentLogin.php ]; then
    echo "✅ DebugFilamentLogin.php exists"
else
    echo "❌ DebugFilamentLogin.php NOT FOUND!"
fi

echo ""
echo "4. Checking bootstrap/app.php configuration..."
if grep -q "DebugFilamentLogin" bootstrap/app.php; then
    echo "✅ DebugFilamentLogin registered in bootstrap"
    grep -A2 "DebugFilamentLogin" bootstrap/app.php
else
    echo "❌ DebugFilamentLogin NOT registered!"
fi

echo ""
echo "5. Testing /debug/filament/config endpoint..."
RESPONSE=$(curl -s https://bumnag.fazcreateve.app/debug/filament/config)
if echo "$RESPONSE" | grep -q "panel_id"; then
    echo "✅ Endpoint works!"
    echo "$RESPONSE" | head -c 200
    echo "..."
else
    echo "❌ Endpoint error or non-JSON response:"
    echo "$RESPONSE" | head -c 300
fi

echo ""
echo ""
echo "6. Fixing log file permissions..."
touch storage/logs/filament-provider.log
touch storage/logs/filament-login-direct.log
touch storage/logs/filament-debug.log
chmod 666 storage/logs/filament-*.log
echo "✅ Log files created and writable"
ls -lh storage/logs/filament-*.log

echo ""
echo "7. Manual cache clear and test..."
php artisan optimize:clear 2>&1 | head -5
echo ""

echo "8. Check Laravel log for provider boot..."
tail -10 storage/logs/laravel.log | grep -i "ADMIN PANEL PROVIDER\|LOGIN CLASS" || echo "⚠️  No provider/login logs yet"

echo ""
echo "============================================"
echo "NOW TEST:"
echo "1. Open: https://bumnag.fazcreateve.app/admin/login"
echo "2. Login with admin@bumnag.com / bumagbersatu24"
echo "3. Then run:"
echo ""
echo "   tail -50 storage/logs/laravel.log | grep -i 'LOGIN\|AUTH\|ADMIN'"
echo "   cat storage/logs/filament-login-direct.log"
echo "   tail -20 storage/logs/filament-debug.log"
echo "============================================"
