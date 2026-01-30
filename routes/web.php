<?php

use App\Http\Controllers\DebugController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

// Debug Routes (HANYA UNTUK DEBUGGING - HAPUS SETELAH PRODUCTION STABIL)
Route::get('/debug', [DebugController::class, 'index']);
Route::post('/debug/test-login', [DebugController::class, 'testLogin']);
Route::get('/debug/test-session', [DebugController::class, 'testSession']);

// Alternative Login Test Route
Route::get('/debug/login-test', function() {
    return view('debug-login-test');
});

// Manual Admin Login Route (EMERGENCY ONLY)
Route::post('/debug/emergency-login', function(\Illuminate\Http\Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');
    
    $user = \App\Models\User::where('email', $email)->first();
    
    if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
        \Illuminate\Support\Facades\Auth::login($user, true);
        
        if (\Illuminate\Support\Facades\Auth::check()) {
            return redirect('/admin');
        }
    }
    
    return response()->json(['error' => 'Login failed'], 401);
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/debug-hero', function() {
    $heroMaxSlides = (int) \App\Helpers\SettingHelper::get('hero_max_slides', 5);
    $heroImagesData = \App\Helpers\SettingHelper::get('hero_images', '[]');
    
    if (is_string($heroImagesData)) {
        $heroImagesPaths = json_decode($heroImagesData, true) ?? [];
    } else {
        $heroImagesPaths = is_array($heroImagesData) ? $heroImagesData : [];
    }
    
    $heroImagesPaths = array_slice($heroImagesPaths, 0, $heroMaxSlides);
    
    $heroImages = collect($heroImagesPaths)->map(function($path, $index) {
        return (object)[
            'id' => $index,
            'title' => 'Hero Slide ' . ($index + 1),
            'file_path' => $path
        ];
    });
    
    return view('debug-hero', compact('heroImages'));
});
Route::get('/tentang', [HomeController::class, 'about'])->name('about');

// Gallery Routes
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');
Route::get('/galeri/{id}', [GalleryController::class, 'show'])->name('gallery.show');

// BUMNag Profile Routes
Route::get('/bumnag/{slug}', [HomeController::class, 'bumnagDetail'])->name('bumnag.show');

// News Routes
Route::get('/berita', [HomeController::class, 'news'])->name('news.index');
Route::get('/berita/{slug}', [HomeController::class, 'newsDetail'])->name('news.show');
Route::get('/berita-preview/{slug}', [HomeController::class, 'newsPreview'])->name('news.preview');

// Reports Routes
Route::get('/laporan', [HomeController::class, 'reports'])->name('reports.index');
Route::get('/laporan/{slug}', [HomeController::class, 'reportDetail'])->name('reports.show');
Route::get('/laporan-preview/{slug}', [HomeController::class, 'reportPreview'])->name('reports.preview');

// Catalog Routes
Route::get('/kodai', [CatalogController::class, 'index'])->name('catalogs.index');
Route::get('/kodai/{slug}', [CatalogController::class, 'show'])->name('catalogs.show');
