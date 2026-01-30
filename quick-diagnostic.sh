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
echo "6. Manual cache clear and test..."
php artisan optimize:clear
echo ""

echo "Now test login at: https://bumnag.fazcreateve.app/admin/login"
echo "Then check: cat storage/logs/filament-*.log"
