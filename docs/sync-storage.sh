#!/bin/bash

# =========================================
# SYNC STORAGE FILES
# =========================================
# Run this script AFTER uploading images via admin panel
# to sync storage/app/public -> public/storage

echo "🔄 Syncing storage files..."

# Use rsync for efficient sync (only changed files)
rsync -av --delete storage/app/public/ public/storage/

echo "✅ Storage synced successfully!"
echo ""
echo "📊 Files in public/storage:"
find public/storage -type f | wc -l
