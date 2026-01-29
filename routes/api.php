<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Testing endpoint untuk login
 * Hanya untuk development/testing
 */
Route::post('/test-login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

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
        ], 401);
    }

    // Check if user can access Filament panel
    $panel = \Filament\Facades\Filament::getCurrentOrDefaultPanel();
    if (!$user->canAccessPanel($panel)) {
        return response()->json([
            'success' => false,
            'message' => 'User tidak memiliki akses ke admin panel',
            'user_id' => $user->id,
            'user_email' => $user->email,
        ], 403);
    }

    // Get user roles and permissions
    $roles = $user->getRoleNames();
    $permissions = $user->getAllPermissions()->pluck('name');

    return response()->json([
        'success' => true,
        'message' => 'Login berhasil! Credentials valid.',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
        ],
        'roles' => $roles,
        'permissions_count' => $permissions->count(),
        'can_access_panel' => true,
        'panel_url' => url('/admin'),
    ], 200);
});

/**
 * Check session status
 */
Route::get('/test-session', function (Request $request) {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
    ]);
})->middleware('web');
