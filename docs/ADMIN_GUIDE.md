# 🔐 Panduan Admin Panel BUMNag Lubas Mandiri

## Untuk Administrator Website

### 1. Login ke Admin Panel

#### 🚪 Mengakses Admin Panel
1. **URL:** Buka `https://yourdomain.com/admin/login`
2. **Login Form:**
   - Masukkan **Email** administrator
   - Masukkan **Password**
   - Centang "Remember Me" untuk tetap login
3. Klik tombol **"Login"**
4. Jika berhasil, akan redirect ke Dashboard Admin

#### 🔒 Keamanan Login
- Password minimal 8 karakter
- Gunakan kombinasi huruf besar, kecil, angka, dan simbol
- Jangan share kredensial login
- Logout setelah selesai bekerja

#### 🆘 Lupa Password?
1. Klik link "Forgot Password?" di halaman login
2. Masukkan email Anda
3. Check inbox untuk link reset password
4. Klik link dan buat password baru

---

### 2. Dashboard Admin

#### 📊 Overview Dashboard
Setelah login, Anda akan melihat:
- **Total Berita:** Jumlah berita (draft + published)
- **Total Laporan:** Jumlah laporan
- **Total Katalog:** Jumlah produk
- **Pesan Masuk:** Jumlah pesan dari kontak
- **Statistik Kunjungan:** Views berita dan download laporan
- **Aktivitas Terbaru:** Log aktivitas terakhir

#### 🧭 Navigasi Sidebar
- **Dashboard:** Halaman utama admin
- **Berita:** Kelola berita dan artikel
- **Laporan:** Kelola laporan transparansi
- **Promosi:** Kelola promosi dan diskon
- **Galeri:** Kelola foto dan video
- **Katalog:** Kelola produk/layanan
- **Kategori:** Kelola kategori konten
- **Profil BUMNag:** Kelola unit usaha
- **Tim:** Kelola data anggota tim
- **Kontak:** Lihat pesan masuk
- **Pengaturan:** Setting website
- **Roles & Permissions:** Kelola hak akses (super admin only)
- **Pengguna:** Kelola user admin

---

### 3. Kelola Berita

#### ➕ Membuat Berita Baru
1. **Menu:** Sidebar → Berita → "Buat Berita Baru"
2. **Form Berita:**
   - **Judul:** Judul berita yang menarik
   - **Slug:** Otomatis dari judul (bisa edit manual)
   - **Kategori:** Pilih kategori berita
   - **Ringkasan:** Excerpt/ringkasan berita (maks 200 karakter)
   - **Konten:** Isi berita lengkap (gunakan editor WYSIWYG)
   - **Gambar Utama:** Upload featured image
   - **Galeri Gambar:** Upload gambar tambahan (opsional)
   - **Status:** Draft atau Published
   - **Featured:** Centang jika berita unggulan
   - **Tanggal Publikasi:** Pilih tanggal publish
   - **Meta SEO:** Title, Description, Keywords untuk SEO
3. **Preview:** Klik "Preview" untuk melihat tampilan
4. **Simpan:** Klik "Simpan Draft" atau "Publikasikan"

#### ✏️ Edit Berita
1. **List Berita:** Sidebar → Berita
2. **Cari Berita:** Gunakan search atau filter
3. **Aksi:**
   - **Edit:** Klik ikon pensil atau "Edit"
   - **Hapus:** Klik ikon trash (soft delete)
   - **Restore:** Berita terhapus bisa di-restore
   - **Force Delete:** Hapus permanen

#### 🔍 Filter & Pencarian Berita
- **Search:** Cari berdasarkan judul
- **Status:** Filter Draft/Published
- **Kategori:** Filter berdasarkan kategori
- **Tanggal:** Filter range tanggal
- **Featured:** Tampilkan hanya berita unggulan
- **Sort:** Urutkan berdasarkan judul, tanggal, views

