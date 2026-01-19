# 📝 Panduan Rich Text Editor untuk Berita

## Fitur Rich Text Editor di Berita

Website BUMNag menggunakan **Filament Rich Editor** dengan kemampuan upload gambar inline. Ini memungkinkan Anda untuk:

✅ **Upload gambar langsung ke dalam konten**  
✅ **Menempatkan gambar di mana saja** (awal, tengah, atau akhir)  
✅ **Upload multiple gambar** dalam satu artikel  
✅ **Format teks** dengan berbagai style  

## 🎯 Cara Menggunakan Rich Editor

### 1. Membuat Berita Baru

1. Login ke **Admin Panel**: http://localhost:8000/admin
2. Klik menu **Berita** di sidebar
3. Klik tombol **Buat Baru** (Create)

### 2. Mengisi Form Berita

#### **Section: Informasi Utama**
- **Kategori**: Pilih kategori berita (Berita Umum, Kegiatan, Pengumuman)
- **Judul Berita**: Ketik judul, slug akan otomatis terisi
- **Slug URL**: URL-friendly version dari judul (bisa diedit manual)
- **Ringkasan**: Ringkasan singkat max 500 karakter

#### **Section: Konten Berita** ⭐ **PENTING**
Di section ini Anda akan menggunakan **Rich Editor** dengan fitur lengkap:

##### **Toolbar Buttons:**
- 📎 **attachFiles** - Upload gambar/file (FITUR UTAMA!)
- 📋 **blockquote** - Quote/kutipan
- **B** (bold) - Tebal
- **•** (bulletList) - List dengan bullet
- **{ }** (codeBlock) - Kode program
- **H2, H3** - Heading 2 dan 3
- **I** (italic) - Miring
- **🔗** (link) - Tambah link
- **1.** (orderedList) - List bernomor
- **↶ ↷** (undo/redo) - Batal/Ulangi
- **S̶** (strike) - Coret
- **U** (underline) - Garis bawah

### 3. Upload Gambar ke Konten (FITUR UNGGULAN!)

#### **Cara Upload Gambar:**

**Opsi 1: Melalui Toolbar**
1. Klik di posisi mana Anda ingin menempatkan gambar
2. Klik icon 📎 **Attach Files** di toolbar
3. Pilih gambar dari komputer Anda
4. Gambar akan langsung muncul di posisi kursor

**Opsi 2: Drag & Drop**
1. Drag gambar dari folder komputer
2. Drop ke area editor
3. Gambar otomatis terupload

#### **Contoh Penggunaan:**

```
[Paragraf pembuka berita...]

📎 [GAMBAR 1 - Ditempatkan di tengah paragraf]

[Lanjutan konten...]

📎 [GAMBAR 2 - Ditempatkan setelah paragraf tertentu]

[Kesimpulan berita...]

📎 [GAMBAR 3 - Ditempatkan di akhir]
```

#### **Spesifikasi Upload:**
- **Lokasi Penyimpanan**: `storage/app/public/news/attachments/`
- **Disk**: Public (bisa diakses via web)
- **Visibility**: Public
- **Format**: Semua format gambar (jpg, png, gif, webp)
- **Max Size**: Sesuai konfigurasi PHP

### 4. Upload Media Tambahan

#### **Section: Media**

**Gambar Utama (Featured Image):**
- Upload 1 gambar utama untuk thumbnail
- Lokasi: `storage/app/public/news/featured/`
- Max size: 2MB
- Fitur: Image Editor built-in
  - Crop dengan ratio: 16:9, 4:3, 1:1
  - Resize
  - Rotate

**Galeri Gambar:**
- Upload hingga 10 gambar
- Lokasi: `storage/app/public/news/gallery/`
- Reorderable (bisa diurutkan dengan drag)
- Max size per file: 2MB
- Fitur: Image Editor untuk setiap gambar

### 5. Pengaturan Publikasi

#### **Section: Publikasi**

**Status:**
- **Draft**: Belum dipublikasi (hanya admin yang bisa lihat)
- **Terbit**: Dipublikasikan ke website
- **Arsip**: Disimpan tapi tidak ditampilkan

**Waktu Publikasi:**
- Kosongkan untuk publikasi langsung
- Isi untuk schedule publikasi di waktu tertentu
- Format: DD/MM/YYYY HH:MM

**Tampilkan di Beranda:**
- Toggle ON: Berita akan muncul di slider homepage
- Toggle OFF: Hanya di halaman daftar berita

### 6. SEO Optimization

#### **Section: SEO** (Optional, Collapsible)

**Meta Title:**
- Judul untuk mesin pencari
- Max 60 karakter
- Jika kosong, akan menggunakan judul berita

**Meta Description:**
- Deskripsi untuk mesin pencari
- Max 160 karakter
- Muncul di hasil pencarian Google

**Meta Keywords:**
- Kata kunci dipisahkan koma
- Contoh: "bumnag, nagari, berita, kegiatan"

## 💡 Tips & Best Practices

### Upload Gambar dalam Konten

✅ **DO:**
- Gunakan gambar berkualitas tinggi
- Compress gambar sebelum upload (gunakan TinyPNG/Squoosh)
- Beri nama file yang deskriptif (contoh: `kegiatan-gotong-royong-2024.jpg`)
- Tempatkan gambar setelah paragraf yang relevan
- Gunakan 3-5 gambar per artikel untuk engagement optimal

