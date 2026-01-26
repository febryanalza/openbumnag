<?php

namespace App\Filament\Pages\Auth;

use Filament\Notifications\Notification;
use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    /**
     * Override to provide better error messages ONLY when authentication fails
     */
    protected function throwFailureValidationException(): never
    {
        // Only check if data is set
        if (!isset($this->data['email'])) {
            throw ValidationException::withMessages([
                'data.email' => 'Email dan password wajib diisi.',
            ]);
        }

        // Check if user exists
        $user = \App\Models\User::where('email', $this->data['email'])->first();

        if (!$user) {
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