#### 📦 Bulk Actions
1. Centang checkbox berita yang ingin diproses
2. Pilih action dari dropdown:
   - **Publish:** Publikasikan berita terpilih
   - **Unpublish:** Jadikan draft
   - **Delete:** Hapus berita terpilih
   - **Feature:** Tandai sebagai unggulan
3. Klik "Apply"

---

### 4. Kelola Laporan

#### ➕ Upload Laporan Baru
1. **Menu:** Sidebar → Laporan → "Upload Laporan Baru"
2. **Form Laporan:**
   - **Judul:** Nama laporan
   - **Jenis:** Laporan Keuangan / Laporan Kegiatan / Lainnya
   - **Tahun:** Tahun laporan
   - **Deskripsi:** Penjelasan singkat laporan
   - **File PDF:** Upload file laporan (PDF, maks 10MB)
   - **Tanggal Publikasi:** Tanggal publish
   - **Status:** Draft atau Published
3. **Simpan:** Klik "Simpan" atau "Publikasikan"

#### 📋 Kelola Laporan
- **Edit:** Perbarui informasi laporan
- **Ganti File:** Upload ulang jika ada revisi
- **Hapus:** Soft delete (bisa restore)
- **Statistik:** Lihat jumlah download
- **Preview:** Lihat tampilan laporan di website

#### 📊 Filter Laporan
- **Jenis Laporan:** Keuangan/Kegiatan
- **Tahun:** Filter tahun tertentu
- **Status:** Draft/Published
- **Sort:** Urutkan berdasarkan tanggal, jumlah download

---

### 5. Kelola Promosi

#### 🎉 Buat Promosi Baru
1. **Menu:** Sidebar → Promosi → "Buat Promosi"
2. **Form Promosi:**
   - **Judul Promosi:** Nama promo yang menarik
   - **Ringkasan:** Deskripsi singkat
   - **Konten:** Detail lengkap promosi
   - **Gambar Utama:** Banner promosi
   - **Diskon (%):** Persentase diskon (0-100)
   - **Tanggal Mulai:** Kapan promo dimulai
   - **Tanggal Selesai:** Kapan promo berakhir (opsional)
   - **Status:** Active/Inactive
   - **Featured:** Promosi unggulan
3. **Simpan:** Publikasikan promosi

#### ⏰ Status Promosi
- **Active:** Promosi sedang berjalan
- **Inactive:** Promosi tidak ditampilkan
- **Expired:** Otomatis jika melewati tanggal selesai
- **Featured:** Ditampilkan di homepage

#### 📊 Monitor Promosi
- Lihat jumlah views
- Track periode promosi
- Edit atau hapus promosi yang sudah selesai

---

### 6. Kelola Galeri

#### 📸 Upload Foto/Video
1. **Menu:** Sidebar → Galeri → "Upload Media"
2. **Form Upload:**
   - **Judul:** Nama foto/video
   - **Jenis:** Foto atau Video
   - **File:** Upload gambar (JPG/PNG) atau video (MP4)
   - **Album:** Kelompokkan dalam album
   - **Caption:** Deskripsi media
   - **Order:** Urutan tampilan
   - **Featured:** Tampilkan di homepage
3. **Simpan:** Upload media

#### 📁 Kelola Album
- **Buat Album:** Organisir galeri berdasarkan tema
- **Edit Album:** Ubah nama dan deskripsi
- **Move Media:** Pindahkan media antar album

#### ⚙️ Pengaturan Galeri
- **Batch Upload:** Upload banyak file sekaligus
- **Resize:** Otomatis resize gambar besar
- **Thumbnail:** Buat thumbnail otomatis
- **Delete:** Hapus media yang tidak terpakai

---

### 7. Kelola Katalog Produk