❌ **DON'T:**
- Upload gambar resolusi terlalu besar (>2MB)
- Menggunakan nama file acak (contoh: `IMG_12345.jpg`)
- Menempatkan terlalu banyak gambar berturut-turut
- Upload gambar dengan watermark yang mengganggu

### Formatting Teks

**Struktur yang Baik:**
```html
Judul Berita (H1 - otomatis dari field Judul)

Paragraf pembuka...

Subjudul (gunakan H2)
Konten paragraf...

📎 Gambar relevan

Subjudul lagi (H2)
- Bullet point 1
- Bullet point 2
- Bullet point 3

📎 Gambar pendukung

Paragraf penutup...
```

### SEO Friendly Content

1. **Judul**: 
   - 50-60 karakter
   - Mengandung keyword utama
   - Menarik perhatian

2. **Slug**:
   - Pendek dan deskriptif
   - Gunakan huruf kecil
   - Pisahkan dengan dash (-)
   - Contoh: `kegiatan-gotong-royong-nagari`

3. **Excerpt**:
   - 150-160 karakter
   - Ringkasan menarik
   - Ajakan untuk membaca lebih lanjut

4. **Content**:
   - Min. 300 kata
   - Gunakan paragraf pendek (3-4 baris)
   - Gunakan heading untuk struktur
   - Tambahkan gambar untuk visual

## 🎨 Contoh Berita Lengkap

### **Judul**
"Kegiatan Gotong Royong Membersihkan Sungai Nagari Bersama BUMNag"

### **Slug**
`kegiatan-gotong-royong-sungai-2024`

### **Ringkasan**
BUMNag mengadakan kegiatan gotong royong membersihkan sungai yang diikuti oleh 150 warga nagari. Kegiatan ini bertujuan menjaga kebersihan lingkungan dan kesehatan masyarakat.

### **Konten dengan Gambar**
```
Pada hari Minggu, 18 Januari 2026, BUMNag Contoh mengadakan kegiatan 
gotong royong membersihkan Sungai Batang Nagari yang diikuti oleh 
lebih dari 150 warga dari berbagai jorong.

📎 [GAMBAR: Warga berkumpul di tepi sungai]

Antusiasme Warga Sangat Tinggi

Kegiatan yang dimulai pukul 08.00 WIB ini mendapat sambutan luar 
biasa dari masyarakat. Para warga membawa peralatan masing-masing 
seperti cangkul, sabit, dan karung untuk mengumpulkan sampah.

- Total sampah terkumpul: 500 kg
- Peserta: 150 orang
- Durasi: 4 jam

📎 [GAMBAR: Proses pembersihan sungai]

Dukungan dari BUMNag

BUMNag menyediakan berbagai fasilitas untuk mendukung kegiatan ini:
1. Penyediaan alat-alat kebersihan
2. Konsumsi untuk semua peserta
3. Transportasi pengangkutan sampah
4. Tim medis standby

📎 [GAMBAR: Hasil akhir sungai yang bersih]

"Ini adalah wujud kepedulian kita terhadap lingkungan," ujar Ketua 
BUMNag dalam sambutannya.
```

### **Status**: Published
### **Waktu Publikasi**: 18/01/2026 14:00
### **Featured**: ON
### **Meta Title**: Gotong Royong Sungai Nagari Bersama BUMNag 2024
### **Meta Description**: BUMNag mengadakan gotong royong membersihkan sungai bersama 150 warga. Terkumpul 500kg sampah untuk lingkungan lebih bersih.
### **Keywords**: gotong royong, bumnag, sungai, lingkungan, nagari

## 📊 Preview Hasil

Setelah menyimpan, berita akan:

1. **Di Halaman Admin**:
   - Muncul di tabel list berita
   - Status badge (Draft/Published)
   - Featured star (jika featured)
   - Views counter

2. **Di Website Public** (jika Published):
   - Muncul di homepage (jika featured)
   - Muncul di halaman daftar berita
   - Bisa diakses via slug URL
   - Gambar inline tampil sempurna di tengah konten
   - Gallery gambar di bagian bawah artikel

## 🔧 Troubleshooting

### Gambar Tidak Muncul di Konten
- Pastikan `php artisan storage:link` sudah dijalankan
- Check permission folder `storage/app/public/`
- Refresh browser (Ctrl+F5)

### Upload Gagal
- Check max upload size di `php.ini`:
  - `upload_max_filesize = 10M`
  - `post_max_size = 10M`
- Check disk space server
- Check permission folder

### Editor Lambat
- Compress gambar sebelum upload
- Clear browser cache
- Gunakan browser modern (Chrome, Firefox, Edge)

## 📞 Bantuan

Jika mengalami kesulitan:
1. Check dokumentasi di [README_BUMNAG.md](README_BUMNAG.md)
2. Check schema database di [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)
3. Hubungi admin sistem

---

**Happy Writing! 📰✨**

Dengan Rich Editor ini, Anda bisa membuat berita yang menarik dengan gambar yang tertata rapi seperti artikel di media online profesional!
