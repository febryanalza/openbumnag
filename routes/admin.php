<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BumnagProfileController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamMemberController;
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
    Route::middleware(['check.permission:news.view-any'])->prefix('news')->name('news.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/create', [NewsController::class, 'create'])->name('create');
        Route::post('/', [NewsController::class, 'store'])->name('store');
        Route::post('/upload-image', [NewsController::class, 'uploadImage'])->name('upload-image');
        Route::get('/{news}', [NewsController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit');
        Route::put('/{news}', [NewsController::class, 'update'])->name('update');
        Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/restore', [NewsController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [NewsController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [NewsController::class, 'bulkAction'])->name('bulk-action');
    });

    // Promotions Management (requires permission)
    Route::middleware(['check.permission:promotion.view-any'])->prefix('promotions')->name('promotions.')->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('index');
        Route::get('/create', [PromotionController::class, 'create'])->name('create');
        Route::post('/', [PromotionController::class, 'store'])->name('store');
        Route::get('/{promotion}', [PromotionController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{promotion}/edit', [PromotionController::class, 'edit'])->name('edit');
        Route::put('/{promotion}', [PromotionController::class, 'update'])->name('update');
        Route::delete('/{promotion}', [PromotionController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/restore', [PromotionController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [PromotionController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [PromotionController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Catalogs Management (requires permission)
    Route::middleware(['check.permission:catalog.view-any'])->prefix('catalogs')->name('catalogs.')->group(function () {
        Route::get('/', [CatalogController::class, 'index'])->name('index');
        Route::get('/create', [CatalogController::class, 'create'])->name('create');
        Route::post('/', [CatalogController::class, 'store'])->name('store');
        Route::get('/{catalog}', [CatalogController::class, 'show'])->name('show');
        Route::get('/{catalog}/edit', [CatalogController::class, 'edit'])->name('edit');
        Route::put('/{catalog}', [CatalogController::class, 'update'])->name('update');
        Route::delete('/{catalog}', [CatalogController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [CatalogController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/{catalog}/update-stock', [CatalogController::class, 'updateStock'])->name('update-stock');
    });
    
    // BUMNag Profiles Management (requires permission)
    Route::middleware(['check.permission:profile.view-any'])->prefix('bumnag-profiles')->name('bumnag-profiles.')->group(function () {
        Route::get('/', [BumnagProfileController::class, 'index'])->name('index');
        Route::get('/create', [BumnagProfileController::class, 'create'])->name('create');
        Route::post('/', [BumnagProfileController::class, 'store'])->name('store');
        Route::get('/{bumnagProfile}', [BumnagProfileController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{bumnagProfile}/edit', [BumnagProfileController::class, 'edit'])->name('edit');
        Route::put('/{bumnagProfile}', [BumnagProfileController::class, 'update'])->name('update');
        Route::delete('/{bumnagProfile}', [BumnagProfileController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/restore', [BumnagProfileController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [BumnagProfileController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [BumnagProfileController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Galleries Management (requires permission)
    Route::middleware(['check.permission:gallery.view-any'])->prefix('galleries')->name('galleries.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/create', [GalleryController::class, 'create'])->name('create');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
        Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('edit');
        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('update');
        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/restore', [GalleryController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [GalleryController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [GalleryController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/update-order', [GalleryController::class, 'updateOrder'])->name('update-order');
    });
    
    // Reports Management (requires permission)
    Route::middleware(['check.permission:report.view-any'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/create', [ReportController::class, 'create'])->name('create');
        Route::post('/', [ReportController::class, 'store'])->name('store');
        Route::get('/{report}', [ReportController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{report}/edit', [ReportController::class, 'edit'])->name('edit');
        Route::get('/{report}/download', [ReportController::class, 'download'])->name('download');
        Route::put('/{report}', [ReportController::class, 'update'])->name('update');
        Route::delete('/{report}', [ReportController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/restore', [ReportController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [ReportController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [ReportController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // User Management (requires permission)
    Route::middleware(['check.permission:user.view-any'])->prefix('users')->name('users.')->group(function () {
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
    
    // Categories Management (requires permission)
    Route::middleware(['check.permission:category.view-any'])->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/restore', [CategoryController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [CategoryController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [CategoryController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/update-order', [CategoryController::class, 'updateOrder'])->name('update-order');
    });
    
    // Contacts Management (requires permission)
    Route::middleware(['check.permission:contact.view-any'])->prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/export', [ContactController::class, 'export'])->name('export');
        Route::get('/{contact}', [ContactController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{contact}/reply', [ContactController::class, 'replyForm'])->name('reply-form');
        Route::post('/{contact}/reply', [ContactController::class, 'reply'])->name('reply');
        Route::patch('/{contact}/status', [ContactController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/restore', [ContactController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [ContactController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [ContactController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Team Members Management (requires permission)
    Route::middleware(['check.permission:team.view-any'])->prefix('team-members')->name('team-members.')->group(function () {
        Route::get('/', [TeamMemberController::class, 'index'])->name('index');
        Route::get('/create', [TeamMemberController::class, 'create'])->name('create');
        Route::post('/', [TeamMemberController::class, 'store'])->name('store');
        Route::get('/{teamMember}', [TeamMemberController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('edit');
        Route::put('/{teamMember}', [TeamMemberController::class, 'update'])->name('update');
        Route::delete('/{teamMember}', [TeamMemberController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/restore', [TeamMemberController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [TeamMemberController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk-action', [TeamMemberController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/update-order', [TeamMemberController::class, 'updateOrder'])->name('update-order');
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
    
    // Permissions Management (super admin only)
    Route::middleware(['check.role:super_admin'])->prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/', [PermissionController::class, 'store'])->name('store');
        Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [PermissionController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/{permission}/sync-to-role', [PermissionController::class, 'syncToRole'])->name('sync-to-role');
        Route::post('/toggle', [PermissionController::class, 'togglePermission'])->name('toggle');
    });
    
    // Roles Management (super admin only)
    Route::middleware(['check.role:super_admin'])->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [RoleController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/{role}/assign-users', [RoleController::class, 'assignUsers'])->name('assign-users');
        Route::get('/{role}/clone', [RoleController::class, 'clone'])->name('clone');
    });
});

