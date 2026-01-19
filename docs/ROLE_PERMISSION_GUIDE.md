# 🔐 Role & Permission System - BUMNAG

Sistem role dan permission profesional menggunakan **Spatie Laravel Permission** terintegrasi dengan Filament.

---

## 📋 Roles yang Tersedia

### 1. **Super Admin** (`super_admin`)
- **Full Access** ke semua fitur
- Dapat mengelola:
  - ✅ Users & Role Management
  - ✅ News, Promotions, Reports (Create, Edit, Delete, Publish)
  - ✅ Gallery, Categories, Settings
  - ✅ BUMNAG Profile & Team Members
  - ✅ Contacts & All System Settings

### 2. **Admin** (`admin`)
- Mengelola **semua konten dan pengaturan** (kecuali user management)
- Dapat mengelola:
  - ✅ News, Promotions, Reports (Create, Edit, Delete, Publish)
  - ✅ Gallery, Categories, Settings
  - ✅ BUMNAG Profile & Team Members
  - ✅ Contacts
  - ❌ **TIDAK** dapat mengelola users

### 3. **Content Manager** (`content_manager`)
- Fokus pada **pengelolaan konten utama** dengan hak publish
- Dapat mengelola:
  - ✅ News, Promotions, Reports (Create, Edit, Delete, Publish)
  - ✅ Gallery (Create, View)
  - ✅ Categories (View Only)
  - ❌ Tidak dapat mengubah settings, profile, atau team

### 4. **Editor** (`editor`)
- **Membuat dan mengedit konten** tanpa hak delete/publish
- Dapat mengelola:
  - ✅ News, Promotions, Reports (Create, Edit)
  - ✅ Gallery (Create, View)
  - ✅ Categories (View Only)
  - ❌ **TIDAK** dapat delete atau publish
  - ❌ Tidak dapat mengubah settings

### 5. **Viewer** (`viewer`)
- **Read-only access** untuk monitoring
- Dapat:
  - ✅ View semua konten (News, Promotions, Reports, Gallery, etc.)
  - ❌ **TIDAK** dapat create, edit, atau delete apapun

---

## 🎯 Struktur Permission

### News Permissions
```
news.view-any      → Lihat daftar berita
news.view          → Lihat detail berita
news.create        → Buat berita baru
news.update        → Edit berita
news.delete        → Hapus berita
news.publish       → Publish/unpublish berita
```

### Promotion Permissions
```
promotion.view-any
promotion.view
promotion.create
promotion.update
promotion.delete
promotion.publish
```

### Report Permissions
```
report.view-any
report.view
report.create
report.update
report.delete
report.publish
```

### Permissions Lainnya
- **Gallery**: `gallery.*`
- **Category**: `category.*`
- **Profile**: `profile.*`
- **Team**: `team.*`
- **Contact**: `contact.*`
- **Setting**: `setting.*`
- **User**: `user.*` (hanya super_admin)

---

## 🚀 Cara Menggunakan

### 1. Assign Role ke User

#### Via Seeder (Recommended untuk Production):
```php
// database/seeders/AssignRolesToUsersSeeder.php
$user = User::where('email', 'editor@bumnag.com')->first();
$user->assignRole('editor');
```

Jalankan:
```bash
php artisan db:seed --class=AssignRolesToUsersSeeder
```

#### Via Tinker (untuk Testing):
```bash
php artisan tinker
```
```php
$user = User::find(1);
$user->assignRole('content_manager');

// Atau assign multiple roles
$user->assignRole(['editor', 'viewer']);
```

### 2. Check Permission di Code

```php
// Di Controller atau Model
if (auth()->user()->can('news.create')) {
    // User bisa create news
}

// Check role
if (auth()->user()->hasRole('super_admin')) {
    // User adalah super admin
}

// Check any role
if (auth()->user()->hasAnyRole(['admin', 'super_admin'])) {
    // User adalah admin atau super admin
}
```

### 3. Protection di Filament Resource

Sudah otomatis terintegrasi via Policy:
```php
// app/Filament/Resources/News/NewsResource.php
protected static ?string $policy = NewsPolicy::class;
```

Filament akan otomatis:
- ✅ Hide navigation jika user tidak punya `view-any` permission
- ✅ Disable Create button jika tidak punya `create` permission
- ✅ Hide Edit/Delete button jika tidak punya `update`/`delete` permission

---

## 📁 File Structure

