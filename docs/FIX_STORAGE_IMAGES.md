# 🖼️ PANDUAN FIX GAMBAR STORAGE TIDAK TAMPIL

## 🔥 MASALAH

Gambar yang diupload tidak tampil di website setelah deploy ke shared hosting.

**Penyebab:**
1. ❌ `APP_URL=http://localhost` di `.env` production
2. ❌ Symlink `public/storage` tidak berfungsi di shared hosting
3. ❌ Path mismatch antara local dan server

---

## ✅ SOLUSI CEPAT (Copy-Paste)

### **METODE 1: Automatic Script** ⚡ (RECOMMENDED)

**Upload file `fix-storage-images.sh` ke server, lalu:**

```bash
cd ~/bumnag  # atau path project kamu
chmod +x fix-storage-images.sh
./fix-storage-images.sh
```

**Script akan otomatis:**
- ✅ Remove symlink lama
- ✅ Buat folder `public/storage` (physical)
- ✅ Copy semua file dari `storage/app/public/` ke `public/storage/`
- ✅ Set permissions yang benar
- ✅ Buat script sync untuk future uploads

**Setelah itu, edit `.env`:**
```bash
nano .env
```

Ganti:
```env
APP_URL=http://localhost
```

Menjadi:
```env
APP_URL=https://your-domain.com  # GANTI dengan domain asli!
```

**Clear cache:**
```bash
php artisan config:cache
php artisan route:cache
php artisan optimize
```

**Test:**
```bash
# Buka browser:
https://your-domain.com/storage/bumnag/logos/your-logo.png
```

---

### **METODE 2: Manual Steps** 🛠️

**Step 1: Fix APP_URL**
```bash
cd ~/bumnag
nano .env
```

Update:
```env
APP_URL=https://bumnag-lubas-mandiri.com  # domain asli kamu
```

**Step 2: Remove Symlink**
```bash
# Check if symlink exists
ls -la public/storage

# Remove it
rm -f public/storage
```

**Step 3: Create Physical Directory**
```bash
mkdir -p public/storage
```

**Step 4: Copy All Files**
```bash
# Copy everything from storage/app/public to public/storage
cp -r storage/app/public/* public/storage/

# Or use rsync (better)
rsync -av storage/app/public/ public/storage/
```

**Step 5: Set Permissions**
```bash
chmod -R 755 public/storage
chmod -R 775 storage/app/public
```

**Step 6: Clear Caches**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Step 7: Test**
```bash
# List files
ls -la public/storage/

# Test via curl
curl -I https://your-domain.com/storage/bumnag/logos/logo.png
# Should return: HTTP/1.1 200 OK
```

---

### **METODE 3: Setup Cron Job (Auto-Sync)** 🔄

Untuk **auto-sync** setiap kali ada upload baru via admin:

**Step 1: Buat cron job**
```bash
crontab -e
```

**Step 2: Tambahkan line ini:**
```cron
# Sync storage every 5 minutes
*/5 * * * * cd ~/bumnag && rsync -aq storage/app/public/ public/storage/ > /dev/null 2>&1

# Or run sync script
*/5 * * * * cd ~/bumnag && ./sync-storage.sh > /dev/null 2>&1
```

**Alternative: Manual Sync After Upload**

Setiap habis upload gambar via admin panel, jalankan:
```bash
./sync-storage.sh
```

---

## 🧪 VERIFIKASI

### Check di Terminal:

```bash
# 1. Check APP_URL
cat .env | grep APP_URL
# Harus: https://your-domain.com (BUKAN localhost!)

# 2. Check public/storage exists (BUKAN symlink)
ls -la public/storage
# Harus: drwxr-xr-x (bukan lrwxrwxrwx yang artinya symlink)

# 3. Check files exist
ls -la public/storage/bumnag/logos/
ls -la public/storage/news/featured/

# 4. Check permissions
ls -la storage/app/public/

# 5. Test URL
curl -I https://your-domain.com/storage/bumnag/logos/logo.png
# Harus return: HTTP/1.1 200 OK (BUKAN 404)
```

### Check di Browser:

1. **Direct image URL:**
   ```
   https://your-domain.com/storage/bumnag/logos/logo.png
   ```
   Harus tampil gambar (BUKAN 404)

2. **Check homepage:**
   - Logo header harus tampil
   - Banner BUMNag harus tampil
   - News featured images harus tampil

