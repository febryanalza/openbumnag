<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DebugFilamentLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only log admin panel requests
        if ($request->is('admin*')) {
            $logData = [
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'ip' => $request->ip(),
                'session_id' => session()->getId(),
                'is_authenticated' => auth()->check(),
                'user_id' => auth()->id(),
                'has_csrf' => $request->header('X-CSRF-TOKEN') ? 'yes' : 'no',
            ];

            // Log to separate file for visibility
            Log::channel('single')->info('🔵 [ADMIN REQUEST]', $logData);
            
            // Also write to custom debug file
            $debugFile = storage_path('logs/filament-debug.log');
            $line = sprintf(
                "[%s] %s %s | Session: %s | Auth: %s | User: %s\n",
                $logData['timestamp'],
                $logData['method'],
                $logData['path'],
                substr($logData['session_id'], 0, 8),
                $logData['is_authenticated'] ? 'YES' : 'NO',
                $logData['user_id'] ?? 'none'
            );
            file_put_contents($debugFile, $line, FILE_APPEND);
            
            // Special logging for POST to login
            if ($request->isMethod('POST') && $request->is('admin/login')) {
                Log::channel('single')->warning('🔴 [LOGIN POST DETECTED]', [
                    'form_data' => [
                        'email' => $request->input('email'),
                        'has_password' => $request->has('password'),
                        'remember' => $request->input('remember'),
                    ],
                    'session_before' => session()->getId(),
                    'auth_before' => auth()->check(),
                ]);
            }
        }

        $response = $next($request);

        // Log response for login attempts
        if ($request->is('admin/login')) {
            Log::channel('single')->info('🟢 [LOGIN RESPONSE]', [
                'status' => $response->getStatusCode(),
                'location' => $response->headers->get('Location'),
                'session_after' => session()->getId(),
                'auth_after' => auth()->check(),
                'user_after' => auth()->id(),
            ]);
        }

        return $response;
    }
}
