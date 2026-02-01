<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'web'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Placeholder routes for resources (will be implemented later)
    // News
    Route::get('/news', function() {
        return view('admin.coming-soon', ['title' => 'News Management']);
    })->name('news.index');
    
    // Catalogs
    Route::get('/catalogs', function() {
        return view('admin.coming-soon', ['title' => 'Catalog Management']);
    })->name('catalogs.index');
    
    // Galleries
    Route::get('/galleries', function() {
        return view('admin.coming-soon', ['title' => 'Gallery Management']);
    })->name('galleries.index');
    
    // Reports
    Route::get('/reports', function() {
        return view('admin.coming-soon', ['title' => 'Report Management']);
    })->name('reports.index');
    
    // Users
    Route::get('/users', function() {
        return view('admin.coming-soon', ['title' => 'User Management']);
    })->name('users.index');
    
    // Categories
    Route::get('/categories', function() {
        return view('admin.coming-soon', ['title' => 'Category Management']);
    })->name('categories.index');
    
    // Settings
    Route::get('/settings', function() {
        return view('admin.coming-soon', ['title' => 'Settings']);
    })->name('settings.index');
});
