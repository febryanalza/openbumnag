<?php

/**
 * Standalone script untuk membuat admin user BUMNag
 * 
 * Cara pakai:
 * 1. Upload file ini ke folder root project (bersama artisan)
 * 2. Edit email dan password di bawah
 * 3. Jalankan: php create-admin.php
 */

// Load Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// ==================== EDIT DI SINI ====================
$adminData = [
    'name' => 'Admin BUMNag',
    'email' => 'admin@bumnag.com',
    'password' => 'password123', // GANTI PASSWORD!
];
// ======================================================

echo "🔧 Creating Admin User for BUMNag\n";
echo "==================================\n\n";

try {
    // Check if user already exists
    $existingUser = User::where('email', $adminData['email'])->first();
    
    if ($existingUser) {
        echo "⚠️  User with email '{$adminData['email']}' already exists!\n";
        echo "   Name: {$existingUser->name}\n";
        echo "   Created: {$existingUser->created_at}\n\n";
        
        echo "Do you want to reset the password? (yes/no): ";
        $handle = fopen ("php://stdin","r");
        $line = trim(fgets($handle));
        
        if (strtolower($line) === 'yes' || strtolower($line) === 'y') {
            $existingUser->password = Hash::make($adminData['password']);
            $existingUser->save();
            
            // Ensure super_admin role
            if (!$existingUser->hasRole('super_admin')) {
                $existingUser->assignRole('super_admin');
            }
            
            echo "\n✅ Password reset successfully!\n";
            echo "   Email: {$existingUser->email}\n";
            echo "   New Password: {$adminData['password']}\n";
        } else {
            echo "\n❌ Operation cancelled.\n";
        }
        
        exit;
    }
    
    // Create new user
    $user = User::create([
        'name' => $adminData['name'],
        'email' => $adminData['email'],
        'password' => Hash::make($adminData['password']),
        'email_verified_at' => now(),
    ]);
    
    // Assign super_admin role
    $user->assignRole('super_admin');
    
    echo "✅ Admin user created successfully!\n\n";
    echo "📋 Login Details:\n";
    echo "   URL: " . config('app.url') . "/admin\n";
    echo "   Email: {$user->email}\n";
    echo "   Password: {$adminData['password']}\n\n";
    echo "⚠️  IMPORTANT: Change password after first login!\n\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\n💡 Possible solutions:\n";
    echo "   1. Check database connection in .env\n";
    echo "   2. Run: php artisan migrate\n";
    echo "   3. Run: php artisan db:seed --class=RolePermissionSeeder\n";
    exit(1);
}
