@extends('admin.layouts.app')

@section('title', 'Kelola Role')
@section('page-title', 'Kelola Role')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Role</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_roles'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Permission</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_permissions'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m12 12V21"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Dengan Role</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['users_with_roles'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Role</h2>
                    <p class="text-sm text-gray-500">Kelola role dan permission untuk pengguna</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Kelola Permission
                    </a>
                    <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Role
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari role..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div id="bulkActions" class="hidden p-4 bg-amber-50 border-b border-amber-200">
            <form id="bulkForm" method="POST" action="{{ route('admin.roles.bulk-action') }}" class="flex items-center gap-4">
                @csrf
                <span class="text-sm text-amber-800"><span id="selectedCount">0</span> item dipilih</span>
                <select name="action" class="px-3 py-1.5 border border-amber-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500">
                    <option value="">Pilih Aksi</option>
                    <option value="delete">Hapus</option>
                </select>
                <button type="submit" class="px-4 py-1.5 bg-amber-600 text-white rounded-lg text-sm hover:bg-amber-700 transition-colors" onclick="return confirm('Yakin ingin melakukan aksi ini?')">
                    Terapkan
                </button>
            </form>
        </div>

        <!-- Role Cards Grid -->
        <div class="p-6">
            @if($roles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($roles as $role)
                        <div class="relative bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Checkbox -->
                            @if($role->name !== 'super_admin')
                                <div class="absolute top-3 left-3 z-10">
                                    <input type="checkbox" name="ids[]" value="{{ $role->id }}" form="bulkForm" class="item-checkbox rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                </div>
                            @endif

                            <!-- Badge -->
                            @if($role->name === 'super_admin')
                                <div class="absolute top-3 right-3">
                                    <span class="px-2 py-1 text-xs font-medium bg-red-500 text-white rounded-full">Super Admin</span>
                                </div>
                            @endif

                            <!-- Header -->
                            <div class="p-6 {{ $role->name === 'super_admin' ? 'bg-gradient-to-r from-red-500 to-orange-500' : 'bg-gradient-to-r from-amber-500 to-yellow-500' }}">
                                <div class="flex items-center justify-center">
                                    <div class="p-4 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-center text-white text-xl font-bold mt-4">{{ $role->name }}</h3>
                            </div>

                            <!-- Stats -->
                            <div class="p-4 border-b border-gray-200">
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900">{{ $role->permissions_count }}</p>
                                        <p class="text-xs text-gray-500">Permission</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900">{{ $role->users_count }}</p>
                                        <p class="text-xs text-gray-500">Pengguna</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="p-4 flex items-center justify-center gap-2">
                                <a href="{{ route('admin.roles.show', $role) }}" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg" title="Lihat">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.roles.edit', $role) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.roles.clone', $role) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Duplikasi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </form>
                                @if($role->name !== 'super_admin')
                                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="inline" onsubmit="return confirm('Hapus role ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada role</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan role baru.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($roles->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.item-checkbox').forEach(cb => {
        cb.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        
        if (checked.length > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = checked.length;
        } else {
            bulkActions.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
