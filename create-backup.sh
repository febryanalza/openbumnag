#!/bin/bash

echo "📦 BACKUP: Creating backup before removing Filament"
echo "===================================================="
echo ""

BACKUP_DIR="backups/pre-filament-removal-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"

echo "[1/5] Backing up composer files..."
cp composer.json "$BACKUP_DIR/"
cp composer.lock "$BACKUP_DIR/"

echo "[2/5] Backing up app/Filament folder..."
cp -r app/Filament "$BACKUP_DIR/" 2>/dev/null || echo "  (Filament folder not found)"

echo "[3/5] Backing up Filament providers..."
cp -r app/Providers/Filament "$BACKUP_DIR/" 2>/dev/null || echo "  (Filament providers not found)"

echo "[4/5] Backing up config files..."
mkdir -p "$BACKUP_DIR/config"
cp config/filament*.php "$BACKUP_DIR/config/" 2>/dev/null || echo "  (No filament configs)"

echo "[5/5] Creating inventory of current Filament resources..."
cat > "$BACKUP_DIR/INVENTORY.txt" << EOF
=== FILAMENT RESOURCES INVENTORY ===
Generated: $(date)

Resources Found:
$(find app/Filament/Resources -name "*Resource.php" 2>/dev/null | wc -l) resource files

Models Referenced:
$(grep -r "protected static ?\$model" app/Filament/Resources 2>/dev/null | cut -d'=' -f2 | sed 's/[; ]//g' | sort -u)

Database Tables (from models):
EOF

# List all models
php artisan tinker --execute="
\$models = [
    'App\Models\BumnagProfile',
    'App\Models\Catalog',
    'App\Models\Category',
    'App\Models\Contact',
    'App\Models\Gallery',
    'App\Models\News',
    'App\Models\Promotion',
    'App\Models\Report',
    'App\Models\Setting',
    'App\Models\TeamMember',
    'App\Models\User',
];

foreach (\$models as \$model) {
    if (class_exists(\$model)) {
        \$instance = new \$model;
        echo \$instance->getTable() . PHP_EOL;
    }
}
" >> "$BACKUP_DIR/INVENTORY.txt" 2>/dev/null

echo ""
echo "✅ Backup created at: $BACKUP_DIR"
echo ""
echo "Contents:"
ls -lah "$BACKUP_DIR"
echo ""

cat "$BACKUP_DIR/INVENTORY.txt"
