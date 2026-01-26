<?php

namespace App\Filament\Pages\Auth;

use Filament\Notifications\Notification;
use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    /**
     * Override the authenticate method to provide better error messages
     */
    protected function throwFailureValidationException(): never
    {
        // Check if data exists
        if (!isset($this->data['email']) || !isset($this->data['password'])) {
            Notification::make()
                ->danger()
                ->title('Login Gagal')
                ->body('Mohon isi email dan password dengan benar.')
                ->persistent()
                ->send();

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

        // User exists but password is wrong
        if (!Hash::check($this->data['password'], $user->password)) {
            Notification::make()
                ->danger()
                ->title('Login Gagal')
                ->body('Password yang Anda masukkan salah.')
                ->persistent()
                ->send();

            throw ValidationException::withMessages([
                'data.password' => 'Password tidak sesuai.',
            ]);
        }

        // Check if user has any roles
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

        // Check if user can access panel
        if (!$user->canAccessPanel(\Filament\Facades\Filament::getCurrentPanel())) {
            Notification::make()
                ->danger()
                ->title('Akses Ditolak')
                ->body('Anda tidak memiliki izin untuk mengakses panel admin.')
                ->persistent()
                ->send();

            throw ValidationException::withMessages([
                'data.email' => 'Anda tidak memiliki izin untuk mengakses panel ini.',
            ]);
        }

        // If we reach here, something else went wrong
        Notification::make()
            ->danger()
            ->title('Login Gagal')
            ->body('Terjadi kesalahan saat login. Silakan coba lagi.')
            ->persistent()
            ->send();

        throw ValidationException::withMessages([
            'data.email' => 'Login gagal. Silakan coba lagi.',
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
