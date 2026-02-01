# Admin Login System - Documentation

## 🔐 Sistem Autentikasi Admin Panel BUMNag

Sistem login yang terintegrasi dengan **Spatie Laravel Permission** untuk pengecekan role dan permission yang detail.

---

## 📋 Fitur Utama

### ✅ Web Authentication
- Login form dengan desain modern (Tailwind CSS)
- Rate limiting (5 percobaan per email/IP)
- Remember me functionality
- Session management yang aman
- CSRF protection
- Password visibility toggle
- Auto-hide success messages

### ✅ Role & Permission System
- **Super Admin**: Akses penuh ke semua fitur
- **Admin**: Akses ke management content
- **Editor**: Akses ke content editing
- **Viewer**: Akses read-only

### ✅ Permission Checks
- `access_admin` - Akses ke admin panel
- `view_dashboard` - Lihat dashboard
- `manage_news` - Kelola berita
- `manage_catalogs` - Kelola katalog
- `manage_galleries` - Kelola galeri
- `manage_reports` - Kelola laporan
- `manage_users` - Kelola users
- `manage_categories` - Kelola kategori

### ✅ API Authentication
- RESTful API endpoints
- Sanctum token authentication
- Permission checking via API
- JSON responses

---

## 🚀 Cara Penggunaan

### 1. Login via Web

**URL:** `https://bumnag.fazcreateve.app/admin/login`

**Credentials (Default):**
```
Email: admin@bumnag.com
Password: password
```

**Flow:**
1. User mengisi email & password
2. System check credentials
3. System check role/permission
4. Jika valid → redirect ke dashboard
5. Jika invalid role → logout & error message

### 2. Login via API

**Endpoint:** `POST /api/auth/login`

**Request:**
```json
{
  "email": "admin@bumnag.com",
  "password": "password",
  "remember": false
}
```

**Response Success (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin",
      "email": "admin@bumnag.com",
      "email_verified_at": "2026-01-19T15:53:37.000000Z"
    },
    "roles": ["super_admin"],
    "permissions": ["access_admin", "manage_news", "manage_catalogs", ...],
    "token": "1|abc123...",
    "token_type": "Bearer"
  }
}
```

**Response Error (401):**
```json
{
  "success": false,
  "message": "Invalid credentials",
  "errors": {
    "email": ["These credentials do not match our records."]
  }
}
```

**Response Error (403):**
```json
{
  "success": false,
  "message": "Access denied",
  "errors": {
    "email": ["You do not have permission to access the admin panel."]
  }
}
```

### 3. Get User Info via API

**Endpoint:** `GET /api/auth/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "Admin",
      "email": "admin@bumnag.com",
      "email_verified_at": "2026-01-19T15:53:37.000000Z"
    },
    "roles": ["super_admin"],
    "permissions": ["access_admin", "manage_news", ...],
    "can_access_admin": true,
    "is_super_admin": true,
    "can_manage_users": true,
    "can_manage_content": true
  }
}
```

### 4. Check Permission via API

**Endpoint:** `POST /api/auth/check-permission`

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
  "permission": "manage_news"
}
```

**Response (200):**
```json
{
  "success": true,
  "permission": "manage_news",
  "has_permission": true
}
```

### 5. Logout via API

**Endpoint:** `POST /api/auth/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

---

## 🛡️ Middleware yang Tersedia

### 1. `admin.access`
Memastikan user bisa mengakses admin panel.

**Usage:**
```php
Route::middleware(['auth', 'admin.access'])->group(function () {
    // Admin routes
});
```

### 2. `check.permission:{permission}`
Memastikan user memiliki permission tertentu.

**Usage:**
```php
Route::middleware(['check.permission:manage_news'])->group(function () {
    // News management routes
});
```

### 3. `check.role:{role1,role2,...}`
Memastikan user memiliki salah satu role yang disebutkan.

**Usage:**
```php
Route::middleware(['check.role:super_admin,admin'])->group(function () {
    // Admin-only routes
});
```

---

## 📁 Struktur File

### Controllers
```
app/Http/Controllers/
├── Admin/
│   ├── Auth/
│   │   └── LoginController.php      # Web login/logout
│   └── DashboardController.php      # Dashboard
└── Api/
    └── AuthController.php            # API authentication
