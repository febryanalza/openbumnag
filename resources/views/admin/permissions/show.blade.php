@extends('admin.layouts.app')

@section('title', 'Detail Permission')
@section('page-title', 'Detail Permission')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
        <a href="{{ route('admin.permissions.edit', $permission) }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-purple-600">
            <div class="flex items-center">
                <div class="p-4 bg-white/20 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="ml-4 text-white">
                    <h1 class="text-2xl font-bold">{{ $permission->name }}</h1>
                    @php
                        $parts = explode('.', $permission->name);
                        $group = $parts[0] ?? 'other';
                    @endphp
                    <p class="text-white/80">Grup: {{ $permissionGroups[$group] ?? ucfirst($group) }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-xs text-gray-500">Guard Name</p>
                    <p class="text-gray-900 font-medium">{{ $permission->guard_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Dibuat</p>
                    <p class="text-gray-900">{{ $permission->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Diperbarui</p>
                    <p class="text-gray-900">{{ $permission->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Roles Using This Permission -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-md font-semibold text-gray-900">Role yang Menggunakan Permission Ini</h3>
                    <span class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">{{ $permission->roles->count() }} role</span>
                </div>

                @if($permission->roles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permission->roles as $role)
                            <a href="{{ route('admin.roles.show', $role) }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-amber-50 transition-colors">
                                <div class="p-2 bg-amber-100 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $role->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $role->permissions->count() }} permissions</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Tidak ada role yang menggunakan permission ini</p>
                    </div>
                @endif
            </div>

            <!-- Sync to Roles Form -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4">Sinkronkan ke Role</h3>
                <form method="POST" action="{{ route('admin.permissions.sync-to-role', $permission) }}">
                    @csrf
                    @php
                        $allRoles = \Spatie\Permission\Models\Role::all();
                        $permissionRoleIds = $permission->roles->pluck('id')->toArray();
                    @endphp
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                        @foreach($allRoles as $role)
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, $permissionRoleIds) ? 'checked' : '' }} {{ $role->name === 'super_admin' ? 'checked disabled' : '' }} class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mb-4">Super admin selalu memiliki semua permission.</p>
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                        Sinkronkan
                    </button>
                </form>
            </div>

            <!-- Code Usage Reference -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-md font-semibold text-gray-900 mb-4">Referensi Penggunaan</h3>
                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                    <pre class="text-sm text-gray-100"><code>// Cek permission di Controller
if ($user->hasPermissionTo('{{ $permission->name }}')) {
    // User memiliki permission
}

// Middleware di Route
Route::middleware(['check.permission:{{ $permission->name }}'])

// Blade Directive
@@can('{{ $permission->name }}')
    // Tampilkan konten
@@endcan</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
