#!/bin/bash

# =========================================
# FIX STORAGE IMAGES - Shared Hosting
# =========================================
# Script ini memperbaiki masalah gambar tidak tampil
# di shared hosting dengan copy physical files
# instead of symlinks

echo "🖼️  Fixing Storage Images for Shared Hosting"
echo "=============================================="
echo ""

# Deteksi project path
if [ -z "$1" ]; then
    PROJECT_PATH="$PWD"
else
    PROJECT_PATH="$1"
fi

echo "📂 Project path: $PROJECT_PATH"
echo ""

# Check if project exists
if [ ! -f "$PROJECT_PATH/artisan" ]; then
    echo "❌ Error: Not a Laravel project (artisan not found)"
    echo "Usage: ./fix-storage-images.sh [project_path]"
    exit 1
fi

cd "$PROJECT_PATH"

# Step 1: Remove old symlink
echo "🗑️  Step 1: Removing old storage symlink..."
if [ -L "public/storage" ]; then
    rm -f public/storage
    echo "   ✓ Symlink removed"
elif [ -d "public/storage" ]; then
    echo "   ⚠️  public/storage is a directory (not symlink)"
    read -p "   Remove it? (y/n): " confirm
    if [ "$confirm" = "y" ]; then
        rm -rf public/storage
        echo "   ✓ Directory removed"
    fi
else
    echo "   ℹ️  No existing storage link"
fi

echo ""

# Step 2: Create physical directory
echo "📁 Step 2: Creating physical storage directory..."
mkdir -p public/storage
echo "   ✓ Directory created"

echo ""

# Step 3: Copy all files from storage/app/public
echo "📋 Step 3: Copying files from storage/app/public to public/storage..."
if [ -d "storage/app/public" ]; then
    cp -r storage/app/public/* public/storage/ 2>/dev/null || echo "   ℹ️  No files to copy yet"
    echo "   ✓ Files copied"
else
    echo "   ⚠️  storage/app/public not found, creating..."
    mkdir -p storage/app/public
fi

echo ""

# Step 4: Set permissions
echo "🔒 Step 4: Setting proper permissions..."
chmod -R 755 public/storage
chmod -R 775 storage/app/public
echo "   ✓ Permissions set"

echo ""

# Step 5: Create sync script for future uploads
echo "📝 Step 5: Creating auto-sync script..."
cat > sync-storage.sh << 'SYNCEOF'
#!/bin/bash
# Auto-sync storage files
rsync -av --delete storage/app/public/ public/storage/
echo "✓ Storage synced"
SYNCEOF

chmod +x sync-storage.sh
echo "   ✓ sync-storage.sh created"

echo ""

# Step 6: Verify
echo "✅ Step 6: Verification..."
echo ""
echo "   Checking directories:"
ls -la public/ | grep storage
echo ""

if [ -d "public/storage" ]; then
    echo "   ✓ public/storage exists"
    FILE_COUNT=$(find public/storage -type f 2>/dev/null | wc -l)
    echo "   ✓ Files in public/storage: $FILE_COUNT"
else
    echo "   ❌ public/storage not found"
fi

echo ""
echo "=============================================="
echo "✅ Storage fix completed!"
echo ""
echo "📌 IMPORTANT NOTES:"
echo ""
echo "1. Update .env file:"
echo "   APP_URL=https://your-domain.com  (ganti dengan domain asli!)"
echo ""
echo "2. Clear caches:"
echo "   php artisan config:cache"
echo "   php artisan route:cache"
echo ""
echo "3. When uploading NEW files via admin:"
echo "   Run: ./sync-storage.sh"
echo "   (Or setup cron job untuk auto-sync)"
echo ""
echo "4. Test images:"
echo "   https://your-domain.com/storage/test.jpg"
echo ""
echo "=============================================="
