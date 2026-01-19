<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AssignRolesToUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assign super_admin role to the first user
        $firstUser = User::first();
        
        if ($firstUser) {
            $firstUser->assignRole('super_admin');
            $this->command->info("✓ User '{$firstUser->email}' assigned as super_admin");
        } else {
            $this->command->warn('⚠ No users found in database. Please create a user first.');
        }

        // You can add more role assignments here
        // Example:
        // User::where('email', 'editor@example.com')->first()?->assignRole('editor');
        // User::where('email', 'viewer@example.com')->first()?->assignRole('viewer');
    }
}
