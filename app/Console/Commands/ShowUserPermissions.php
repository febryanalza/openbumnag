<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ShowUserPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:permissions {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all permissions for a user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found!");
            return 1;
        }

        $this->line('');
        $this->info("═══════════════════════════════════════════");
        $this->info("  User Permissions: {$email}");
        $this->info("═══════════════════════════════════════════");
        $this->line('');

        // Show roles
        $this->line('🎭 Roles:');
        $roles = $user->getRoleNames();
        if ($roles->isEmpty()) {
            $this->warn('  No roles assigned');
        } else {
            $roles->each(fn($role) => $this->line("  • {$role}"));
        }

        $this->line('');

        // Show permissions
        $this->line('🔑 Permissions:');
        $permissions = $user->getAllPermissions();
        if ($permissions->isEmpty()) {
            $this->warn('  No permissions available');
        } else {
            // Group by resource
            $grouped = $permissions->groupBy(function ($permission) {
                return explode('.', $permission->name)[0];
            });

            foreach ($grouped as $resource => $perms) {
                $this->line('');
                $this->line("  📋 {$resource}:");
                $perms->each(function ($perm) {
                    $action = explode('.', $perm->name)[1] ?? '';
                    $this->line("     ✓ {$action}");
                });
            }
        }

        $this->line('');
        $this->info("═══════════════════════════════════════════");

        return 0;
    }
}
