<?php

use App\Http\Controllers\DebugController;
use App\Http\Controllers\SessionDebugController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

// Debug Routes (HANYA UNTUK DEBUGGING - HAPUS SETELAH PRODUCTION STABIL)
Route::middleware('web')->group(function() {
    // Original debug routes
    Route::get('/debug', [DebugController::class, 'index']);
    Route::post('/debug/test-login', [DebugController::class, 'testLogin']);
    Route::get('/debug/test-session', [DebugController::class, 'testSession']);
    Route::get('/debug/login-test', function() {
        return view('debug-login-test');
    });
    
    // NEW: Session debugging routes
    Route::get('/debug/session/persistence', [SessionDebugController::class, 'testPersistence']);
    Route::post('/debug/session/auth', [SessionDebugController::class, 'testAuth']);
    Route::get('/debug/session/middleware', [SessionDebugController::class, 'testMiddleware']);
    Route::get('/debug/session/check', [SessionDebugController::class, 'checkAuth']);
    Route::get('/debug/session/cookies', [SessionDebugController::class, 'testCookies']);
    
    // Verify Filament configuration
    Route::get('/debug/filament/config', function() {
        $panel = \Filament\Facades\Filament::getCurrentPanel() ?? \Filament\Facades\Filament::getPanel('admin');
        
        return response()->json([
            'panel_id' => $panel->getId(),
            'panel_path' => $panel->getPath(),
            'login_page' => $panel->getLoginRouteSlug(),
            'login_class' => get_class($panel->getLogin()),
            'middleware' => array_map(fn($m) => is_string($m) ? $m : get_class($m), $panel->getMiddleware()),
            'auth_middleware' => array_map(fn($m) => is_string($m) ? $m : get_class($m), $panel->getAuthMiddleware()),
            'custom_login_registered' => $panel->getLogin() instanceof \App\Filament\Pages\Auth\Login,
        ]);
    });
    
    // Emergency Login (dengan CSRF protection)
    Route::post('/debug/emergency-login', function(\Illuminate\Http\Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        
        $user = \App\Models\User::where('email', $email)->first();
        
        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            \Illuminate\Support\Facades\Auth::login($user, true);
            
            if (\Illuminate\Support\Facades\Auth::check()) {
                return response()->json([
                    'success' => true,
                    'redirect' => url('/admin'),
                ]);
            }
        }
        
        return response()->json(['success' => false, 'error' => 'Invalid credentials'], 401);
    });
    
    // EMERGENCY ADMIN ACCESS - Auto login as admin (REMOVE AFTER FIXING!)
    Route::get('/debug/force-login/{email?}', function($email = 'admin@bumnag.com') {
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json([
                'error' => 'User not found',
                'email' => $email,
                'available_users' => \App\Models\User::pluck('email'),
            ], 404);
        }
        
        // Force login
        \Illuminate\Support\Facades\Auth::login($user, true);
        
        // Regenerate session (security)
        request()->session()->regenerate();
        
        if (\Illuminate\Support\Facades\Auth::check()) {
            return redirect('/admin')->with('success', 'Emergency login successful!');
        }
        
        return response()->json(['error' => 'Login failed'], 500);
    });
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
