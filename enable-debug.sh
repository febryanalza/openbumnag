#!/bin/bash

# Script untuk enable debugging sementara di production
# JANGAN LUPA DISABLE KEMBALI SETELAH SELESAI!

echo "⚠️  Enabling APP_DEBUG on production..."

# Backup .env original
cp .env .env.backup-$(date +%Y%m%d-%H%M%S)

# Enable debug
sed -i 's/APP_DEBUG=false/APP_DEBUG=true/g' .env

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear

echo "✅ DEBUG ENABLED!"
echo ""
echo "🔴 REMEMBER TO DISABLE DEBUG AFTER FIXING:"
echo "   ./disable-debug.sh"
echo ""
