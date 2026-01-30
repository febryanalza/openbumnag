<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Filament\Facades\Filament;

class DebugController extends Controller
{
    /**
     * Comprehensive debug information
     */
    public function index()
    {
        $debugInfo = [
            'timestamp' => now()->toDateTimeString(),
            'environment' => [
                'app_env' => config('app.env'),
                'app_debug' => config('app.debug'),
                'app_url' => config('app.url'),
                'app_key_set' => !empty(config('app.key')),
            ],
            'session' => [
                'driver' => config('session.driver'),
                'domain' => config('session.domain'),
                'secure' => config('session.secure'),
                'same_site' => config('session.same_site'),
                'lifetime' => config('session.lifetime'),
                'cookie_name' => config('session.cookie'),
                'current_session_id' => session()->getId(),
                'session_started' => session()->isStarted(),
            ],
            'database' => $this->getDatabaseInfo(),
            'filament' => $this->getFilamentInfo(),
            'server' => $this->getServerInfo(),
            'users' => $this->getUsersInfo(),
            'files' => $this->getFilesInfo(),
        ];

        return response()->json($debugInfo, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Test login functionality
     */
    public function testLogin(Request $request)
    {
        $email = $request->input('email', 'admin@bumnag.com');
        $password = $request->input('password', 'password123');

        try {
            // Step 1: Find user
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'step' => 'user_lookup',
                    'message' => 'User not found',
                    'email' => $email,
                ]);
            }

            // Step 2: Verify password
            if (!Hash::check($password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'step' => 'password_verify',
                    'message' => 'Password incorrect',
                    'user_id' => $user->id,
                ]);
            }

            // Step 3: Test Filament access
            $panel = Filament::getCurrentOrDefaultPanel();
            $canAccess = $user->canAccessPanel($panel);

            // Step 4: Test manual login
            $sessionBefore = session()->getId();
            $loginAttempt = Auth::attempt(['email' => $email, 'password' => $password]);
            $sessionAfter = session()->getId();

            // Step 5: Get user roles/permissions
            $roles = $user->getRoleNames()->toArray();
            $permissions = $user->getAllPermissions()->pluck('name')->toArray();

            return response()->json([
                'success' => true,
                'steps' => [
                    'user_found' => true,
                    'password_verified' => true,
                    'can_access_panel' => $canAccess,
                    'manual_login_success' => $loginAttempt,
                ],
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified' => !is_null($user->email_verified_at),
                ],
                'auth' => [
                    'is_logged_in' => Auth::check(),
                    'auth_user_id' => Auth::id(),
                ],
                'session' => [
                    'session_before' => $sessionBefore,
                    'session_after' => $sessionAfter,
                    'session_regenerated' => $sessionBefore !== $sessionAfter,
                ],
                'panel' => [
                    'panel_id' => $panel->getId(),
                    'panel_path' => $panel->getPath(),
                    'panel_url' => url($panel->getPath()),
                ],
                'permissions' => [
                    'roles_count' => count($roles),
                    'roles' => $roles,
                    'permissions_count' => count($permissions),
                    'has_super_admin' => in_array('super_admin', $roles),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'step' => 'exception',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }

    /**
     * Create session and test persistence
     */
    public function testSession(Request $request)
    {
        $testKey = 'debug_test_' . time();
        $testValue = 'session_test_value_' . rand(1000, 9999);

        // Set session value
        session([$testKey => $testValue]);
        session()->save();

        // Immediately check if it's there
        $retrievedValue = session($testKey);
        
        // Check database
        $sessionInDb = null;
        if (config('session.driver') === 'database') {
            $sessionInDb = DB::table('sessions')
                ->where('id', session()->getId())
                ->first();
        }

        return response()->json([
            'session_id' => session()->getId(),
            'test_key' => $testKey,
            'test_value_set' => $testValue,
            'test_value_retrieved' => $retrievedValue,
            'session_working' => $testValue === $retrievedValue,
            'session_driver' => config('session.driver'),
            'session_in_database' => $sessionInDb ? true : false,
            'session_payload_size' => $sessionInDb ? strlen($sessionInDb->payload) : 0,
            'all_session_data' => session()->all(),
            'cookies' => $request->cookies->all(),
        ]);
    }

    private function getDatabaseInfo()
    {
        try {
            $connection = DB::connection();
            return [
                'connected' => true,
                'driver' => $connection->getDriverName(),
                'database' => $connection->getDatabaseName(),
                'tables' => [
                    'users' => DB::table('users')->count(),
                    'sessions' => DB::table('sessions')->count(),
                    'permissions' => DB::table('permissions')->count(),
                    'roles' => DB::table('roles')->count(),
                    'role_has_permissions' => DB::table('role_has_permissions')->count(),
                    'model_has_roles' => DB::table('model_has_roles')->count(),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'connected' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function getFilamentInfo()
    {
        try {
            $panel = Filament::getCurrentOrDefaultPanel();
            return [
                'panel_id' => $panel->getId(),
                'panel_path' => $panel->getPath(),
                'panel_url' => url($panel->getPath()),
                'login_url' => url($panel->getPath() . '/login'),
                'has_registration' => $panel->hasRegistration(),
                'middleware' => $panel->getMiddleware(),
                'auth_middleware' => $panel->getAuthMiddleware(),
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    private function getServerInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
            'https' => request()->secure(),
            'host' => request()->getHost(),
            'url' => request()->url(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
    }

    private function getUsersInfo()
    {
        $users = User::with('roles')->get();
        return [
            'total_users' => $users->count(),
            'users_with_roles' => $users->filter(fn($u) => $u->roles->count() > 0)->count(),
            'super_admins' => $users->filter(fn($u) => $u->hasRole('super_admin'))->count(),
            'recent_users' => $users->take(3)->map(fn($u) => [
                'id' => $u->id,
                'email' => $u->email,
                'roles' => $u->getRoleNames()->toArray(),
                'created_at' => $u->created_at,
                'email_verified' => !is_null($u->email_verified_at),
            ]),
        ];
    }

    private function getFilesInfo()
    {
        $storagePath = storage_path();
        $logPath = storage_path('logs');
        
        return [
            'storage_path' => $storagePath,
            'storage_writable' => is_writable($storagePath),
            'logs_path' => $logPath,
            'logs_exists' => file_exists($logPath),
            'logs_writable' => is_writable($logPath),
            'log_files' => file_exists($logPath) ? array_slice(scandir($logPath), 2) : [],
            'bootstrap_cache_writable' => is_writable(base_path('bootstrap/cache')),
        ];
    }
}