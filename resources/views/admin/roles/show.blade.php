@extends('admin.layouts.app')

@section('title', 'Detail Role: ' . $role->name)
@section('page-title', 'Detail Role')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.roles.clone', $role) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Clone Role
            </a>
            <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Role
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Role Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center 
                                @if($role->name === 'super_admin') bg-red-100 text-red-600
                                @elseif($role->name === 'admin') bg-purple-100 text-purple-600
                                @elseif($role->name === 'content_manager') bg-blue-100 text-blue-600
                                @elseif($role->name === 'editor') bg-green-100 text-green-600
                                @else bg-gray-100 text-gray-600 @endif">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold text-gray-900">{{ $role->name }}</h2>
                                <p class="text-sm text-gray-500">Dibuat {{ $role->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($role->name === 'super_admin')
                            <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Protected
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900">{{ $role->permissions->count() }}</p>
                            <p class="text-sm text-gray-500">Permissions</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900">{{ $role->users->count() }}</p>
                            <p class="text-sm text-gray-500">Pengguna</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900">{{ count($permissions) }}</p>
                            <p class="text-sm text-gray-500">Grup</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions by Group -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Permissions</h3>
                    <p class="text-sm text-gray-500">Daftar permissions yang dimiliki role ini</p>
                </div>
                <div class="p-6">
                    @if($role->name === 'super_admin')
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-800">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="font-medium">Role super_admin memiliki akses penuh</p>
                                    <p class="mt-1">Role ini memiliki semua permissions yang ada dalam sistem dan tidak dapat dibatasi.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            @forelse($permissions as $group => $groupPermissions)
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-700">{{ $permissionGroups[$group] ?? ucfirst($group) }}</span>
                                            <span class="ml-2 px-2 py-0.5 text-xs bg-amber-100 text-amber-800 rounded-full">{{ $groupPermissions->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($groupPermissions as $permission)
                                                @php
                                                    $parts = explode('.', $permission->name);
                                                    $action = $parts[1] ?? $permission->name;
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">
                                                    @if(str_contains($action, 'view'))
                                                        <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    @elseif(str_contains($action, 'create'))
                                                        <svg class="w-3 h-3 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                    @elseif(str_contains($action, 'update'))
                                                        <svg class="w-3 h-3 mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    @elseif(str_contains($action, 'delete'))
                                                        <svg class="w-3 h-3 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    @endif
                                                    {{ ucfirst(str_replace('-', ' ', $action)) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <p>Role ini belum memiliki permission</p>
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="text-amber-600 hover:text-amber-700 mt-2 inline-block">Tambahkan permission</a>
                                </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Users with this Role -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Pengguna</h3>
                        <p class="text-sm text-gray-500">Pengguna dengan role ini</p>
                    </div>
                    <span class="px-2 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">{{ $role->users->count() }}</span>
                </div>
                <div class="p-6">
                    @if($role->users->count() > 0)
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @foreach($role->users as $user)
                                <div class="flex items-center p-2 hover:bg-gray-50 rounded-lg">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-sm font-medium">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-500">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="text-sm">Belum ada pengguna</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Assign Users -->
            @if($role->name !== 'super_admin')
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Assign Pengguna</h3>
                    <p class="text-sm text-gray-500">Tambahkan pengguna ke role ini</p>
                </div>
                <form method="POST" action="{{ route('admin.roles.assign-users', $role) }}" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label for="users" class="block text-sm font-medium text-gray-700 mb-2">Pilih Pengguna</label>
                        <select name="users[]" id="users" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" style="min-height: 120px;">
                            @foreach($allUsers as $user)
                                @if(!$role->users->contains($user))
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endif
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Tahan Ctrl untuk memilih beberapa pengguna</p>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                        Assign ke Role
                    </button>
                </form>
            </div>
            @endif

            <!-- Quick Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Guard</span>
                        <span class="font-medium text-gray-900">{{ $role->guard_name }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Dibuat</span>
                        <span class="font-medium text-gray-900">{{ $role->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Terakhir diubah</span>
                        <span class="font-medium text-gray-900">{{ $role->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Code Reference -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Referensi Kode</h3>
                    <p class="text-sm text-gray-500">Cara menggunakan role ini</p>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Controller</p>
                        <div class="bg-gray-900 rounded-lg p-3 overflow-x-auto">
                            <code class="text-xs text-gray-100">$user->hasRole('{{ $role->name }}')</code>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Middleware</p>
                        <div class="bg-gray-900 rounded-lg p-3 overflow-x-auto">
                            <code class="text-xs text-gray-100">->middleware('role:{{ $role->name }}')</code>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Blade</p>
                        <div class="bg-gray-900 rounded-lg p-3 overflow-x-auto">
                            <code class="text-xs text-gray-100">@role('{{ $role->name }}')</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
