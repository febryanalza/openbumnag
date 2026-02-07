# Admin Panel Manual - BUMNag

## Overview

Admin panel ini dibuat secara manual menggantikan Filament. Menggunakan Laravel Breeze untuk authentication dan Tailwind CSS untuk styling.

## Features

✅ **Authentication** - Laravel Breeze (Login, Logout, Password Reset)
✅ **Dashboard** - Overview dengan statistik
✅ **Responsive** - Mobile-friendly design
✅ **Clean UI** - Tailwind CSS
✅ **Database Preserved** - Semua data dari Filament tetap ada

## Structure

```
app/
├── Http/
│   └── Controllers/
│       └── Admin/
│           └── DashboardController.php
resources/
├── views/
│   └── admin/
│       ├── layouts/
│       │   └── app.blade.php       # Main admin layout
│       ├── dashboard.blade.php     # Dashboard view
│       └── coming-soon.blade.php   # Placeholder untuk resources
routes/
└── admin.php                       # Admin routes
```

## Routes

### Public Routes
- `/` - Homepage
- `/login` - Login page (Laravel Breeze)
- `/register` - Registration (disabled by default)

### Admin Routes (requires authentication)
- `/admin` - Dashboard
- `/admin/news` - News management (placeholder)
- `/admin/catalogs` - Catalog management (placeholder)
- `/admin/galleries` - Gallery management (placeholder)
- `/admin/reports` - Report management (placeholder)
- `/admin/users` - User management (placeholder)
- `/admin/categories` - Category management (placeholder)
- `/admin/settings` - Settings (placeholder)

## Models Available

All models from previous Filament setup are preserved:

- `App\Models\User`
- `App\Models\News`
- `App\Models\Catalog`
- `App\Models\Category`
- `App\Models\Contact`
- `App\Models\Gallery`
- `App\Models\Promotion`
- `App\Models\Report`
- `App\Models\Setting`
- `App\Models\TeamMember`
- `App\Models\BumnagProfile`

## Building CRUD Pages

### Example: News Management

1. **Create Controller**
```bash
php artisan make:controller Admin/NewsController --resource
```

2. **Add Routes** (in `routes/admin.php`)
```php
Route::resource('news', NewsController::class);
```

3. **Create Views** (in `resources/views/admin/news/`)
- `index.blade.php` - List all news
- `create.blade.php` - Create new news
- `edit.blade.php` - Edit news
- `show.blade.php` - View news details

4. **Controller Methods**
```php
public function index() {
    $news = News::latest()->paginate(10);
    return view('admin.news.index', compact('news'));
}

public function create() {
    return view('admin.news.create');
}

public function store(Request $request) {
    $validated = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        // ... more validation
    ]);
    
    News::create($validated);
    return redirect()->route('admin.news.index')
        ->with('success', 'News created successfully');
}

// ... edit, update, destroy methods
```

## Recommended Packages

For faster CRUD development, consider installing:

```bash
# Laravel CRUD Generator
composer require ibex/crud-generator --dev

# Or Laravel Backpack (lighter alternative to Filament)
composer require backpack/crud

# Or InfyOm Laravel Generator
composer require infyomlabs/laravel-generator --dev
```

## Customization

### Changing Colors

Edit `resources/views/admin/layouts/app.blade.php` and modify Tailwind classes:

- Primary color: `amber-*` → change to `blue-*`, `green-*`, etc.
- Sidebar: `bg-gray-800` → any Tailwind color

### Adding Navigation Items

In `resources/views/admin/layouts/app.blade.php`, add navigation links in the `<nav>` section.

### Changing Logo

Replace text in sidebar:
```html
<h1 class="text-2xl font-bold text-amber-400">Your Logo</h1>
```

## Authentication

Using Laravel Breeze:
- Login: `/login`
- Logout: Form POST to `/logout`
- Password Reset: `/forgot-password`

To customize auth views:
```bash
# Views are published to resources/views/auth/
# Edit them as needed
```

## Permissions

The system still has Spatie Laravel Permission installed:
- Roles table: `roles`
- Permissions table: `permissions`
- User roles: `model_has_roles`

Example usage in controllers:
```php
// Check permission
if (!auth()->user()->can('edit news')) {
    abort(403);
}

// Or in routes
Route::get('/admin/users', [UserController::class, 'index'])
    ->middleware('permission:view users');
```

## Development

### Local Development
```bash
# Start server
php artisan serve

# Watch assets
npm run dev
```

### Production Deployment
```bash
# Build assets
npm run build

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Troubleshooting

### Login Redirect Loop
- Clear cache: `php artisan optimize:clear`
- Check session driver in `.env`

### 404 on Admin Routes
- Clear route cache: `php artisan route:clear`
- Verify `routes/admin.php` is registered in `bootstrap/app.php`

### CSS Not Loading
- Run `npm run build`
- Check `public/build/` directory exists
- Clear browser cache

## Support

For issues or questions:
1. Check `storage/logs/laravel.log`
2. Run `php artisan route:list` to verify routes
3. Verify database connection: `php artisan tinker` → `DB::connection()->getPdo()`

## Migration Back to Filament

If needed, restore from backup:
```bash
# Find backup directory
ls -la backups/

# Restore composer files
cp backups/pre-filament-removal-TIMESTAMP/composer.json .
cp backups/pre-filament-removal-TIMESTAMP/composer.lock .

# Reinstall
composer install
php artisan optimize:clear
```