3. **Inspect element (F12):**
   - Klik kanan pada gambar yang tidak tampil
   - Pilih "Inspect" atau "Inspect Element"
   - Lihat URL `src` attribute
   - Harus: `https://your-domain.com/storage/...` (BUKAN `http://localhost/storage/...`)

---

## 🔧 TROUBLESHOOTING

### Problem 1: Gambar masih 404

**Check:**
```bash
# File ada di storage?
ls -la storage/app/public/bumnag/logos/

# File ada di public/storage?
ls -la public/storage/bumnag/logos/

# APP_URL benar?
cat .env | grep APP_URL
```

**Solution:**
```bash
# Re-copy files
rsync -av storage/app/public/ public/storage/

# Re-cache config
php artisan config:cache
```

---

### Problem 2: URL masih http://localhost/storage/...

**Solution:**
```bash
# Edit .env
nano .env
# Update APP_URL

# Clear ALL caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache

# Restart PHP-FPM (if available)
sudo systemctl restart php8.1-fpm
```

---

### Problem 3: Permission Denied

**Solution:**
```bash
# Fix permissions
chmod -R 755 public/storage
chmod -R 775 storage/app/public

# Fix ownership (cPanel)
chown -R $(whoami):$(whoami) storage public/storage

# Or (jika pakai www-data)
sudo chown -R www-data:www-data storage public/storage
```

---

### Problem 4: Images hilang setelah upload baru

**Solution:**

Setiap kali upload gambar via admin, jalankan:
```bash
./sync-storage.sh
```

Atau setup cron job (lihat Metode 3 di atas).

---

### Problem 5: Symlink tetap dibuat ulang

Laravel mungkin auto-create symlink di beberapa case. **Disable** dengan:

**Option A: Edit `filesystems.php`**

```bash
nano config/filesystems.php
```

Comment out symlink config:
```php
'links' => [
    // public_path('storage') => storage_path('app/public'),
],
```

**Option B: Override storage:link command**

Buat file `app/Console/Commands/StorageLink.php`:
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StorageLink extends Command
{
    protected $signature = 'storage:link';
    protected $description = 'Copy storage files instead of symlink';

    public function handle()
    {
        $this->info('Copying storage files...');
        
        exec('rsync -av storage/app/public/ public/storage/');
        
        $this->info('✓ Storage files copied successfully!');
        $this->warn('⚠ Remember to run ./sync-storage.sh after new uploads');
    }
}
```

---

## 📋 CHECKLIST FINAL

```
BEFORE:
[ ] Backup .env file
[ ] Backup storage folders

FIX:
[ ] Run fix-storage-images.sh (atau manual steps)
[ ] Update APP_URL di .env
[ ] Clear all Laravel caches
[ ] Set proper permissions

VERIFY:
[ ] ls -la public/storage (harus ada files, BUKAN symlink)
[ ] cat .env | grep APP_URL (harus production URL)
[ ] curl -I https://domain.com/storage/test.jpg (harus 200)
[ ] Browser test: logo & images tampil

MAINTENANCE:
[ ] Setup sync-storage.sh script
[ ] Setup cron job (optional)
[ ] Test upload image via admin
[ ] Run sync-storage.sh after upload
```

---

## 🎯 KESIMPULAN

**Untuk shared hosting, JANGAN gunakan symlink!**

**Gunakan physical copy:**
```bash
storage/app/public/  →  COPY TO  →  public/storage/
```

**Key points:**
1. ✅ APP_URL harus production URL (BUKAN localhost)
2. ✅ public/storage harus **folder biasa** (BUKAN symlink)
3. ✅ Sync files setiap habis upload (manual atau cron)
4. ✅ Permissions: 755 untuk public, 775 untuk storage

---

## 📞 Quick Commands

```bash
# Fix semua (one-liner)
./fix-storage-images.sh && nano .env && php artisan optimize:clear && php artisan config:cache

# Sync after upload
./sync-storage.sh

# Test image URL
curl -I https://your-domain.com/storage/bumnag/logos/logo.png

# Check file count
echo "Storage: $(find storage/app/public -type f | wc -l) files"
echo "Public: $(find public/storage -type f | wc -l) files"
```

---

**Files created:**
- ✅ `fix-storage-images.sh` - Automated fix script
- ✅ `sync-storage.sh` - Sync script for new uploads
- ✅ This documentation

**Last Updated:** February 8, 2026  
**Laravel Version:** 10.50.0
