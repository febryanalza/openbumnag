<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle API login request
     * 
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login to admin panel",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="remember", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful"),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=403, description="Access denied"),
     *     @OA\Response(response=429, description="Too many attempts")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check rate limiting
        $this->ensureIsNotRateLimited($request);

        // Find user
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($this->throttleKey($request));

            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'errors' => [
                    'email' => ['These credentials do not match our records.']
                ]
            ], 401);
        }

        // Check if user can access admin
        if (!$user->canAccessAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
                'errors' => [
                    'email' => ['You do not have permission to access the admin panel.']
                ]
            ], 403);
        }

        // Clear rate limiter
        RateLimiter::clear($this->throttleKey($request));

        // Create token (if using Sanctum)
        $token = $user->createToken('admin-access')->plainTextToken;

        // Get user roles and permissions
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        // Log activity
        activity()
            ->causedBy($user)
            ->log('User logged in via API');

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                ],
                'roles' => $roles,
                'permissions' => $permissions,
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 200);
    }

    /**
     * Get authenticated user information
     * 
     * @OA\Get(
     *     path="/api/auth/me",
     *     summary="Get current user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="User information"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function me(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                ],
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'can_access_admin' => $user->canAccessAdmin(),
                'is_super_admin' => $user->isSuperAdmin(),
                'can_manage_users' => $user->canManageUsers(),
                'can_manage_content' => $user->canManageContent(),
            ]
        ], 200);
    }

    /**
     * Check user permissions
     * 
     * @OA\Post(
     *     path="/api/auth/check-permission",
     *     summary="Check if user has permission",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"permission"},
     *             @OA\Property(property="permission", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Permission check result")
     * )
     */
    public function checkPermission(Request $request)
    {
        $request->validate([
            'permission' => 'required|string',
        ]);

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
                'has_permission' => false,
            ], 401);
        }

        $hasPermission = $user->hasPermissionTo($request->permission);

        return response()->json([
            'success' => true,
            'permission' => $request->permission,
            'has_permission' => $hasPermission,
        ], 200);
    }

    /**
     * Logout (revoke token)
     * 
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout from admin panel",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Logout successful")
     * )
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            // Log activity
            activity()
                ->causedBy($user)
                ->log('User logged out via API');

            // Revoke all tokens
            $user->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }

    /**
     * Ensure the login request is not rate limited.
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
    }
}