#### 🛍️ Tambah Produk Baru
1. **Menu:** Sidebar → Katalog → "Tambah Produk"
2. **Form Produk:**
   - **Nama Produk:** Nama yang jelas dan menarik
   - **Unit Usaha:** Pilih BUMNag yang mengelola
   - **Kategori:** Kategori produk
   - **Harga:** Harga satuan (Rp)
   - **Satuan:** kg, pcs, liter, dll.
   - **Stok:** Jumlah stok tersedia
   - **Deskripsi:** Informasi lengkap produk
   - **Gambar Utama:** Foto produk
   - **Status:** Tersedia/Tidak Tersedia
   - **Featured:** Produk unggulan
3. **Simpan:** Publikasikan produk

#### 📦 Update Stok
1. **List Produk:** Sidebar → Katalog
2. **Update Stok:** Klik tombol "Update Stok"
3. **Input:** Masukkan jumlah stok baru
4. **Simpan:** Stock otomatis terupdate

#### 🏷️ Manage Harga
- Edit harga produk kapan saja
- Tambahkan promosi/diskon
- Tandai produk featured untuk highlight

---

### 8. Kelola Kategori

#### 📑 Buat Kategori Baru
1. **Menu:** Sidebar → Kategori → "Buat Kategori"
2. **Form Kategori:**
   - **Nama:** Nama kategori
   - **Slug:** URL-friendly name (auto-generate)
   - **Deskripsi:** Penjelasan kategori
   - **Parent:** Kategori induk (jika sub-kategori)
   - **Order:** Urutan tampilan
3. **Simpan:** Kategori siap digunakan

#### 🔧 Kelola Kategori
- **Edit:** Ubah nama atau deskripsi
- **Delete:** Hapus kategori (pastikan tidak ada konten yang menggunakan)
- **Reorder:** Ubah urutan dengan drag-drop
- **Bulk Edit:** Edit banyak kategori sekaligus

#### 📊 Kategori untuk:
- Berita dan artikel
- Produk katalog
- Konten lainnya

---

### 9. Kelola Profil BUMNag (Unit Usaha)

#### 🏢 Tambah Unit Usaha
1. **Menu:** Sidebar → Profil BUMNag → "Tambah Profil"
2. **Form BUMNag:**
   - **Nama Unit Usaha:** Nama resmi
   - **Slug:** URL identifier
   - **Tagline:** Slogan/moto
   - **Tentang:** Deskripsi lengkap unit usaha
   - **Logo:** Upload logo unit usaha
   - **Banner:** Gambar header
   - **Alamat:** Lokasi kantor/usaha
   - **Telepon & Email:** Kontak
   - **Website:** URL website (jika ada)
   - **Status:** Active/Inactive
3. **Simpan:** Publikasikan profil

#### 📝 Edit Profil BUMNag
- Update informasi kontak
- Ganti logo atau banner
- Edit deskripsi dan layanan
- Atur status aktif/non-aktif

#### 🔗 Relasi dengan Katalog
- Setiap produk dikaitkan dengan unit usaha
- Tampilkan produk per unit usaha
- Filter produk berdasarkan BUMNag

---

### 10. Kelola Tim

#### 👥 Tambah Anggota Tim
1. **Menu:** Sidebar → Tim → "Tambah Anggota"
2. **Form Tim:**
   - **Nama Lengkap:** Nama anggota
   - **Posisi/Jabatan:** Posisi dalam organisasi
   - **Bio:** Deskripsi singkat
   - **Foto:** Upload foto profil
   - **Email & Telepon:** Kontak
   - **Sosial Media:** Link akun sosmed
   - **Order:** Urutan tampilan
   - **Status:** Active/Inactive
3. **Simpan:** Anggota ditambahkan

#### 📊 Kelola Tim
- **Edit:** Update informasi anggota
- **Reorder:** Atur urutan tampilan
- **Delete:** Hapus anggota yang sudah tidak aktif
- **Filter:** Berdasarkan posisi atau status

---

### 11. Kelola Pesan Kontak

#### 📧 Lihat Pesan Masuk
1. **Menu:** Sidebar → Kontak
2. **List Pesan:** Semua pesan dari formulir kontak
3. **Status:**
   - **Baru:** Pesan belum dibaca
   - **Dibaca:** Sudah dibuka
   - **Dibalas:** Sudah dijawab

