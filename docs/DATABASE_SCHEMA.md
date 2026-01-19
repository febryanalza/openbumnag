# 📊 Database Schema - Website BUMNag

## Struktur Database Lengkap

### 1. **categories** - Kategori Konten
```sql
- id (PK)
- name (varchar) - Nama kategori
- slug (varchar, unique) - URL slug
- description (text) - Deskripsi
- type (varchar) - Type: general, news, report, promotion
- icon (varchar) - Heroicon name
- color (varchar) - Hex color code
- is_active (boolean) - Status aktif
- order (int) - Urutan tampilan
- created_at, updated_at, deleted_at (timestamps)
```

### 2. **news** - Berita & Artikel
```sql
- id (PK)
- category_id (FK) - Relasi ke categories
- user_id (FK) - Penulis
- title (varchar) - Judul berita
- slug (varchar, unique) - URL slug
- excerpt (text) - Ringkasan
- content (longtext) - Konten utama dengan HTML dari Rich Editor
- featured_image (varchar) - Path gambar utama
- images (json) - Array path gambar galeri
- status (varchar) - draft, published, archived
- is_featured (boolean) - Tampil di beranda
- views (int) - Jumlah views
- published_at (datetime) - Tanggal publikasi
- meta_title, meta_description, meta_keywords (SEO)
- created_at, updated_at, deleted_at (timestamps)

Indexes:
- status, published_at
- is_featured
```

### 3. **reports** - Laporan
```sql
- id (PK)
- category_id (FK)
- user_id (FK)
- title (varchar) - Judul laporan
- slug (varchar, unique)
- description (text)
- type (varchar) - financial, activity, annual, monthly, quarterly
- period (varchar) - Contoh: "2024", "Q1-2024", "Jan-2024"
- year (int) - Tahun
- month (int, nullable) - Bulan (1-12)
- quarter (int, nullable) - Triwulan (1-4)
- file_path (varchar) - Path file laporan (PDF/Excel/Word)
- file_type (varchar) - pdf, excel, doc
- file_size (bigint) - Ukuran file dalam bytes
- cover_image (varchar) - Path cover image
- content (longtext) - Konten tambahan
- status (varchar) - draft, published, archived
- downloads (int) - Jumlah download
- published_at (datetime)
- created_at, updated_at, deleted_at

Indexes:
- type, year, status
- published_at
```

### 4. **promotions** - Promosi Produk/Layanan
```sql
- id (PK)
- category_id (FK)
- user_id (FK)
- title (varchar) - Judul promosi
- slug (varchar, unique)
- excerpt (text)
- description (longtext) - Deskripsi lengkap
- featured_image (varchar)
- images (json) - Galeri gambar
- original_price (decimal 15,2) - Harga normal
- discount_price (decimal 15,2) - Harga setelah diskon
- discount_percentage (int) - Persentase diskon
- promotion_type (varchar) - product, service, event, package
- contact_person (varchar) - Nama kontak
- contact_phone (varchar)
- contact_email (varchar)
- location (varchar) - Lokasi
- terms_conditions (text) - Syarat & ketentuan
- start_date (datetime) - Mulai promosi
- end_date (datetime) - Berakhir promosi
- status (varchar) - draft, active, expired, archived
- is_featured (boolean)
- views (int)
- created_at, updated_at, deleted_at

Indexes:
- status, start_date, end_date
- is_featured
```

### 5. **bumnag_profiles** - Profil BUMNag
```sql
- id (PK)
- name (varchar) - Nama BUMNag
- nagari_name (varchar) - Nama Nagari
- slug (varchar, unique)
- tagline (text)
- about, vision, mission, values, history (longtext)
- logo, banner (varchar) - Path file
- images (json) - Galeri gambar

Legal Information:
- legal_entity_number (varchar) - Nomor badan hukum
- established_date (date) - Tanggal pendirian
- notary_name (varchar) - Nama notaris
- deed_number (varchar) - Nomor akta

Contact Information:
- address (text)
- postal_code (varchar)
- phone, fax, email, website (varchar)

Social Media:
- facebook, instagram, twitter, youtube, tiktok, whatsapp (varchar)

Geo Location:
- latitude (decimal 10,7)
- longitude (decimal 10,7)

- operating_hours (json) - Jam operasional per hari
- is_active (boolean)
- created_at, updated_at, deleted_at
```

