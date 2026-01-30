<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * DEBUGGING ENDPOINTS - HAPUS SETELAH PRODUCTION STABIL
 */

// Debug Environment dan Configuration
Route::get('/debug/env', function () {
    return response()->json([
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug'),
        'app_url' => config('app.url'),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'session_same_site' => config('session.same_site'),
        'session_lifetime' => config('session.lifetime'),
        'cache_store' => config('cache.default'),
        'database_connection' => config('database.default'),
        'timezone' => config('app.timezone', date_default_timezone_get()),
        'current_time' => now()->toDateTimeString(),
        'request_ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
        'headers' => [
            'host' => request()->header('host'),
            'x-forwarded-proto' => request()->header('x-forwarded-proto'),
            'x-forwarded-for' => request()->header('x-forwarded-for'),
        ],
    ]);
});

// Debug Database Connection
Route::get('/debug/db', function () {
    try {
        // Test database connection
        $connection = DB::connection();
        $pdo = $connection->getPdo();
        
        // Check sessions table
        $sessionsTable = DB::table('sessions')->count();
        
        // Check users table
        $usersCount = User::count();
        
        // Check permissions
        $permissionsCount = DB::table('permissions')->count();
        $rolesCount = DB::table('roles')->count();
        
        return response()->json([
            'database_connected' => true,
            'pdo_version' => $pdo->getAttribute(PDO::ATTR_SERVER_VERSION),
            'sessions_count' => $sessionsTable,
            'users_count' => $usersCount,
            'permissions_count' => $permissionsCount,
            'roles_count' => $rolesCount,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'database_connected' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});

// Debug Session
Route::get('/debug/session', function (Request $request) {
    $sessionId = session()->getId();
    $sessionData = session()->all();
    
    // Check if session is in database
    $sessionInDb = null;
    if (config('session.driver') === 'database') {
        $sessionInDb = DB::table('sessions')
            ->where('id', $sessionId)
            ->first();
    }
    
    return response()->json([
        'session_id' => $sessionId,
        'session_data' => $sessionData,
        'session_in_database' => $sessionInDb ? true : false,
        'session_db_payload_length' => $sessionInDb ? strlen($sessionInDb->payload ?? '') : 0,
        'authenticated' => Auth::check(),
        'auth_user_id' => Auth::id(),
        'cookies' => $request->cookies->all(),
        'session_name' => config('session.cookie'),
        'session_driver' => config('session.driver'),
    ]);
})->middleware('web');

// Test Login API
Route::post('/debug/test-login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    try {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
                'email' => $request->email,
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah',
                'user_id' => $user->id,
                'user_email' => $user->email,
                'password_hash' => substr($user->password, 0, 20) . '...',
            ], 401);
        }

        // Test Filament panel access
        $panel = \Filament\Facades\Filament::getCurrentOrDefaultPanel();
        $canAccessPanel = $user->canAccessPanel($panel);

        // Get user roles and permissions
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        return response()->json([
            'success' => true,
            'message' => 'Credentials valid!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
            ],
            'roles' => $roles->toArray(),
            'permissions_count' => $permissions->count(),
            'can_access_panel' => $canAccessPanel,
            'panel_id' => $panel->getId(),
            'panel_path' => $panel->getPath(),
            'admin_url' => url('/admin'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error during validation',
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});

// Test Manual Login
Route::post('/debug/manual-login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    try {
        // Get session before login
        $sessionBefore = [
            'id' => session()->getId(),
            'data' => session()->all(),
        ];

        // Attempt login
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember', false);
        
        $loginSuccess = Auth::attempt($credentials, $remember);

        // Get session after login
        $sessionAfter = [
            'id' => session()->getId(),
            'data' => session()->all(),
        ];

        if ($loginSuccess) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'Manual login successful!',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                ],
                'session_before' => $sessionBefore,
                'session_after' => $sessionAfter,
                'session_changed' => $sessionBefore['id'] !== $sessionAfter['id'],
                'redirect_url' => url('/admin'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Auth::attempt() failed',
                'session_before' => $sessionBefore,
                'session_after' => $sessionAfter,
            ], 401);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
})->middleware('web');

// Check Storage Permissions
Route::get('/debug/storage', function () {
    $storagePath = storage_path();
    $logsPath = storage_path('logs');
    $cachePath = storage_path('framework/cache');
    $sessionsPath = storage_path('framework/sessions');
    
    return response()->json([
        'storage_path' => $storagePath,
        'storage_writable' => is_writable($storagePath),
        'logs_path' => $logsPath,
        'logs_exists' => file_exists($logsPath),
        'logs_writable' => is_writable($logsPath),
        'cache_path' => $cachePath,
        'cache_exists' => file_exists($cachePath),
        'cache_writable' => is_writable($cachePath),
        'sessions_path' => $sessionsPath,
        'sessions_exists' => file_exists($sessionsPath),
        'sessions_writable' => is_writable($sessionsPath),
        'latest_log_files' => glob(storage_path('logs/*.log')),
    ]);
});
