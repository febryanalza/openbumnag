# WhatsApp Integration - Promotion Contact

## 📋 Overview
Integrasi WhatsApp untuk fitur promosi. Setiap promosi sekarang menggunakan nomor kontak yang tersimpan di database (`contact_phone`) alih-alih nomor dummy atau global settings.

## ✅ Apa yang Sudah Dibuat

### 1. WhatsApp Helper Class
**File:** `app/Helpers/WhatsAppHelper.php`

Helper class dengan 5 static methods:
```php
// Format nomor telepon ke format WhatsApp (62xxx)
WhatsAppHelper::formatWhatsAppNumber('0812-3456-7890')
// Output: '628123456890'

// Generate link WhatsApp wa.me
WhatsAppHelper::generateWhatsAppLink('0812-3456-7890', 'Halo, saya tertarik')
// Output: 'https://wa.me/628123456890?text=Halo%2C%20saya%20tertarik'

// Generate link WhatsApp API
WhatsAppHelper::generateWhatsAppApiLink('0812-3456-7890', 'Halo')
// Output: 'https://api.whatsapp.com/send?phone=628123456890&text=Halo'

// Validasi nomor WhatsApp
WhatsAppHelper::isValidWhatsAppNumber('0812-3456-7890')
// Output: true

// Format tampilan nomor
WhatsAppHelper::displayFormat('628123456890')
// Output: '0812-3456-7890'
```

**Features:**
- ✅ Auto-convert `0xxx` → `62xxx` format
- ✅ Clean non-numeric characters (spasi, dash, bracket)
- ✅ URL encode message untuk query string
- ✅ Validasi panjang nomor minimum 10 digit
- ✅ Null-safe (return empty string jika null)

### 2. Global Helper Functions
**File:** `app/Helpers/helpers.php`

Shorthand functions untuk kemudahan penggunaan di Blade:
```php
// Di Blade template
{{ wa_link($phone, 'Pesan saya') }}          // Generate WhatsApp link
{{ wa_number($phone) }}                       // Format ke 62xxx
{{ wa_display($phone) }}                      // Format tampilan 0812-xxx
@if(is_valid_wa($phone)) ... @endif          // Check validitas
```

### 3. Update Promotion View
**File:** `resources/views/promotions/show.blade.php`

**Sebelum (Dummy Number):**
```blade
<a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '62812345678' }}?text=...">
```

**Sesudah (Database Contact):**
```blade
@php
    $contactPhone = $promotion->contact_phone ?? $globalSettings['contact_whatsapp'] ?? null;
    $whatsappLink = wa_link($contactPhone, 'Halo, saya tertarik dengan promo ' . $promotion->title);
@endphp
<a href="{{ $whatsappLink }}" target="_blank">
```

**Priority Order:**
1. `$promotion->contact_phone` (dari database promosi)
2. `$globalSettings['contact_whatsapp']` (fallback global)
3. `null` (jika tidak ada)

### 4. Composer Autoload
**File:** `composer.json`

Ditambahkan autoload untuk helper functions:
```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        ...
    },
    "files": [
        "app/Helpers/helpers.php"
    ]
}
```

## 🚀 Cara Menggunakan

### Di Blade Template
```blade
{{-- Generate link WhatsApp --}}
<a href="{{ wa_link($promotion->contact_phone, 'Halo') }}">
    Hubungi WhatsApp
</a>

{{-- Format nomor untuk tel: link --}}
<a href="tel:{{ wa_number($promotion->contact_phone) }}">
    Telepon
</a>

{{-- Display nomor di halaman --}}
<p>Kontak: {{ wa_display($promotion->contact_phone) }}</p>
```

### Di Controller
```php
use App\Helpers\WhatsAppHelper;

$phone = '0812-3456-7890';
$waLink = WhatsAppHelper::generateWhatsAppLink($phone, 'Halo');
$formattedPhone = WhatsAppHelper::formatWhatsAppNumber($phone);
```

