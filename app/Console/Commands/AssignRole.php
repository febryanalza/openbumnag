<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-role {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a role to a user by email';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');

        // Find user
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found!");
            return 1;
        }

        // Check if role exists
        $role = Role::where('name', $roleName)->first();
        
        if (!$role) {
            $this->error("Role '{$roleName}' does not exist!");
            $this->line('');
            $this->line('Available roles:');
            Role::all()->each(fn($r) => $this->line("  - {$r->name}"));
            return 1;
        }

        // Assign role
        $user->assignRole($roleName);
        
        $this->info("✓ Successfully assigned role '{$roleName}' to user '{$email}'");
        
        // Show user's current roles
        $this->line('');
        $this->line("Current roles for {$email}:");
        $user->getRoleNames()->each(fn($role) => $this->line("  • {$role}"));
        
        return 0;
    }
}