```
app/
├── Models/
│   └── User.php                           # ✓ HasRoles trait
├── Policies/
│   ├── NewsPolicy.php                     # ✓ News authorization
│   ├── PromotionPolicy.php                # ✓ Promotion authorization
│   └── ReportPolicy.php                   # ✓ Report authorization
└── Filament/Resources/
    ├── News/NewsResource.php              # ✓ Policy integrated
    ├── Promotions/PromotionResource.php   # ✓ Policy integrated
    └── Reports/ReportResource.php         # ✓ Policy integrated

database/seeders/
├── RolePermissionSeeder.php               # ✓ Create roles & permissions
└── AssignRolesToUsersSeeder.php           # ✓ Assign roles to users

config/
└── permission.php                          # Spatie config
```

---

## 🔧 Management Commands

### Re-seed Roles & Permissions
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Assign Roles to Users
```bash
php artisan db:seed --class=AssignRolesToUsersSeeder
```

### Clear Permission Cache
```bash
php artisan permission:cache-reset
```

### Check User Permissions
```bash
php artisan tinker
```
```php
$user = User::find(1);
$user->getAllPermissions();  // Semua permission
$user->getRoleNames();       // Semua role
```

---

## 🎨 Filament Integration

### Auto-Hide Navigation Items
Filament akan otomatis hide menu items berdasarkan permission:

```php
// User dengan role 'viewer' hanya akan melihat menu:
✓ Berita (read-only)
✓ Laporan (read-only)
✓ Promosi (read-only)
✓ Galeri (read-only)

// User dengan role 'editor' akan melihat:
✓ Berita (create, edit - no delete)
✓ Laporan (create, edit - no delete)
✓ Promosi (create, edit - no delete)
✓ Galeri (create, view)
```

### Custom Permission Check
```php
// Di Filament Resource
public static function canViewAny(): bool
{
    return auth()->user()->can('news.view-any');
}

public static function canCreate(): bool
{
    return auth()->user()->can('news.create');
}
```

---

## 💡 Best Practices

### ✅ DO:
1. **Assign role via seeder** untuk production
2. **Use `can()` method** untuk check permission
3. **Cache permissions** di production (sudah otomatis)
4. **Buat policy** untuk setiap model yang perlu authorization
5. **Test permissions** sebelum deploy

### ❌ DON'T:
1. Jangan hardcode role names di controller
2. Jangan assign `super_admin` ke semua user
3. Jangan skip policy di Filament resources
4. Jangan lupa sync permissions setelah update roles

---

## 🔄 Workflow untuk Menambah User Baru

### Scenario 1: Content Manager Baru
```bash
# 1. Create user via Filament atau tinker
php artisan tinker
```
```php
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@bumnag.com',
    'password' => bcrypt('password123')
]);

$user->assignRole('content_manager');
```

### Scenario 2: Bulk Assignment
```php
// Di AssignRolesToUsersSeeder.php
User::where('email', 'LIKE', '%@bumnag.com')
    ->get()
    ->each(fn($user) => $user->assignRole('editor'));
```

---

## 📊 Permission Matrix

| Role              | News | Promotion | Report | Gallery | Settings | Users |
|-------------------|------|-----------|--------|---------|----------|-------|
| **super_admin**   | Full | Full      | Full   | Full    | Full     | Full  |
| **admin**         | Full | Full      | Full   | Full    | Full     | ❌    |
| **content_manager** | Full | Full    | Full   | Create  | ❌       | ❌    |
| **editor**        | C/U  | C/U       | C/U    | C/V     | ❌       | ❌    |
| **viewer**        | View | View      | View   | View    | ❌       | ❌    |

**Legend:**
- **Full** = Create, Read, Update, Delete, Publish
- **C/U** = Create, Update (no Delete/Publish)
- **C/V** = Create, View (no Update/Delete)
- **View** = Read-only

---

## 🆘 Troubleshooting

### User tidak bisa akses menu tertentu
```bash
# Check permission cache
php artisan permission:cache-reset
php artisan optimize:clear

# Verify role assignment
php artisan tinker
User::find(1)->getRoleNames();
```

### Permission tidak bekerja
1. Pastikan model User menggunakan `HasRoles` trait
2. Check apakah policy sudah registered di Resource
3. Verify migration `create_permission_tables` sudah run

### Role baru tidak muncul
```bash
# Re-run seeder
php artisan db:seed --class=RolePermissionSeeder --force
```

---

## 🎓 Dokumentasi Lengkap

- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Filament Authorization](https://filamentphp.com/docs/3.x/panels/users#authorization)
- [Laravel Policies](https://laravel.com/docs/11.x/authorization#creating-policies)

---

**✨ Setup Completed!**

User pertama (`admin@admin.com`) sudah di-assign sebagai `super_admin`.

**Next Steps:**
1. Login ke Filament Admin
2. Test create/edit News, Promotions, Reports
3. Buat user baru dan assign role yang sesuai
4. Verifikasi permission bekerja dengan benar