#### 💬 Balas Pesan
1. **Buka Pesan:** Klik pada pesan untuk detail
2. **Lihat Info:**
   - Nama pengirim
   - Email dan telepon
   - Subjek dan isi pesan
   - Tanggal kirim
3. **Balas:** Klik tombol "Balas"
4. **Tulis Balasan:** Gunakan email client atau copy email pengirim
5. **Update Status:** Tandai sebagai "Dibalas"

#### 🗑️ Kelola Pesan
- **Mark as Read:** Tandai sudah dibaca
- **Delete:** Hapus pesan (soft delete)
- **Force Delete:** Hapus permanen
- **Export:** Download pesan ke CSV/Excel
- **Bulk Actions:** Proses banyak pesan sekaligus

#### 📊 Filter Pesan
- Status: Baru/Dibaca/Dibalas
- Tanggal: Range tanggal tertentu
- Search: Cari berdasarkan nama/email/subjek

---

### 12. Pengaturan Website

#### ⚙️ Umum (General Settings)
1. **Menu:** Sidebar → Pengaturan
2. **Tab General:**
   - **Nama Website:** Nama resmi BUMNag
   - **Tagline:** Slogan website
   - **Deskripsi:** About website
   - **Logo:** Upload logo website
   - **Favicon:** Icon browser tab

#### 🎨 Homepage Settings
- **Hero Title & Subtitle:** Judul di banner utama
- **Hero Description:** Deskripsi singkat
- **Hero Images:** Upload gambar slider (JSON array)
- **Max Slides:** Jumlah maksimal slide (default: 5)
- **Autoplay Duration:** Durasi pergantian slide (ms)

#### 📰 Content Limits
- **News Homepage Limit:** Jumlah berita di homepage (default: 6)
- **Reports Homepage Limit:** Jumlah laporan (default: 6)
- **Catalog Homepage Limit:** Jumlah produk (default: 6)

#### 📞 Contact Information
- **Alamat:** Alamat lengkap kantor
- **Telepon:** Nomor telepon
- **Email:** Email resmi
- **WhatsApp:** Nomor WA (format: 628123456789)

#### 🌐 Social Media
- **Facebook:** URL profil Facebook
- **Instagram:** URL profil Instagram
- **Twitter:** URL profil Twitter
- **YouTube:** URL channel YouTube

#### 💾 Simpan Pengaturan
Klik tombol **"Simpan Pengaturan"** di bagian bawah form.

---

### 13. Roles & Permissions (Super Admin Only)

#### 👑 Role Management

**Roles Default:**
- **super_admin:** Akses penuh semua fitur
- **admin:** Akses kelola konten
- **editor:** Akses edit konten
- **viewer:** Hanya lihat

#### ➕ Buat Role Baru
1. **Menu:** Sidebar → Roles
2. **Klik:** "Buat Role Baru"
3. **Form:**
   - **Nama Role:** Lowercase, underscore (contoh: content_manager)
   - **Guard:** Web (default)
   - **Permissions:** Centang permission yang diizinkan
4. **Simpan:** Role siap digunakan

#### 🔐 Permission Groups
- **news:** Kelola berita (create, read, update, delete)
- **report:** Kelola laporan
- **promotion:** Kelola promosi
- **gallery:** Kelola galeri
- **catalog:** Kelola katalog
- **category:** Kelola kategori
- **profile:** Kelola profil BUMNag
- **team:** Kelola tim
- **contact:** Kelola kontak
- **setting:** Kelola pengaturan
- **user:** Kelola user

#### ✏️ Edit Role
1. **List Roles:** Lihat semua role
2. **Edit:** Klik tombol "Edit"
3. **Update Permissions:** Centang/hapus permission
4. **Assign Users:** Tambahkan user ke role
5. **Simpan:** Update role

