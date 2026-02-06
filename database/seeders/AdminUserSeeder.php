<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates an admin user for BUMNag application
     */
    public function run(): void
    {
        // Check if super admin already exists
        $existingAdmin = User::whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->first();

        if ($existingAdmin) {
            $this->command->warn("⚠ Super admin already exists: {$existingAdmin->email}");
            return;
        }

        // Create super admin user
        $admin = User::create([
            'name' => 'Admin BUMNag',
            'email' => 'admin@bumnag.com',
            'password' => Hash::make('password123'), // GANTI PASSWORD INI!
            'email_verified_at' => now(),
        ]);

        // Assign super_admin role
        $admin->assignRole('super_admin');

        $this->command->info("✓ Super admin created successfully!");
        $this->command->info("  Email: {$admin->email}");
        $this->command->warn("  Password: password123");
        $this->command->warn("  ⚠ IMPORTANT: Change password after first login!");
    }
}
