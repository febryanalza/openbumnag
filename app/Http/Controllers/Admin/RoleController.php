<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    /**
     * Permission groups for organized display
     */
    protected array $permissionGroups = [
        'news' => 'Berita',
        'promotion' => 'Promosi',
        'report' => 'Laporan',
        'gallery' => 'Galeri',
        'category' => 'Kategori',
        'profile' => 'Profil BUMNag',
        'team' => 'Tim',
        'contact' => 'Kontak',
        'setting' => 'Pengaturan',
        'catalog' => 'Katalog',
        'user' => 'Pengguna',
    ];

    /**
     * Display a listing of roles.
     */
    public function index(Request $request)
    {
        $query = Role::withCount(['permissions', 'users']);

        // Search
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Sorting
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['name', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        } elseif ($sortField === 'permissions_count') {
            $query->orderBy('permissions_count', $sortDirection);
        } elseif ($sortField === 'users_count') {
            $query->orderBy('users_count', $sortDirection);
        }

        $roles = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'total_users' => User::count(),
            'users_with_roles' => User::has('roles')->count(),
        ];

        return view('admin.roles.index', compact('roles', 'stats'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        // Use cached grouped permissions
        $permissions = CacheService::getGroupedPermissions();

        return view('admin.roles.create', compact('permissions'))
            ->with('permissionGroups', $this->permissionGroups);
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name', 'regex:/^[a-z0-9_]+$/'],
            'guard_name' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Role dengan nama ini sudah ada.',
            'name.regex' => 'Nama role hanya boleh berisi huruf kecil, angka, dan underscore.',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'] ?? 'web',
        ]);

        // Sync permissions
        if (!empty($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearRolesCache();
        CacheService::clearPermissionsCache();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', "Role '{$role->name}' berhasil dibuat.");
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        
        $groupedPermissions = $role->permissions->groupBy(function ($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'other';
        });

        return view('admin.roles.show', compact('role', 'groupedPermissions'))
            ->with('permissionGroups', $this->permissionGroups);
    }

    /**
     * Show the form for editing a role.
     */
    public function edit(Role $role)
    {
        // Use cached grouped permissions
        $permissions = CacheService::getGroupedPermissions();

        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissionIds'))
            ->with('permissionGroups', $this->permissionGroups);
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        // Prevent editing super_admin role name
        $nameRules = ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id];
        if ($role->name !== 'super_admin') {
            $nameRules[] = 'regex:/^[a-z0-9_]+$/';
        }

        $validated = $request->validate([
            'name' => $role->name === 'super_admin' ? [] : $nameRules,
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Role dengan nama ini sudah ada.',
            'name.regex' => 'Nama role hanya boleh berisi huruf kecil, angka, dan underscore.',
        ]);

        $oldName = $role->name;

        // Update name (except for super_admin)
        if ($role->name !== 'super_admin' && isset($validated['name'])) {
            $role->update(['name' => $validated['name']]);
        }

        // Sync permissions (super_admin always gets all permissions)
        if ($role->name === 'super_admin') {
            $role->syncPermissions(Permission::all());
        } else {
            $permissions = !empty($validated['permissions']) 
                ? Permission::whereIn('id', $validated['permissions'])->get() 
                : [];
            $role->syncPermissions($permissions);
        }

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearRolesCache();
        CacheService::clearPermissionsCache();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', "Role '{$role->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        // Prevent deleting super_admin role
        if ($role->name === 'super_admin') {
            return back()->with('error', 'Role super_admin tidak dapat dihapus.');
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            return back()->with('error', "Role '{$role->name}' masih memiliki pengguna. Hapus pengguna dari role ini terlebih dahulu.");
        }

        $name = $role->name;
        $role->permissions()->detach();
        $role->delete();

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearRolesCache();
        CacheService::clearPermissionsCache();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', "Role '{$name}' berhasil dihapus.");
    }

    /**
     * Bulk action on roles.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:delete'],
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:roles,id'],
        ]);

        $count = 0;
        $errors = [];

        switch ($validated['action']) {
            case 'delete':
                foreach ($validated['ids'] as $id) {
                    $role = Role::find($id);
                    if ($role) {
                        if ($role->name === 'super_admin') {
                            $errors[] = "Role 'super_admin' tidak dapat dihapus.";
                            continue;
                        }
                        if ($role->users()->count() > 0) {
                            $errors[] = "Role '{$role->name}' masih memiliki pengguna.";
                            continue;
                        }
                        $role->permissions()->detach();
                        $role->delete();
                        $count++;
                    }
                }
                $message = "{$count} role berhasil dihapus.";
                break;
            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearRolesCache();
        CacheService::clearPermissionsCache();

        if (!empty($errors)) {
            return back()
                ->with('success', $message)
                ->with('warning', implode(' ', $errors));
        }

        return back()->with('success', $message);
    }

    /**
     * Assign users to role.
     */
    public function assignUsers(Request $request, Role $role)
    {
        $validated = $request->validate([
            'users' => ['nullable', 'array'],
            'users.*' => ['exists:users,id'],
        ]);

        $userIds = $validated['users'] ?? [];

        // Remove role from all current users
        foreach ($role->users as $user) {
            $user->removeRole($role);
        }

        // Assign role to selected users
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $user->assignRole($role);
            }
        }

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearRolesCache();

        return redirect()
            ->route('admin.roles.show', $role)
            ->with('success', "Pengguna berhasil diperbarui untuk role '{$role->name}'.");
    }

    /**
     * Clone a role with its permissions.
     */
    public function clone(Role $role)
    {
        $newName = $role->name . '_copy';
        $counter = 1;
        
        while (Role::where('name', $newName)->exists()) {
            $newName = $role->name . '_copy_' . $counter;
            $counter++;
        }

        $newRole = Role::create([
            'name' => $newName,
            'guard_name' => $role->guard_name,
        ]);

        $newRole->syncPermissions($role->permissions);

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearRolesCache();
        CacheService::clearPermissionsCache();

        return redirect()
            ->route('admin.roles.edit', $newRole)
            ->with('success', "Role '{$role->name}' berhasil diduplikasi sebagai '{$newRole->name}'.");
    }
}
