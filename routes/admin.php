<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Guest routes (Login)
Route::middleware(['web', 'guest'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated admin routes
Route::middleware(['web', 'auth', 'admin.access'])->prefix('admin')->name('admin.')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // News Management (requires permission)
    Route::middleware(['check.permission:manage_news'])->prefix('news')->name('news.')->group(function () {
        Route::get('/', function() {
            return view('admin.coming-soon', ['title' => 'News Management']);
        })->name('index');
        // Add more news routes here (create, edit, delete, etc.)
    });
    
    // Catalogs Management (requires permission)
    Route::middleware(['check.permission:manage_catalogs'])->prefix('catalogs')->name('catalogs.')->group(function () {
        Route::get('/', function() {
            return view('admin.coming-soon', ['title' => 'Catalog Management']);
        })->name('index');
        // Add more catalog routes here
    });
    
    // Galleries Management (requires permission)
    Route::middleware(['check.permission:manage_galleries'])->prefix('galleries')->name('galleries.')->group(function () {
        Route::get('/', function() {
            return view('admin.coming-soon', ['title' => 'Gallery Management']);
        })->name('index');
        // Add more gallery routes here
    });
    
    // Reports Management (requires permission)
    Route::middleware(['check.permission:manage_reports'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', function() {
            return view('admin.coming-soon', ['title' => 'Report Management']);
        })->name('index');
        // Add more report routes here
    });
    
    // User Management (super admin or manage_users permission)
    Route::middleware(['check.permission:manage_users'])->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('/{user}/force', [UserController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [UserController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Categories Management
    Route::middleware(['check.permission:manage_categories'])->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', function() {
            return view('admin.coming-soon', ['title' => 'Category Management']);
        })->name('index');
        // Add more category routes here
    });
    
    // Settings (super admin only)
    Route::middleware(['check.role:super_admin'])->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('/create', [SettingController::class, 'create'])->name('create');
        Route::post('/', [SettingController::class, 'store'])->name('store');
        Route::get('/grouped', [SettingController::class, 'grouped'])->name('grouped');
        Route::post('/grouped', [SettingController::class, 'updateGrouped'])->name('update-grouped');
        Route::get('/{setting}', [SettingController::class, 'show'])->name('show');
        Route::get('/{setting}/edit', [SettingController::class, 'edit'])->name('edit');
        Route::put('/{setting}', [SettingController::class, 'update'])->name('update');
        Route::delete('/{setting}', [SettingController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [SettingController::class, 'bulkAction'])->name('bulk-action');
    });
});

