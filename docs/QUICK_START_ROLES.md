# 🚀 Quick Start - Role & Permission BUMNAG

## ⚡ Command Shortcuts

### 1. Assign Role ke User
```bash
php artisan user:assign-role email@example.com role_name
```

**Contoh:**
```bash
# Assign content_manager ke John
php artisan user:assign-role john@bumnag.com content_manager

# Assign editor ke Sarah
php artisan user:assign-role sarah@bumnag.com editor

# Assign viewer ke Guest
php artisan user:assign-role guest@bumnag.com viewer
```

**Available Roles:**
- `super_admin` - Full access
- `admin` - Manage all (no users)
- `content_manager` - News, Reports, Promotions (full)
- `editor` - Create & Edit only
- `viewer` - Read-only

---

### 2. Lihat Permissions User
```bash
php artisan user:permissions email@example.com
```

**Output akan menampilkan:**
- ✅ Roles yang di-assign
- ✅ Semua permissions yang dimiliki
- ✅ Grouped by resource (news, report, promotion, dll)

---

### 3. Re-seed Roles & Permissions
```bash
# Jika ada update roles/permissions baru
php artisan db:seed --class=RolePermissionSeeder
```

---

## 📝 Workflow Harian

### Scenario 1: Tambah Editor Baru
```bash
# 1. Create user via Filament Admin Panel atau:
php artisan tinker
```
```php
User::create([
    'name' => 'Editor Baru',
    'email' => 'editor@bumnag.com',
    'password' => bcrypt('password123')
]);
exit
```
```bash
# 2. Assign role
php artisan user:assign-role editor@bumnag.com editor

# 3. Verify
php artisan user:permissions editor@bumnag.com
```

---

### Scenario 2: Promote User
```bash
# Dari viewer ke editor
php artisan user:assign-role john@bumnag.com editor

# Dari editor ke content_manager
php artisan user:assign-role john@bumnag.com content_manager
```

---

### Scenario 3: Check User Access
```bash
php artisan user:permissions john@bumnag.com
```

Akan menampilkan:
```
🎭 Roles:
  • content_manager

🔑 Permissions:
  📋 news:
     ✓ view-any
     ✓ view
     ✓ create
     ✓ update
     ✓ delete
     ✓ publish
```

---

## 🔍 Testing Permissions

### Test via Tinker:
```bash
php artisan tinker
```
```php
// Get user
$user = User::where('email', 'editor@bumnag.com')->first();

// Check permission
$user->can('news.create')        // true/false
$user->can('news.delete')        // true/false

// Check role
$user->hasRole('editor')         // true/false
$user->hasAnyRole(['admin', 'super_admin'])  // true/false

// Get all roles
$user->getRoleNames()

// Get all permissions
$user->getAllPermissions()
```

---

## 🎯 Common Tasks

### Remove Role dari User
```bash
php artisan tinker
```
```php
$user = User::where('email', 'john@bumnag.com')->first();
$user->removeRole('viewer');
```

### Sync Roles (replace all roles)
```php
$user = User::find(1);
$user->syncRoles(['editor', 'viewer']);  // Remove old, add these
```

### Give Direct Permission (tanpa role)
```php
$user = User::find(1);
$user->givePermissionTo('news.create');
```

---

## ⚠️ Important Notes

1. **Super Admin pertama sudah di-assign:**
   - Email: `admin@admin.com`
   - Role: `super_admin`

2. **Clear cache setelah update permissions:**
   ```bash
   php artisan permission:cache-reset
   php artisan optimize:clear
   ```

3. **Filament akan otomatis:**
   - Hide menu jika user tidak punya permission
   - Disable buttons (Create, Edit, Delete)
   - Redirect jika unauthorized

4. **Best Practice:**
   - Assign roles via command atau seeder
   - Jangan hardcode permission checks
   - Test setiap role setelah assignment

---

## 📊 Role Comparison

| Feature | super_admin | admin | content_manager | editor | viewer |
|---------|-------------|-------|-----------------|--------|--------|
| **News** | Full | Full | Full | Create/Edit | View |
| **Reports** | Full | Full | Full | Create/Edit | View |
| **Promotions** | Full | Full | Full | Create/Edit | View |
| **Gallery** | Full | Full | Create | Create | View |
| **Settings** | Full | Full | ❌ | ❌ | ❌ |
| **Users** | Full | ❌ | ❌ | ❌ | ❌ |

---

## 🆘 Troubleshooting

### User tidak bisa akses page tertentu:
```bash
# 1. Check permissions
php artisan user:permissions user@example.com

# 2. Clear cache
php artisan permission:cache-reset
php artisan optimize:clear

# 3. Re-login user
```

### Role tidak muncul:
```bash
# Re-run seeder
php artisan db:seed --class=RolePermissionSeeder

# Verify
php artisan tinker
\Spatie\Permission\Models\Role::all()->pluck('name')
```

---

## 📞 Quick Reference

```bash
# Assign Role
php artisan user:assign-role EMAIL ROLE

# Show Permissions
php artisan user:permissions EMAIL

# Re-seed
php artisan db:seed --class=RolePermissionSeeder

# Clear Cache
php artisan permission:cache-reset

# Test in Tinker
php artisan tinker
User::find(1)->can('news.create')
```

---

**✨ Setup Complete! User pertama sudah super_admin.**

**Next:** Login ke `/admin` dan test permissions!
