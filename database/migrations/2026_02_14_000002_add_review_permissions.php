<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Review Permissions
        $reviewPermissions = [
            'review.view-any',
            'review.view',
            'review.approve',
            'review.reject',
            'review.delete',
        ];

        // Create permissions
        foreach ($reviewPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Add permissions to roles (if they exist)
        $rolesToAssign = ['super_admin', 'admin', 'content_manager'];
        
        foreach ($rolesToAssign as $roleName) {
            $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
            if ($role) {
                $role->givePermissionTo($reviewPermissions);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $reviewPermissions = [
            'review.view-any',
            'review.view',
            'review.approve',
            'review.reject',
            'review.delete',
        ];

        foreach ($reviewPermissions as $permission) {
            $perm = Permission::findByName($permission);
            if ($perm) {
                $perm->delete();
            }
        }
    }
};