## 📊 Database Schema

**Table:** `promotions`

Field yang digunakan:
- `contact_phone` (string, nullable) - Nomor telepon/WhatsApp untuk promosi
- `contact_person` (string, nullable) - Nama contact person
- `contact_email` (string, nullable) - Email kontak

## 🧪 Testing

### Manual Testing
1. **Upload Promotion via Admin**
   - Buat promosi baru
   - Isi field "Contact Phone" dengan nomor: `0812-3456-7890`
   - Save promotion

2. **View Promotion Detail**
   - Buka halaman detail promosi
   - Klik button "Klaim Promo via WhatsApp"
   - ✅ Verify: Buka WhatsApp ke nomor `628123456890`
   - ✅ Verify: Message pre-filled: "Halo, saya tertarik dengan promo [Nama Promo]"

3. **Fallback Test**
   - Buat promosi tanpa `contact_phone` (kosong)
   - ✅ Verify: Button menggunakan nomor dari global settings
   - ✅ Verify: Jika global settings juga kosong, button tidak muncul

### Format Testing
```php
// Test berbagai format input
WhatsAppHelper::formatWhatsAppNumber('0812-3456-7890');  // ✅ 628123456890
WhatsAppHelper::formatWhatsAppNumber('(0812) 345-6789'); // ✅ 6281234567890
WhatsAppHelper::formatWhatsAppNumber('+62 812 3456789'); // ✅ 628123456789
WhatsAppHelper::formatWhatsAppNumber('812 3456 7890');   // ✅ 628123456890
WhatsAppHelper::formatWhatsAppNumber('62812-3456-7890'); // ✅ 628123456890
```

## 📝 Deployment Checklist

### Production Deployment
```bash
# 1. Upload files via cPanel File Manager
- app/Helpers/WhatsAppHelper.php
- app/Helpers/helpers.php
- resources/views/promotions/show.blade.php
- composer.json

# 2. SSH ke server (jika tersedia)
cd ~/bumnag
composer dump-autoload

# 3. Clear cache Laravel
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# 4. Test di browser
# Buka: https://bumnaglubasmandiri.agamkab.go.id/promotions/{slug}
# Klik button "Klaim Promo"
```

### Rollback Plan
Jika ada masalah, restore files:
```bash
# Restore view ke versi lama
git checkout resources/views/promotions/show.blade.php

# Restore composer.json
git checkout composer.json

# Re-generate autoload
composer dump-autoload
```

## 🔍 Troubleshooting

### Issue: Helper function not found
```
Error: Call to undefined function wa_link()
```

**Solution:**
```bash
composer dump-autoload
php artisan config:clear
```

### Issue: WhatsApp link invalid format
```
Link: https://wa.me/?text=...  (phone number kosong)
```

**Solution:**
Check apakah `$promotion->contact_phone` terisi di database:
```sql
SELECT id, title, contact_phone FROM promotions WHERE slug = 'promo-slug';
```

### Issue: Link format salah (masih 0xxx)
```
Link: https://wa.me/0812...  (should be 62812...)
```

**Solution:**
Pastikan menggunakan helper `wa_link()` atau `wa_number()`, bukan raw `$promotion->contact_phone`

## 📚 References

- **WhatsApp Link Format:** https://faq.whatsapp.com/5913398998672934
- **Laravel Helpers:** https://laravel.com/docs/10.x/helpers
- **Composer Autoload:** https://getcomposer.org/doc/04-schema.md#files

## 📅 Change Log

**2025-01-XX** - Initial Implementation
- Created WhatsAppHelper class with 5 methods
- Created global helper functions (wa_link, wa_number, etc)
- Updated promotion detail view to use database contact
- Added composer autoload for helpers
- Documentation created

---

**Status:** ✅ Implemented & Ready for Testing  
**Author:** AI Assistant  
**Laravel Version:** 10.50.0