### 6. **galleries** - Galeri Media
```sql
- id (PK)
- user_id (FK)
- title (varchar)
- description (text)
- file_path (varchar) - Path file
- file_type (varchar) - image, video
- mime_type (varchar)
- file_size (bigint)
- type (varchar) - gallery, event, activity, product
- album (varchar) - Nama album
- taken_date (date) - Tanggal pengambilan
- photographer (varchar)
- location (varchar)
- is_featured (boolean)
- order (int)
- views (int)
- created_at, updated_at, deleted_at

Indexes:
- type, album
- is_featured
```

### 7. **team_members** - Tim Pengurus
```sql
- id (PK)
- name (varchar)
- position (varchar) - Jabatan
- division (varchar) - Divisi
- bio (text) - Biografi
- photo (varchar) - Path foto
- email, phone (varchar)
- facebook, instagram, twitter, linkedin (varchar) - Social media
- order (int) - Urutan tampilan
- is_active (boolean)
- created_at, updated_at, deleted_at

Indexes:
- position
- is_active
```

### 8. **settings** - Pengaturan Website
```sql
- id (PK)
- key (varchar, unique) - Nama setting
- value (text) - Nilai setting
- type (varchar) - text, textarea, boolean, number, json, image, file
- group (varchar) - general, seo, social, contact, appearance
- description (text) - Deskripsi setting
- order (int)
- created_at, updated_at
```

### 9. **contacts** - Pesan Masuk
```sql
- id (PK)
- name (varchar) - Nama pengirim
- email (varchar)
- phone (varchar)
- subject (varchar) - Subjek
- message (text) - Pesan
- status (varchar) - new, read, replied, archived
- reply (text) - Balasan admin
- replied_at (datetime)
- replied_by (FK to users)
- ip_address, user_agent (varchar) - Info pengirim
- created_at, updated_at, deleted_at

Indexes:
- status
- created_at
```

### 10. **users** - User Admin (Laravel Default)
```sql
- id (PK)
- name (varchar)
- email (varchar, unique)
- email_verified_at (datetime)
- password (varchar)
- remember_token (varchar)
- created_at, updated_at
```

## Relasi Database

### One to Many
- `categories` → `news` (category_id)
- `categories` → `reports` (category_id)
- `categories` → `promotions` (category_id)
- `users` → `news` (user_id)
- `users` → `reports` (user_id)
- `users` → `promotions` (user_id)
- `users` → `galleries` (user_id)
- `users` → `contacts` (replied_by)

## JSON Fields

### news.images
```json
[
  "news/gallery/image1.jpg",
  "news/gallery/image2.jpg"
]
```

### promotions.images
```json
[
  "promotions/gallery/promo1.jpg",
  "promotions/gallery/promo2.jpg"
]
```

### bumnag_profiles.operating_hours
```json
{
  "senin": "08:00 - 16:00",
  "selasa": "08:00 - 16:00",
  "rabu": "08:00 - 16:00",
  "kamis": "08:00 - 16:00",
  "jumat": "08:00 - 16:00",
  "sabtu": "Tutup",
  "minggu": "Tutup"
}
```

### bumnag_profiles.images
```json
[
  "profiles/image1.jpg",
  "profiles/image2.jpg"
]
```

## Contoh Query

### Get Published News with Category
```php
News::with('category', 'user')
    ->where('status', 'published')
    ->whereNotNull('published_at')
    ->where('published_at', '<=', now())
    ->orderBy('published_at', 'desc')
    ->get();
```

### Get Active Promotions
```php
Promotion::where('status', 'active')
    ->where(function($q) {
        $q->whereNull('start_date')
          ->orWhere('start_date', '<=', now());
    })
    ->where(function($q) {
        $q->whereNull('end_date')
          ->orWhere('end_date', '>=', now());
    })
    ->get();
```

### Get Reports by Year
```php
Report::where('year', 2024)
    ->where('type', 'financial')
    ->where('status', 'published')
    ->orderBy('month')
    ->get();
```

## Soft Deletes

Semua tabel utama (kecuali `settings` dan `users`) menggunakan soft deletes:
- Data tidak benar-benar dihapus dari database
- Field `deleted_at` akan terisi saat data "dihapus"
- Data bisa di-restore kembali

## Best Practices

1. **Selalu gunakan slug yang unique** untuk SEO-friendly URLs
2. **Set published_at** untuk scheduling publikasi
3. **Gunakan is_featured** untuk highlight konten penting
4. **Tracking views** untuk analytics
5. **Soft deletes** untuk keamanan data
6. **Indexes** sudah diterapkan untuk performa query

---

**Note**: Schema ini sudah optimal untuk website BUMNag dengan fitur lengkap.
