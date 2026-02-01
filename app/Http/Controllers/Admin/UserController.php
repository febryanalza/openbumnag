<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of users with search, filter, and pagination.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search by name or email
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($role = $request->get('role')) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        // Filter by status
        if ($request->has('trashed') && $request->get('trashed') === 'only') {
            $query->onlyTrashed();
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['name', 'email', 'created_at'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::pluck('name', 'name');
        
        // Stats
        $stats = [
            'total' => User::count(),
            'active' => User::whereNotNull('email_verified_at')->count(),
            'trashed' => User::onlyTrashed()->count(),
        ];

        return view('admin.users.index', compact('users', 'roles', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,name'],
            'email_verified' => ['boolean'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'roles.required' => 'Pilih minimal satu role.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => $request->boolean('email_verified') ? now() : null,
        ]);

        $user->syncRoles($validated['roles']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil ditambahkan.");
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles', 'permissions');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name');
        $userRoles = $user->roles->pluck('name')->toArray();
        
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,name'],
            'email_verified' => ['boolean'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'roles.required' => 'Pilih minimal satu role.',
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => $request->boolean('email_verified') ? ($user->email_verified_at ?? now()) : null,
        ]);

        // Update password only if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->syncRoles($validated['roles']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil diperbarui.");
    }

    /**
     * Soft delete the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Prevent deleting super_admin if user is not super_admin
        if ($user->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus Super Admin.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User {$userName} berhasil dihapus.");
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil dipulihkan.");
    }

    /**
     * Permanently delete a user.
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $userName = $user->name;
        
        $user->forceDelete();

        return redirect()
            ->route('admin.users.index', ['trashed' => 'only'])
            ->with('success', "User {$userName} berhasil dihapus permanen.");
    }

    /**
     * Bulk action handler
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:delete,restore,force_delete'],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $action = $validated['action'];
        $ids = $validated['ids'];
        
        // Remove current user from selection
        $ids = array_diff($ids, [auth()->id()]);

        switch ($action) {
            case 'delete':
                $count = User::whereIn('id', $ids)->count();
                User::whereIn('id', $ids)->delete();
                $message = "{$count} user berhasil dihapus.";
                break;
                
            case 'restore':
                $count = User::onlyTrashed()->whereIn('id', $ids)->count();
                User::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} user berhasil dipulihkan.";
                break;
                
            case 'force_delete':
                $count = User::onlyTrashed()->whereIn('id', $ids)->count();
                User::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $message = "{$count} user berhasil dihapus permanen.";
                break;
                
            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        return back()->with('success', $message);
    }
}
