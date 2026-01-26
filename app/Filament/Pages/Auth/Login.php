<?php

namespace App\Filament\Pages\Auth;

use Filament\Notifications\Notification;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    /**
     * Override authenticate to add logging and debugging
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            Log::info('🔐 [LOGIN] Mulai proses autentikasi', [
                'email' => $this->data['email'] ?? 'tidak ada',
                'has_password' => isset($this->data['password']),
                'ip' => request()->ip(),
            ]);

            // Check if user exists
            $user = \App\Models\User::where('email', $this->data['email'])->first();
            
            if (!$user) {
                Log::warning('❌ [LOGIN] User tidak ditemukan', ['email' => $this->data['email']]);
            } else {
                Log::info('✅ [LOGIN] User ditemukan', [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'roles_count' => $user->roles()->count(),
                    'roles' => $user->getRoleNames()->toArray(),
                ]);
            }

            // Call parent authenticate
            $response = parent::authenticate();
            
            Log::info('✅ [LOGIN] Autentikasi berhasil!', [
                'user_id' => auth()->id(),
                'redirect_to' => url()->current(),
            ]);

            return $response;

        } catch (\Exception $e) {
            Log::error('❌ [LOGIN] Error saat autentikasi', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Show error to user
            Notification::make()
                ->danger()
                ->title('Error Login')
                ->body('Error: ' . $e->getMessage())
                ->persistent()
                ->send();

            throw $e;
        }
    }

    /**
     * Override to provide better error messages ONLY when authentication fails
     */
    protected function throwFailureValidationException(): never
    {
        Log::warning('⚠️ [LOGIN] Validasi gagal - credentials tidak valid');

        // Only check if data is set
        if (!isset($this->data['email'])) {
            Log::error('❌ [LOGIN] Email tidak diisi');
            throw ValidationException::withMessages([
                'data.email' => 'Email dan password wajib diisi.',
            ]);
        }

        // Check if user exists
        $user = \App\Models\User::where('email', $this->data['email'])->first();

        if (!$user) {
            Log::warning('❌ [LOGIN] User tidak ditemukan di database', [
                'email' => $this->data['email'],
            ]);

            // User not found
            Notification::make()
                ->danger()
                ->title('Login Gagal')
                ->body('Email yang Anda masukkan tidak terdaftar.')
                ->persistent()
                ->send();

            throw ValidationException::withMessages([
                'data.email' => 'Email tidak ditemukan dalam sistem.',
            ]);
        }

        // Check if user has any roles (only if user exists)
        if (!$user->roles()->exists()) {
            Log::error('❌ [LOGIN] User tidak memiliki role', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            Notification::make()
                ->danger()
                ->title('Akses Ditolak')
                ->body('Akun Anda belum memiliki role. Silakan hubungi administrator.')
                ->persistent()
                ->send();

            throw ValidationException::withMessages([
                'data.email' => 'Akun Anda belum memiliki hak akses.',
            ]);
        }

        Log::warning('❌ [LOGIN] Password salah', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        // Default error message for wrong password
        Notification::make()
            ->danger()
            ->title('Login Gagal')
            ->body('Email atau password yang Anda masukkan salah.')
            ->persistent()
            ->send();

        throw ValidationException::withMessages([
            'data.email' => 'Email atau password tidak sesuai.',
        ]);
    }

    /**
     * Get the heading for the login page
     */
    public function getHeading(): string
    {
        return 'Masuk ke Admin Panel';
    }

    /**
     * Get the subheading for the login page
     */
    public function getSubHeading(): ?string
    {
        return 'Masukkan kredensial Anda untuk mengakses dashboard';
    }
}