#### 🧩 Permission Management

**Buat Permission Baru:**
1. **Menu:** Sidebar → Permissions
2. **Format:** `group.action` (contoh: `news.create`)
3. **Actions:**
   - `create`: Buat konten baru
   - `read`: Lihat konten
   - `update`: Edit konten
   - `delete`: Hapus konten
   - `publish`: Publikasikan konten

**Sync Permission ke Role:**
1. Pilih permission
2. Klik "Sync to Roles"
3. Centang role yang diberi akses
4. Simpan

---

### 14. Kelola Pengguna (User Management)

#### 👤 Tambah User Baru
1. **Menu:** Sidebar → Pengguna → "Tambah User"
2. **Form User:**
   - **Nama Lengkap:** Nama user
   - **Email:** Email login (harus unik)
   - **Password:** Min 8 karakter
   - **Konfirmasi Password:** Ketik ulang password
   - **Role:** Pilih role (super_admin, admin, editor, viewer)
   - **Status:** Active/Inactive
3. **Simpan:** User siap login

#### ✏️ Edit User
- **Update Profil:** Nama, email
- **Ganti Password:** Reset password user
- **Ubah Role:** Assign role berbeda
- **Status:** Aktifkan/nonaktifkan akun

#### 🗑️ Hapus User
- **Soft Delete:** User dihapus tapi data masih ada
- **Restore:** Kembalikan user yang dihapus
- **Force Delete:** Hapus permanen (hati-hati!)

#### 🔍 Filter User
- **Role:** Filter berdasarkan role
- **Status:** Active/Inactive/Deleted
- **Search:** Cari berdasarkan nama/email
- **Sort:** Urutkan berdasarkan nama, email, tanggal

#### 📊 User Statistics
- Total user aktif
- User per role
- Login terakhir
- Aktivitas user

---

### 15. Cache Management

#### 🚀 Clear Cache untuk Performa

**Kapan Clear Cache?**
- Setelah update pengaturan
- Setelah update banyak konten
- Website terasa lambat
- Data tidak update di frontend

**Cara Clear Cache:**

