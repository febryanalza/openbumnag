<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SessionDebugController extends Controller
{
    /**
     * Test session persistence across requests
     */
    public function testPersistence(Request $request)
    {
        $sessionId = session()->getId();
        
        // Increment counter to test persistence
        $counter = session('debug_counter', 0);
        $counter++;
        session(['debug_counter' => $counter]);
        
        // Get session from database
        $dbSession = DB::table('sessions')
            ->where('id', $sessionId)
            ->first();
        
        return response()->json([
            'test' => 'Session Persistence Test',
            'session_id' => $sessionId,
            'counter' => $counter,
            'counter_persisted' => session('debug_counter'),
            'session_driver' => config('session.driver'),
            'db_session_exists' => $dbSession ? true : false,
            'db_session_last_activity' => $dbSession ? date('Y-m-d H:i:s', $dbSession->last_activity) : null,
            'cookies_sent' => [
                'laravel_session' => $request->cookie(config('session.cookie')),
                'xsrf_token' => $request->cookie('XSRF-TOKEN'),
            ],
            'instructions' => 'Call this endpoint multiple times - counter should increment',
        ]);
    }

    /**
     * Test manual authentication flow
     */
    public function testAuth(Request $request)
    {
        $email = $request->input('email', 'admin@bumnag.com');
        $password = $request->input('password', 'bumagbersatu24');
        
        $sessionBefore = session()->getId();
        $authBefore = Auth::check();
        
        // Find user
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        // Check password
        $passwordValid = \Hash::check($password, $user->password);
        
        if (!$passwordValid) {
            return response()->json(['error' => 'Invalid password'], 401);
        }
        
        // Attempt login
        $loginSuccess = Auth::attempt([
            'email' => $email,
            'password' => $password,
        ], true); // true = remember me
        
        $sessionAfter = session()->getId();
        $authAfter = Auth::check();
        
        // Force session regenerate (this is what Filament does)
        if ($authAfter) {
            session()->regenerate();
        }
        
        $sessionFinal = session()->getId();
        
        // Check session in DB
        $dbSession = DB::table('sessions')
            ->where('id', $sessionFinal)
            ->first();
        
        return response()->json([
            'test' => 'Manual Authentication Test',
            'step_1_find_user' => [
                'user_found' => $user ? true : false,
                'user_id' => $user?->id,
                'user_email' => $user?->email,
                'user_roles' => $user?->roles->pluck('name'),
            ],
            'step_2_check_password' => [
                'password_valid' => $passwordValid,
            ],
            'step_3_attempt_login' => [
                'login_success' => $loginSuccess,
                'auth_before' => $authBefore,
                'auth_after' => $authAfter,
            ],
            'step_4_session_tracking' => [
                'session_before' => $sessionBefore,
                'session_after_login' => $sessionAfter,
                'session_after_regenerate' => $sessionFinal,
                'session_changed' => $sessionBefore !== $sessionFinal,
            ],
            'step_5_database_verification' => [
                'db_session_exists' => $dbSession ? true : false,
                'db_session_user_id' => $dbSession->user_id ?? null,
                'db_session_last_activity' => $dbSession ? date('Y-m-d H:i:s', $dbSession->last_activity) : null,
            ],
            'final_status' => [
                'authenticated' => Auth::check(),
                'user_id' => Auth::id(),
                'user_email' => Auth::user()?->email,
                'session_id' => session()->getId(),
            ],
        ]);
    }

    /**
     * Test Filament middleware chain
     */
    public function testMiddleware(Request $request)
    {
        return response()->json([
            'test' => 'Middleware Chain Test',
            'auth_check' => Auth::check(),
            'auth_id' => Auth::id(),
            'session_id' => session()->getId(),
            'session_data' => session()->all(),
            'route_middleware' => $request->route()->middleware(),
            'cookies' => [
                'session_cookie' => $request->cookie(config('session.cookie')),
                'xsrf_token' => $request->cookie('XSRF-TOKEN'),
            ],
            'instructions' => 'This route uses web middleware only',
        ]);
    }

    /**
     * Check current auth state
     */
    public function checkAuth(Request $request)
    {
        $user = Auth::user();
        
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => $user ? [
                'id' => $user->id,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name'),
                'permissions' => $user->getAllPermissions()->pluck('name')->take(10),
            ] : null,
            'session' => [
                'id' => session()->getId(),
                'driver' => config('session.driver'),
                'data_keys' => array_keys(session()->all()),
            ],
            'guards' => [
                'web' => Auth::guard('web')->check(),
                'default' => Auth::guard()->check(),
            ],
        ]);
    }
}
