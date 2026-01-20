<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

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
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery');

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
