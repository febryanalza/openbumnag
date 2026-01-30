<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Log;

/**
 * Custom Login Page untuk BUMNag Admin Panel
 * 
 * Extends Filament's default Login dengan temporary logging
 */
class Login extends BaseLogin
{
    /**
     * Override authenticate untuk debugging
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            Log::info('🔐 [FILAMENT LOGIN] Attempting authentication', [
                'email' => $this->form->getState()['email'] ?? 'not provided',
                'session_id' => session()->getId(),
                'user_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'app_env' => app()->environment(),
                'session_driver' => config('session.driver'),
            ]);

            // Call parent authenticate
            $response = parent::authenticate();
            
            Log::info('✅ [FILAMENT LOGIN] Authentication successful', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user()?->email,
                'session_id' => session()->getId(),
                'redirect_intended' => url()->intended(),
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error('❌ [FILAMENT LOGIN] Authentication failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'email' => $this->form->getState()['email'] ?? 'not provided',
                'session_id' => session()->getId(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Get the heading for the login page
     */
    public function getHeading(): string | Htmlable | null
    {
        return 'Masuk ke Admin Panel';
    }

    /**
     * Get the title for the login page
     */
    public function getTitle(): string | Htmlable
    {
        return 'Login - BUMNag Admin';
    }
}
