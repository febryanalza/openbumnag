@extends('admin.layouts.app')

@section('title', 'Permission Matrix')
@section('page-title', 'Permission Matrix')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Permission</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Grup Permission</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['groups'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Role</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['roles_count'] }}</p>
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
                    <h2 class="text-lg font-semibold text-gray-900">Permission Matrix</h2>
                    <p class="text-sm text-gray-500">Kelola permission untuk setiap role dengan mudah</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        View List
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Kelola Role
                    </a>
                    <a href="{{ route('admin.permissions.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Permission
                    </a>
                </div>
            </div>
        </div>

        <!-- Legend -->
        <div class="p-4 bg-gray-50 border-b border-gray-200">
            <div class="flex flex-wrap items-center gap-4 text-sm">
                <span class="font-medium text-gray-700">Legend:</span>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-green-100 border-2 border-green-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-gray-600">Aktif</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-gray-100 border-2 border-gray-300"></div>
                    <span class="text-gray-600">Tidak Aktif</span>
                </div>
                <span class="text-gray-500 ml-auto">Klik untuk toggle permission</span>
            </div>
        </div>

        <!-- Matrix Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="sticky left-0 z-10 bg-gray-50 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            Module / Permission
                        </th>
                        @foreach($roles as $role)
                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                <div class="flex flex-col items-center">
                                    <span class="font-semibold text-gray-900">{{ ucfirst($role->name) }}</span>
                                    <span class="text-xs text-gray-400 mt-1">{{ $role->permissions_count ?? 0 }} perms</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($matrix as $groupKey => $group)
                        <!-- Group Header -->
                        <tr class="bg-amber-50">
                            <td colspan="{{ count($roles) + 1 }}" class="px-6 py-3 text-sm font-semibold text-amber-900 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $group['label'] }}
                                </div>
                            </td>
                        </tr>

                        <!-- Permissions in Group -->
                        @foreach($group['actions'] as $action => $permissions)
                            @foreach($permissions as $permission)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="sticky left-0 z-10 bg-white hover:bg-gray-50 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($action) }}
                                            </span>
                                            <span class="text-gray-500">{{ $permission->name }}</span>
                                        </div>
                                    </td>
                                    @foreach($roles as $role)
                                        @php
                                            $hasPermission = in_array($permission->id, $rolePermissions[$role->id] ?? []);
                                        @endphp
                                        <td class="px-4 py-4 text-center">
                                            <button 
                                                type="button"
                                                class="permission-toggle w-8 h-8 rounded transition-all duration-200 {{ $hasPermission ? 'bg-green-100 border-2 border-green-500 hover:bg-green-200' : 'bg-gray-100 border-2 border-gray-300 hover:bg-gray-200' }}"
                                                data-role-id="{{ $role->id }}"
                                                data-permission-id="{{ $permission->id }}"
                                                data-permission-name="{{ $permission->name }}"
                                                data-role-name="{{ $role->name }}"
                                                data-has-permission="{{ $hasPermission ? 'true' : 'false' }}"
                                                title="{{ $hasPermission ? 'Klik untuk revoke' : 'Klik untuk grant' }}"
                                            >
                                                @if($hasPermission)
                                                    <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                @endif
                                            </button>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="{{ count($roles) + 1 }}" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="mt-2 text-sm">Tidak ada permission yang tersedia</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Info -->
        <div class="p-4 bg-gray-50 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Total {{ $stats['total'] }} permissions dalam {{ $stats['groups'] }} grup modul</span>
                </div>
                <div class="text-gray-500">
                    Kelola {{ count($roles) }} roles
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 max-w-sm">
        <div class="flex items-start gap-3">
            <div id="toast-icon" class="flex-shrink-0"></div>
            <div class="flex-1">
                <p id="toast-message" class="text-sm font-medium text-gray-900"></p>
            </div>
            <button onclick="hideToast()" class="flex-shrink-0 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let isProcessing = false;

// Toggle permission
document.querySelectorAll('.permission-toggle').forEach(button => {
    button.addEventListener('click', async function() {
        if (isProcessing) return;
        
        isProcessing = true;
        const roleId = this.dataset.roleId;
        const permissionId = this.dataset.permissionId;
        const permissionName = this.dataset.permissionName;
        const roleName = this.dataset.roleName;
        const hasPermission = this.dataset.hasPermission === 'true';
        
        // Optimistic UI update
        this.classList.add('opacity-50', 'cursor-wait');
        
        try {
            const response = await fetch('{{ route('admin.permissions.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    role_id: roleId,
                    permission_id: permissionId
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update UI
                const newHasPermission = data.hasPermission;
                this.dataset.hasPermission = newHasPermission ? 'true' : 'false';
                
                if (newHasPermission) {
                    this.className = 'permission-toggle w-8 h-8 rounded transition-all duration-200 bg-green-100 border-2 border-green-500 hover:bg-green-200';
                    this.innerHTML = '<svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                    this.title = 'Klik untuk revoke';
                } else {
                    this.className = 'permission-toggle w-8 h-8 rounded transition-all duration-200 bg-gray-100 border-2 border-gray-300 hover:bg-gray-200';
                    this.innerHTML = '';
                    this.title = 'Klik untuk grant';
                }
                
                showToast(data.message, 'success');
            } else {
                throw new Error(data.message || 'Gagal mengupdate permission');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast(error.message || 'Terjadi kesalahan saat mengupdate permission', 'error');
        } finally {
            this.classList.remove('opacity-50', 'cursor-wait');
            isProcessing = false;
        }
    });
});

// Toast notification functions
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    const toastIcon = document.getElementById('toast-icon');
    
    toastMessage.textContent = message;
    
    if (type === 'success') {
        toastIcon.innerHTML = '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    } else {
        toastIcon.innerHTML = '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }
    
    toast.classList.remove('hidden');
    
    setTimeout(() => {
        hideToast();
    }, 3000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    toast.classList.add('hidden');
}
</script>
@endpush
@endsection
