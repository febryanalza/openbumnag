# Panduan Pengaturan Website Dinamis

## 📋 Fitur

Website Lubas Mandiri sekarang **sepenuhnya dinamis** dan dapat dikelola melalui dashboard admin Filament tanpa perlu edit kode. Admin dapat mengubah:

✅ **Nama website dan tagline**
✅ **Hero section** (judul, deskripsi, jumlah slide, durasi autoplay)
✅ **Section titles** (Unit Usaha, Berita, Laporan, CTA)
✅ **Jumlah konten** yang ditampilkan di homepage
✅ **Informasi kontak** (alamat, telepon, email, WhatsApp)
✅ **Link media sosial** (Facebook, Instagram, Twitter, YouTube)

---

## 🚀 Cara Menggunakan

### 1. Akses Dashboard Admin

1. Login ke dashboard admin: `https://yourwebsite.com/admin`
2. Navigasi ke menu **"Kelola Pengaturan"** di sidebar

### 2. Edit Pengaturan Website

Dashboard pengaturan menggunakan **tabs** untuk memudahkan navigasi:

#### Tab "Umum"
- **Nama Website**: Nama BUMNag (contoh: "Lubas Mandiri")
- **Tagline**: Slogan website (contoh: "Badan Usaha Milik Nagari")
- **Deskripsi**: Deskripsi untuk SEO dan meta tags

#### Tab "Hero Section"
- **Judul Utama**: Teks besar di hero (contoh: "Selamat Datang di")
- **Sub-judul (Highlight)**: Teks yang di-highlight (contoh: "Lubas Mandiri")
- **Deskripsi**: Deskripsi di bawah judul
- **Maksimal Jumlah Slide**: Berapa banyak gambar slider (1-10)
- **Durasi Autoplay**: Kecepatan pergantian slide dalam millisecond (1000ms = 1 detik)

#### Tab "Unit Usaha"
- **Judul Section**: Judul bagian unit usaha
- **Deskripsi Section**: Deskripsi singkat

#### Tab "Berita"
- **Judul Section**: Judul bagian berita
- **Deskripsi Section**: Deskripsi singkat
- **Jumlah Berita di Homepage**: Berapa banyak berita ditampilkan (3-12)

#### Tab "Laporan"
- **Judul Section**: Judul bagian laporan
- **Deskripsi Section**: Deskripsi singkat
- **Jumlah Laporan di Homepage**: Berapa banyak laporan ditampilkan (3-12)

#### Tab "Call to Action"
- **Judul CTA**: Judul bagian CTA
- **Deskripsi CTA**: Deskripsi ajakan bertindak

#### Tab "Kontak"
- **Alamat**: Alamat lengkap BUMNag
- **Telepon**: Nomor telepon
- **Email**: Alamat email
- **WhatsApp**: Nomor WhatsApp (format: 6281234567890)

#### Tab "Media Sosial"
- **Facebook**: URL halaman Facebook
- **Instagram**: URL halaman Instagram
- **Twitter/X**: URL halaman Twitter
- **YouTube**: URL channel YouTube

### 3. Simpan Perubahan

Setelah selesai mengedit, klik tombol **"Simpan Pengaturan"** di bawah form.

---

## 🎨 Mengelola Gambar Hero Slider

### Cara Menambah/Edit Gambar Slider:

1. Navigasi ke menu **"Galleries"** (Galeri)
2. Klik **"Create"** untuk menambah gambar baru atau edit gambar existing
3. **Upload gambar** dan isi:
   - **Title**: Judul gambar
   - **File Type**: Pilih "Image"
   - **Is Featured**: ✅ **Centang ini** (penting agar muncul di slider)
   - **Order**: Urutan tampilan (1, 2, 3, dst)
4. Simpan

**Catatan**: Hanya gambar dengan **"Is Featured = Yes"** yang muncul di hero slider homepage. Jumlah maksimal ditentukan oleh setting "Maksimal Jumlah Slide".

---

## 🔧 Technical Details

### Arsitektur Sistem

1. **Model**: `Setting` - Menyimpan semua konfigurasi website
2. **Helper**: `SettingHelper` - Retrieve settings dengan caching
3. **Observer**: `SettingObserver` - Auto-clear cache saat settings berubah
4. **Controller**: `HomeController` - Load settings dan data dinamis
5. **Views**: `home.blade.php` - Render konten menggunakan settings

### Caching

- Settings di-**cache selama 1 jam** untuk performa optimal
- Cache **otomatis di-clear** saat admin menyimpan perubahan
- Jika perlu clear cache manual: `php artisan cache:clear`

### Database Structure

```sql
settings
- id
- key (unique)
- value
- type (text, textarea, number, boolean, json)
- group (general, hero, about, news, reports, contact, social, seo)
- description
- order
```

---

## 📝 Contoh Penggunaan

### Skenario 1: Mengubah Nama Website

1. Buka **Kelola Pengaturan**
2. Tab **"Umum"**
3. Edit field **"Nama Website"** dari "Lubas Mandiri" ke nama baru
4. Klik **"Simpan Pengaturan"**
5. Refresh halaman depan website → nama berubah otomatis

### Skenario 2: Mengubah Durasi Slider

1. Buka **Kelola Pengaturan**
2. Tab **"Hero Section"**
3. Edit **"Durasi Autoplay"** dari 5000ms ke 3000ms (lebih cepat)
4. Klik **"Simpan Pengaturan"**
5. Refresh homepage → slider berganti setiap 3 detik

### Skenario 3: Menampilkan Lebih Banyak Berita

1. Buka **Kelola Pengaturan**
2. Tab **"Berita"**
3. Edit **"Jumlah Berita di Homepage"** dari 6 ke 9
4. Klik **"Simpan Pengaturan"**
5. Refresh homepage → sekarang menampilkan 9 berita terbaru

---

## ⚠️ Tips & Best Practices

1. **Jangan hapus** settings yang sudah ada, hanya edit value-nya
2. **Backup data** sebelum melakukan perubahan besar
3. **Preview** perubahan di homepage setelah save
4. **Gunakan jumlah slide moderat** (5-7 gambar) untuk loading optimal
5. **Set durasi autoplay** tidak terlalu cepat (minimal 3000ms)
6. **Isi semua field kontak** agar footer informatif

---

## 🆘 Troubleshooting

### Perubahan tidak terlihat?

1. Clear browser cache (Ctrl+F5)
2. Clear Laravel cache: `php artisan cache:clear`
3. Pastikan sudah klik "Simpan Pengaturan"

### Slider tidak muncul?

1. Cek apakah ada gambar dengan **"Is Featured = Yes"** di Galleries
2. Cek setting **"Maksimal Jumlah Slide"** tidak 0
3. Pastikan gambar ter-upload dengan benar

### Error saat menyimpan?

1. Pastikan semua field **required** terisi
2. Cek format URL untuk media sosial (harus lengkap dengan https://)
3. Cek format nomor WhatsApp (harus angka saja dengan kode negara)

---

## 🎯 Roadmap Future Features

- [ ] Upload logo website
- [ ] Kustomisasi warna tema
- [ ] Pengaturan footer
- [ ] Multiple language support
- [ ] Advanced SEO settings
- [ ] Google Analytics integration

---

**Developed with ❤️ using Laravel Filament**
