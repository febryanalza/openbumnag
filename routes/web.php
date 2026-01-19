<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery');

// News Routes
Route::get('/berita', [HomeController::class, 'news'])->name('news.index');
Route::get('/berita/{slug}', [HomeController::class, 'newsDetail'])->name('news.show');

// Reports Routes
Route::get('/laporan', [HomeController::class, 'reports'])->name('reports.index');
Route::get('/laporan/{slug}', [HomeController::class, 'reportDetail'])->name('reports.show');
