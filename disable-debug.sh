#!/bin/bash

# Script untuk disable debugging kembali

echo "🔒 Disabling APP_DEBUG on production..."

# Disable debug
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' .env

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear

echo "✅ DEBUG DISABLED - Production mode restored"
echo ""