**1. Via Artisan Command (Terminal/SSH):**
```bash
# Clear semua cache aplikasi
php artisan app:clear-cache

# Clear cache spesifik
php artisan app:clear-cache --type=settings
php artisan app:clear-cache --type=homepage
php artisan app:clear-cache --type=permissions
php artisan app:clear-cache --type=roles

# Clear cache Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

**2. Otomatis:**
Cache otomatis clear saat:
- Berita/laporan/promosi/galeri/katalog dibuat/update/hapus
- Settings diubah
- Permission/Role diubah

**3. TTL Cache:**
- **Homepage Data:** 5 menit (short cache)
- **Settings:** 1 jam
- **Permissions/Roles:** 1 jam

---

### 16. Best Practices

#### ✅ DO (Lakukan)
1. **Backup Berkala:** Backup database dan file media
2. **Strong Password:** Gunakan password kuat dan unik
3. **Logout:** Selalu logout setelah selesai
4. **Preview:** Preview konten sebelum publish
5. **Optimize Images:** Compress gambar sebelum upload
6. **SEO:** Isi meta title, description, keywords
7. **Kategori:** Gunakan kategori yang konsisten
8. **Schedule:** Jadwalkan publikasi konten
9. **Monitor:** Cek statistik views dan downloads
10. **Update:** Keep content fresh dan up-to-date

#### ❌ DON'T (Jangan)
1. **Share Login:** Jangan share kredensial login
2. **Delete Immediately:** Hindari force delete, gunakan soft delete
3. **Large Files:** Jangan upload file terlalu besar (>10MB)
4. **Broken Links:** Jangan biarkan link rusak
5. **Spam:** Jangan publish konten spam/tidak relevan
6. **Skip Preview:** Jangan publish tanpa preview
7. **Ignore Errors:** Jangan abaikan error/warning
8. **Change URLs:** Jangan ubah slug yang sudah terindex
9. **Empty Alt:** Jangan lupa alt text untuk gambar
10. **Test in Production:** Jangan test fitur di production

---

### 17. Troubleshooting

#### ⚠️ Masalah Umum

**1. Tidak Bisa Login**
- **Penyebab:** Email/password salah, akun non-aktif
- **Solusi:** Reset password, hubungi super admin

**2. Upload Gagal**
- **Penyebab:** File terlalu besar, format tidak didukung
- **Solusi:** Compress file, gunakan format yang benar (JPG, PNG, PDF)

**3. Konten Tidak Muncul di Frontend**
- **Penyebab:** Status masih draft, cache belum clear
- **Solusi:** Ubah status ke published, clear cache

**4. Gambar Tidak Tampil**
- **Penyebab:** Path salah, file corrupt
- **Solusi:** Re-upload gambar, cek permission folder storage

**5. Slug Duplicate**
- **Penyebab:** Judul sama dengan konten lain
- **Solusi:** Edit slug manual, tambahkan suffix unik

**6. Permission Denied**
- **Penyebab:** User tidak punya permission
- **Solusi:** Hubungi admin untuk assign permission

**7. Session Expired**
- **Penyebab:** Idle terlalu lama
- **Solusi:** Login ulang

**8. Data Tidak Tersimpan**
- **Penyebab:** Validation error, koneksi terputus
- **Solusi:** Cek error message, isi field yang required

---

### 18. Keyboard Shortcuts

#### ⌨️ Shortcuts Berguna
- **Ctrl + S:** Save draft (jika didukung)
- **Ctrl + P:** Preview konten
- **Ctrl + F:** Search dalam halaman
- **Esc:** Close modal/dialog
- **Tab:** Navigasi antar field
- **Ctrl + Z:** Undo di editor
- **Ctrl + Y:** Redo di editor

---

### 19. Tips Optimasi Performa

#### 🚀 Membuat Website Lebih Cepat

**1. Optimasi Gambar:**
- Compress sebelum upload
- Ukuran maksimal: 1920x1080 untuk banner
- Format: JPG untuk foto, PNG untuk logo/icon
- Tools: TinyPNG, ImageOptim

**2. Batasi Konten Homepage:**
- Jangan terlalu banyak berita di homepage
- Gunakan pagination untuk list
- Setting limit di pengaturan

**3. Regular Cleanup:**
- Hapus konten draft lama
- Hapus media yang tidak terpakai
- Clear cache berkala

**4. Video:**
- Embed YouTube/Vimeo daripada upload langsung
- Jika upload, compress dengan Handbrake

**5. Database:**
- Jangan spam create/delete konten
- Index sudah optimal (sudah di-setup)
- Monitor slow queries di log

---

### 20. Kontak Dukungan Teknis

#### 🆘 Butuh Bantuan?

**Developer Support:**
- **Email:** developer@example.com
- **WhatsApp:** +62 xxx-xxxx-xxxx
- **GitHub Issues:** Report bug di repository

**Training & Onboarding:**
- Request training session
- Video tutorial (jika tersedia)
- Documentation updates

**Feature Request:**
- Kirim via email
- Diskusi di team meeting
- Prioritas berdasarkan kebutuhan

---

## 📚 Referensi Tambahan

### File-file Penting:
- **`USER_GUIDE.md`** - Panduan untuk pengunjung website
- **`README.md`** - Dokumentasi teknis project
- **`routes/admin.php`** - Daftar route admin panel
- **`config/filament.php`** - Konfigurasi admin (jika ada)

### Dokumentasi Laravel:
- [Laravel Documentation](https://laravel.com/docs)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)
- [Laravel Validation](https://laravel.com/docs/validation)

---

**Selamat mengelola website BUMNag Lubas Mandiri!** 🎉

Panduan ini akan terus diperbarui sesuai dengan perkembangan fitur.

*Last Updated: Februari 2026*
*Version: 1.0.0*
