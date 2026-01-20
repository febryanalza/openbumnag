<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ==================== PERMISSIONS ====================
        
        // News Permissions
        $newsPermissions = [
            'news.view-any',
            'news.view',
            'news.create',
            'news.update',
            'news.delete',
            'news.publish',
            'news.unpublish',
        ];

        // Promotion Permissions
        $promotionPermissions = [
            'promotion.view-any',
            'promotion.view',
            'promotion.create',
            'promotion.update',
            'promotion.delete',
            'promotion.publish',
            'promotion.unpublish',
        ];

        // Report Permissions
        $reportPermissions = [
            'report.view-any',
            'report.view',
            'report.create',
            'report.update',
            'report.delete',
            'report.publish',
            'report.unpublish',
        ];

        // Gallery Permissions
        $galleryPermissions = [
            'gallery.view-any',
            'gallery.view',
            'gallery.create',
            'gallery.update',
            'gallery.delete',
        ];

        // Category Permissions
        $categoryPermissions = [
            'category.view-any',
            'category.view',
            'category.create',
            'category.update',
            'category.delete',
        ];

        // Bumnag Profile Permissions
        $profilePermissions = [
            'profile.view-any',
            'profile.view',
            'profile.update',
        ];

        // Team Member Permissions
        $teamPermissions = [
            'team.view-any',
            'team.view',
            'team.create',
            'team.update',
            'team.delete',
        ];

        // Contact Permissions
        $contactPermissions = [
            'contact.view-any',
            'contact.view',
            'contact.delete',
        ];

        // Settings Permissions
        $settingPermissions = [
            'setting.view-any',
            'setting.view',
            'setting.update',
        ];

        // Catalog Permissions
        $catalogPermissions = [
            'catalog.view-any',
            'catalog.view',
            'catalog.create',
            'catalog.update',
            'catalog.delete',
        ];

        // User Management Permissions
        $userPermissions = [
            'user.view-any',
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
        ];

        // Merge all permissions
        $allPermissions = array_merge(
            $newsPermissions,
            $promotionPermissions,
            $reportPermissions,
            $galleryPermissions,
            $categoryPermissions,
            $profilePermissions,
            $teamPermissions,
            $contactPermissions,
            $settingPermissions,
            $catalogPermissions,
            $userPermissions
        );

        // Create all permissions
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ==================== ROLES ====================

        // 1. Super Admin - Full Access
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions(Permission::all());

        // 2. Admin - Manage everything except users
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $adminPermissions = array_merge(
            $newsPermissions,
            $promotionPermissions,
            $reportPermissions,
            $galleryPermissions,
            $categoryPermissions,
            $profilePermissions,
            $teamPermissions,
            $contactPermissions,
            $settingPermissions,
            $catalogPermissions
        );
        $admin->syncPermissions($adminPermissions);

        // 3. Content Manager - Manage News, Promotions, Reports, Catalogs
        $contentManager = Role::firstOrCreate(['name' => 'content_manager']);
        $contentManagerPermissions = array_merge(
            $newsPermissions,
            $promotionPermissions,
            $reportPermissions,
            $catalogPermissions,
            ['gallery.view-any', 'gallery.view', 'gallery.create'],
            ['category.view-any', 'category.view']
        );
        $contentManager->syncPermissions($contentManagerPermissions);

        // 4. Editor - Create & Edit News, Promotions, Reports, Catalogs (no delete/publish)
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editorPermissions = [
            // News
            'news.view-any',
            'news.view',
            'news.create',
            'news.update',
            
            // Promotion
            'promotion.view-any',
            'promotion.view',
            'promotion.create',
            'promotion.update',
            
            // Report
            'report.view-any',
            'report.view',
            'report.create',
            'report.update',
            
            // Catalog
            'catalog.view-any',
            'catalog.view',
            'catalog.create',
            'catalog.update',
            
            // Gallery (limited)
            'gallery.view-any',
            'gallery.view',
            'gallery.create',
            
            // Category (read only)
            'category.view-any',
            'category.view',
        ];
        $editor->syncPermissions($editorPermissions);

        // 5. Viewer - Read Only Access
        $viewer = Role::firstOrCreate(['name' => 'viewer']);
        $viewerPermissions = [
            'news.view-any',
            'news.view',
            'promotion.view-any',
            'promotion.view',
            'report.view-any',
            'report.view',
            'gallery.view-any',
            'gallery.view',
            'category.view-any',
            'category.view',
            'profile.view-any',
            'profile.view',
            'team.view-any',
            'team.view',
            'contact.view-any',
            'contact.view',
            'catalog.view-any',
            'catalog.view',
        ];
        $viewer->syncPermissions($viewerPermissions);

        $this->command->info('Roles and Permissions created successfully!');
        $this->command->info('');
        $this->command->info('Available Roles:');
        $this->command->info('1. super_admin - Full access to everything');
        $this->command->info('2. admin - Manage all content and settings (no user management)');
        $this->command->info('3. content_manager - Manage News, Promotions, Reports, Catalogs with publish rights');
        $this->command->info('4. editor - Create and edit News, Promotions, Reports, Catalogs (no delete/publish)');
        $this->command->info('5. viewer - Read-only access to all content');
    }
}
