<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

/**
 * Custom Login Page untuk BUMNag Admin Panel
 * 
 * Extends Filament's default Login tanpa override authenticate()
 * untuk menghindari masalah dengan flow autentikasi.
 */
class Login extends BaseLogin
{
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
