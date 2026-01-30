#!/bin/bash

#######################################################################
# CRITICAL FIX: Session Cookie Issue Behind Nginx Proxy
# Problem: Sessions not persisting, cookies not being set
# Solution: Trust Nginx proxy + configure session domain
#######################################################################

echo "🔧 Fixing Session Cookie Issue..."
echo ""

# 1. Pull latest code with TrustProxies middleware
echo "[1/6] Pulling latest code..."
git pull origin main

# 2. Update .env with session configuration
echo "[2/6] Configuring session settings..."
echo ""
echo "Add these lines to .env file:"
echo "-----------------------------------"
cat << 'EOF'
# Session Configuration (ADD OR UPDATE THESE)
SESSION_DOMAIN=bumnag.fazcreateve.app
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
EOF
echo "-----------------------------------"
echo ""
read -p "Press Enter after you've added these to .env..."

# 3. Clear all caches
echo "[3/6] Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# 4. Test cookie headers
echo "[4/6] Testing cookie configuration..."
echo ""
curl -v https://bumnag.fazcreateve.app/debug/session/cookies 2>&1 | grep -i "set-cookie"
echo ""

# 5. Test session persistence
echo "[5/6] Testing session persistence..."
echo "Calling endpoint 3 times - session_id should be SAME:"
echo ""

for i in {1..3}; do
    echo "Request #$i:"
    curl -s -c cookies.txt -b cookies.txt https://bumnag.fazcreateve.app/debug/session/persistence | grep -o '"session_id":"[^"]*"'
    sleep 1
done

echo ""
echo ""

# 6. Instructions
echo "[6/6] Next Steps:"
echo "✅ TrustProxies middleware installed"
echo "✅ Session debug endpoints available"
echo ""
echo "🧪 TEST LOGIN NOW:"
echo "   1. Open: https://bumnag.fazcreateve.app/admin/login"
echo "   2. Email: admin@bumnag.com"
echo "   3. Password: bumagbersatu24"
echo ""
echo "📊 If login still fails, check logs:"
echo "   tail -f storage/logs/laravel.log"
echo ""
echo "🔍 Additional debug endpoints:"
echo "   - GET  /debug/session/cookies    → Check cookie config"
echo "   - GET  /debug/session/persistence → Test session persist"
echo "   - POST /debug/session/auth       → Test auth flow"
echo ""

# Cleanup
rm -f cookies.txt

echo "Done! 🚀"
