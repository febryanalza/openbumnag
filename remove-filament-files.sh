#!/bin/bash

echo "🗑️  REMOVING FILAMENT FILES"
echo "============================"
echo ""

echo "[1/6] Removing app/Filament folder..."
if [ -d "app/Filament" ]; then
    rm -rf app/Filament
    echo "  ✅ Removed app/Filament"
else
    echo "  ⚠️  app/Filament not found"
fi

echo "[2/6] Removing app/Providers/Filament folder..."
if [ -d "app/Providers/Filament" ]; then
    rm -rf app/Providers/Filament
    echo "  ✅ Removed app/Providers/Filament"
else
    echo "  ⚠️  app/Providers/Filament not found"
fi

echo "[3/6] Removing Filament config files..."
rm -f config/filament*.php
echo "  ✅ Removed config/filament*.php"

echo "[4/6] Removing public Filament assets..."
rm -rf public/css/filament
rm -rf public/js/filament
rm -rf public/fonts/filament
echo "  ✅ Removed public/css/filament, public/js/filament, public/fonts/filament"

echo "[5/6] Removing Filament from bootstrap/providers.php..."
if [ -f "bootstrap/providers.php" ]; then
    # Remove Filament provider lines
    sed -i.bak '/Filament/d' bootstrap/providers.php
    echo "  ✅ Cleaned bootstrap/providers.php"
fi

echo "[6/6] Checking for remaining Filament references..."
echo ""
echo "Remaining references in code:"
grep -r "Filament" app/ routes/ config/ --include="*.php" 2>/dev/null | grep -v "debug" | head -10 || echo "  ✅ No Filament references found"

echo ""
echo "✅ Filament files removed successfully!"
echo ""
echo "Next steps:"
echo "1. Run: composer install (to update dependencies)"
echo "2. Run: php artisan optimize:clear"
echo ""
