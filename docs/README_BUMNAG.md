# 📰 Website BUMNag - Platform Profil, Berita, Laporan & Promosi

Website profesional untuk Badan Usaha Milik Nagari (BUMNag) yang dibangun dengan **Laravel 11** dan **Filament 4**.

## ✨ Fitur Utama

### 🎯 Modul Konten
- **📰 Berita** - Sistem berita dengan Rich Text Editor yang mendukung upload gambar inline
- **📊 Laporan** - Manajemen laporan keuangan dan kegiatan dengan upload file PDF/Excel/Word
- **📢 Promosi** - Promosi produk dan layanan dengan sistem diskon otomatis
- **🏢 Profil BUMNag** - Profil lengkap organisasi dengan visi, misi, dan kontak
- **👥 Tim Pengurus** - Daftar pengurus dan karyawan
- **📸 Galeri** - Galeri foto dan video kegiatan
- **📬 Pesan Masuk** - Formulir kontak dari pengunjung
- **⚙️ Pengaturan** - Pengaturan website dinamis

### 🎨 Keunggulan
✅ **Rich Text Editor** untuk berita dengan kemampuan:
- Upload gambar langsung ke dalam konten
- Gambar bisa ditempatkan di awal, tengah, atau akhir artikel
- Support multiple gambar dalam satu artikel
- Image editor built-in untuk crop dan resize

✅ **Professional UI/UX**:
- Interface admin berbahasa Indonesia
- Grouped navigation dengan icon Heroicon
- Form dengan sections dan validasi
- Table dengan filter dan search
- Badge dan status visual

✅ **SEO Friendly**:
- Meta title, description, dan keywords
- URL slugs otomatis
- Sitemap ready

## 📦 Database Schema

### Tabel Utama
1. **categories** - Kategori untuk news, reports, promotions
2. **news** - Berita dan artikel
3. **reports** - Laporan (keuangan, kegiatan, tahunan, bulanan)
4. **promotions** - Promosi dengan sistem harga dan diskon
5. **bumnag_profiles** - Profil BUMNag
6. **galleries** - Gallery media
7. **team_members** - Tim pengurus
8. **settings** - Pengaturan dinamis
9. **contacts** - Pesan dari pengunjung

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2+
- MySQL/MariaDB
- Composer
- Node.js & NPM

### Langkah Instalasi

1. **Clone atau buka project**
```bash
cd d:\Belajar_Bebas\Project\bumnag
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
Edit file `.env` dan sesuaikan:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bumnag
DB_USERNAME=root
DB_PASSWORD=
```

5. **Jalankan Migration & Seeder**
```bash
php artisan migrate:fresh --seed
```

6. **Buat Storage Link**
```bash
php artisan storage:link
```

7. **Buat User Admin Filament**
```bash
php artisan make:filament-user
```
Masukkan:
- Name: Admin
- Email: admin@bumnag.id
- Password: password (atau password pilihan Anda)

8. **Compile Assets**
```bash
npm run dev
```

9. **Jalankan Server**
```bash
php artisan serve
```

## 🎯 Akses Website

- **Website Public**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin
- Login dengan user yang dibuat di step 7

## 📝 Cara Menggunakan

### Membuat Berita dengan Gambar

1. Login ke admin panel
2. Klik menu **Berita** → **Buat Baru**
3. Isi form:
   - **Kategori**: Pilih atau buat kategori baru
   - **Judul**: Judul berita (slug otomatis)
   - **Ringkasan**: Ringkasan singkat
   - **Konten**: Gunakan Rich Editor
     - Klik icon 📎 (Attachment) untuk upload gambar
     - Gambar akan langsung muncul di posisi kursor
     - Anda bisa tambah banyak gambar di berbagai posisi
   - **Gambar Utama**: Upload featured image
   - **Galeri**: Upload multiple images (opsional)
   - **Status**: Draft/Published
   - **Tampilkan di Beranda**: Toggle untuk featured news
4. Klik **Simpan**

### Membuat Laporan

1. Klik menu **Laporan** → **Buat Baru**
2. Pilih tipe laporan (Keuangan, Kegiatan, dll)
3. Set periode (Tahun, Bulan, Triwulan)
4. Upload file PDF/Excel/Word
5. Upload cover image (opsional)
6. Tambah konten dengan Rich Editor
7. Set status dan publish

### Membuat Promosi

1. Klik menu **Promosi** → **Buat Baru**
2. Isi informasi promosi
3. Set harga normal dan diskon (persentase dihitung otomatis)
4. Upload gambar dan galeri
5. Tambah kontak person dan lokasi
6. Set periode promosi (start & end date)
7. Tambah syarat dan ketentuan

## 🗂️ Struktur File

```
app/
├── Filament/
│   └── Resources/
│       ├── News/          # Resource berita dengan Rich Editor
│       ├── Reports/       # Resource laporan
│       ├── Promotions/    # Resource promosi
│       ├── BumnagProfiles/# Resource profil
│       ├── Categories/    # Resource kategori
│       ├── Galleries/     # Resource galeri
│       ├── TeamMembers/   # Resource tim
│       ├── Contacts/      # Resource pesan
│       └── Settings/      # Resource pengaturan
└── Models/
    ├── News.php           # Model berita
    ├── Report.php         # Model laporan
    ├── Promotion.php      # Model promosi
    └── ...

database/
├── migrations/            # 9 migrations untuk semua tabel
└── seeders/
    ├── CategorySeeder.php # Data kategori awal
    └── BumnagProfileSeeder.php # Data profil contoh
```

## 🎨 Customisasi

### Ubah Logo & Branding
Edit di Filament Panel Provider:
```php
app/Providers/Filament/AdminPanelProvider.php
```

### Tambah Field di Form
Edit file di:
```php
app/Filament/Resources/{Resource}/Schemas/{Resource}Form.php
```

### Ubah Kolom Table
Edit file di:
```php
app/Filament/Resources/{Resource}/Tables/{Resource}Table.php
```

## 📸 Storage

File-file akan disimpan di:
- **Berita Featured**: `storage/app/public/news/featured/`
- **Berita Attachments**: `storage/app/public/news/attachments/`
- **Berita Gallery**: `storage/app/public/news/gallery/`
- **Laporan Files**: `storage/app/public/reports/files/`
- **Laporan Covers**: `storage/app/public/reports/covers/`
- **Promosi**: `storage/app/public/promotions/`

## 🔐 Security

- Pastikan ubah password default admin
- Set `APP_ENV=production` di production
- Set `APP_DEBUG=false` di production
- Gunakan HTTPS di production
- Backup database secara berkala

## 🆘 Troubleshooting

### Error 500 atau Blank Page
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Upload Gambar Tidak Muncul
```bash
php artisan storage:link
```

### Error Permission
```bash
chmod -R 775 storage bootstrap/cache
```

## 📞 Support

Untuk bantuan lebih lanjut:
- Email: info@bumnag.id
- Dokumentasi Laravel: https://laravel.com/docs
- Dokumentasi Filament: https://filamentphp.com/docs

## 📄 License

Open source untuk keperluan BUMNag di Indonesia.

---

**Dibuat dengan ❤️ untuk BUMNag Indonesia**
