<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
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
     * Display a listing of permissions.
     */
    public function index(Request $request)
    {
        $query = Permission::query();

        // Search
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by group
        if ($group = $request->get('group')) {
            $query->where('name', 'like', "{$group}.%");
        }

        // Sorting
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $permissions = $query->paginate(20)->withQueryString();

        // Get grouped permissions for overview (cached)
        $groupedPermissions = CacheService::getGroupedPermissions();

        // Stats (cached)
        $stats = CacheService::getPermissionStats();

        return view('admin.permissions.index', compact('permissions', 'groupedPermissions', 'stats'))
            ->with('permissionGroups', $this->permissionGroups);
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        return view('admin.permissions.create')
            ->with('permissionGroups', $this->permissionGroups);
    }

    /**
     * Store a newly created permission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name', 'regex:/^[a-z0-9._-]+$/'],
            'guard_name' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique' => 'Permission dengan nama ini sudah ada.',
            'name.regex' => 'Nama permission hanya boleh berisi huruf kecil, angka, titik, underscore, dan dash.',
        ]);

        $permission = Permission::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'] ?? 'web',
        ]);

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearPermissionsCache();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "Permission '{$permission->name}' berhasil dibuat.");
    }

    /**
     * Display the specified permission.
     */
    public function show(Permission $permission)
    {
        $permission->load('roles');
        
        return view('admin.permissions.show', compact('permission'))
            ->with('permissionGroups', $this->permissionGroups);
    }

    /**
     * Show the form for editing a permission.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'))
            ->with('permissionGroups', $this->permissionGroups);
    }

    /**
     * Update the specified permission.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $permission->id, 'regex:/^[a-z0-9._-]+$/'],
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique' => 'Permission dengan nama ini sudah ada.',
            'name.regex' => 'Nama permission hanya boleh berisi huruf kecil, angka, titik, underscore, dan dash.',
        ]);

        $oldName = $permission->name;
        $permission->update(['name' => $validated['name']]);

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearPermissionsCache();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "Permission '{$oldName}' berhasil diperbarui menjadi '{$permission->name}'.");
    }

    /**
     * Remove the specified permission.
     */
    public function destroy(Permission $permission)
    {
        $name = $permission->name;
        
        // Detach from all roles first
        $permission->roles()->detach();
        $permission->delete();

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearPermissionsCache();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "Permission '{$name}' berhasil dihapus.");
    }

    /**
     * Bulk action on permissions.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:delete'],
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:permissions,id'],
        ]);

        $count = 0;

        switch ($validated['action']) {
            case 'delete':
                foreach ($validated['ids'] as $id) {
                    $permission = Permission::find($id);
                    if ($permission) {
                        $permission->roles()->detach();
                        $permission->delete();
                        $count++;
                    }
                }
                $message = "{$count} permission berhasil dihapus.";
                break;
            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearPermissionsCache();

        return back()->with('success', $message);
    }

    /**
     * Sync permissions to roles.
     */
    public function syncToRole(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $roleIds = $validated['roles'] ?? [];
        $roles = Role::whereIn('id', $roleIds)->get();

        // Sync permission to selected roles
        foreach (Role::all() as $role) {
            if ($roles->contains($role)) {
                $role->givePermissionTo($permission);
            } else {
                $role->revokePermissionTo($permission);
            }
        }

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        CacheService::clearPermissionsCache();
        CacheService::clearRolesCache();

        return redirect()
            ->route('admin.permissions.show', $permission)
            ->with('success', "Permission '{$permission->name}' berhasil disinkronkan ke role yang dipilih.");
    }
}