```

### Middleware
```
app/Http/Middleware/
├── EnsureUserCanAccessAdmin.php     # Check admin access
├── CheckPermission.php               # Check specific permission
└── CheckRole.php                     # Check role
```

### Views
```
resources/views/admin/
├── auth/
│   └── login.blade.php              # Login page
└── layouts/
    └── app.blade.php                # Admin layout with logout
```

### Routes
```
routes/
├── admin.php                        # Admin routes dengan middleware
└── api.php                          # API routes
```

---

## 🔧 Helper Methods di User Model

### `canAccessAdmin()`
Cek apakah user bisa akses admin panel.

```php
if ($user->canAccessAdmin()) {
    // Allow access
}
```

### `isSuperAdmin()`
Cek apakah user adalah super admin.

```php
if ($user->isSuperAdmin()) {
    // Super admin access
}
```

### `canManageUsers()`
Cek apakah user bisa manage users.

```php
if ($user->canManageUsers()) {
    // Show user management
}
```

### `canManageContent()`
Cek apakah user bisa manage content (news, catalogs, galleries).

```php
if ($user->canManageContent()) {
    // Show content management
}
```

---

## 🎯 Implementasi di Blade Templates

### Check Permission
```blade
@can('manage_news')
    <a href="{{ route('admin.news.create') }}">Buat Berita Baru</a>
@endcan
```

### Check Role
```blade
@role('super_admin')
    <a href="{{ route('admin.settings') }}">Settings</a>
@endrole
```

### Check Multiple Roles
```blade
@hasanyrole('super_admin|admin')
    <div>Admin Content</div>
@endhasanyrole
```

---

## 🔒 Keamanan

### Rate Limiting
- **5 percobaan login** per email/IP
- Auto-block setelah limit tercapai
- Cooldown berdasarkan throttle key

### Session Security
- Session regeneration setelah login
- Session invalidation setelah logout
- CSRF token protection
- Secure cookies (production)

### Password
- Hashed dengan bcrypt
- Password visibility toggle (UX improvement)
- Remember me menggunakan Laravel's built-in

### Activity Logging
- Login events logged
- Logout events logged
- Integration dengan `spatie/laravel-activitylog` (optional)

---

## 📝 Testing

### Test Login via cURL

**Web Login:**
```bash
curl -X POST https://bumnag.fazcreateve.app/admin/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=admin@bumnag.com&password=password&_token=YOUR_CSRF_TOKEN"
```

**API Login:**
```bash
curl -X POST https://bumnag.fazcreateve.app/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@bumnag.com","password":"password"}'
```

**API Get User:**
```bash
curl -X GET https://bumnag.fazcreateve.app/api/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## ⚙️ Konfigurasi

### Middleware Registration
Sudah terdaftar di `bootstrap/app.php`:

```php
$middleware->alias([
    'admin.access' => \App\Http\Middleware\EnsureUserCanAccessAdmin::class,
    'check.permission' => \App\Http\Middleware\CheckPermission::class,
    'check.role' => \App\Http\Middleware\CheckRole::class,
]);
```

### Routes Configuration
Guest routes (untuk login) dan authenticated routes terpisah:

```php
// Guest (login page)
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showLoginForm']);
    Route::post('/admin/login', [LoginController::class, 'login']);
});

// Authenticated (dashboard, management)
Route::middleware(['web', 'auth', 'admin.access'])->group(function () {
    Route::post('/admin/logout', [LoginController::class, 'logout']);
    Route::get('/admin', [DashboardController::class, 'index']);
});
```

---

## 🚨 Troubleshooting

### Issue: "You do not have permission to access the admin panel"
**Solution:** Pastikan user memiliki role atau permission yang tepat:
```php
$user->assignRole('admin');
// atau
$user->givePermissionTo('access_admin');
```

### Issue: Rate limit exceeded
**Solution:** Tunggu beberapa menit atau clear rate limiter:
```php
RateLimiter::clear($throttleKey);
```

### Issue: CSRF token mismatch
**Solution:** 
1. Clear browser cache
2. Pastikan `<meta name="csrf-token">` ada di layout
3. Run `php artisan config:clear`

---

## 📚 References

- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6)
- [Laravel Sanctum](https://laravel.com/docs/11.x/sanctum)
- [Laravel Authentication](https://laravel.com/docs/11.x/authentication)
- [Tailwind CSS](https://tailwindcss.com/)

---

**Last Updated:** {{ date('Y-m-d H:i:s') }}
**Version:** 1.0.0
**Status:** ✅ Production Ready
