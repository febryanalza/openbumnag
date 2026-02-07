# 🖼️ STORAGE IMAGES FIX - QUICK CARD

## ❌ MASALAH
Gambar upload tidak tampil di website production (shared hosting).

---

## ✅ SOLUSI 3 LANGKAH

### 1️⃣ Run Fix Script
```bash
cd ~/bumnag
chmod +x fix-storage-images.sh
./fix-storage-images.sh
```

### 2️⃣ Update .env
```bash
nano .env
```
Ganti:
```env
APP_URL=http://localhost
```
Menjadi:
```env
APP_URL=https://your-domain.com
```

### 3️⃣ Clear Cache
```bash
php artisan config:cache
php artisan optimize
```

---

## 🧪 TEST

### Terminal:
```bash
curl -I https://your-domain.com/storage/test.jpg
# Harus return: HTTP/1.1 200 OK
```

### Browser:
```
https://your-domain.com/storage/bumnag/logos/logo.png
```
Harus tampil gambar (BUKAN 404)

---

## 🔄 SETELAH UPLOAD BARU

Setiap kali upload gambar via admin panel:
```bash
./sync-storage.sh
```

Atau setup cron job (auto-sync):
```bash
crontab -e
```
Tambahkan:
```cron
*/5 * * * * cd ~/bumnag && ./sync-storage.sh > /dev/null 2>&1
```

---

## 🆘 TROUBLESHOOTING

### Gambar masih 404?
```bash
# Check APP_URL
cat .env | grep APP_URL

# Re-copy files
rsync -av storage/app/public/ public/storage/

# Re-cache
php artisan config:cache
```

### URL masih localhost?
```bash
# Clear ALL caches
php artisan optimize:clear
php artisan config:cache
```

### Permission denied?
```bash
chmod -R 755 public/storage
chmod -R 775 storage/app/public
```

---

## 📋 CHECKLIST

```
[ ] Run fix-storage-images.sh
[ ] Update APP_URL di .env
[ ] Clear Laravel caches
[ ] Test: ls -la public/storage/
[ ] Test: curl -I domain.com/storage/test.jpg
[ ] Browser test: images tampil
[ ] Upload test image via admin
[ ] Run sync-storage.sh
[ ] Images baru tampil
```

---

## 🔑 KEY POINTS

1. ✅ **APP_URL** harus production domain (BUKAN localhost)
2. ✅ **public/storage** harus folder biasa (BUKAN symlink)  
3. ✅ **Sync files** setiap habis upload (manual atau cron)
4. ✅ **Permissions**: 755 public, 775 storage

---

## 📖 FULL DOCS
→ [FIX_STORAGE_IMAGES.md](FIX_STORAGE_IMAGES.md)

---

**Updated:** Feb 8, 2026
