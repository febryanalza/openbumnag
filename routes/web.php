<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');

// Contact Routes
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

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

// Promotion Routes
Route::get('/promo', [PromotionController::class, 'index'])->name('promotions.index');
Route::get('/promo/{slug}', [PromotionController::class, 'show'])->name('promotions.show');
