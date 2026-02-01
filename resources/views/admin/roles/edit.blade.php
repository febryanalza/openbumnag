@extends('admin.layouts.app')

@section('title', 'Edit Role: ' . $role->name)
@section('page-title', 'Edit Role')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Edit Role: {{ $role->name }}</h2>
                    <p class="text-sm text-gray-500">Ubah permission untuk role ini</p>
                </div>
                @if($role->name === 'super_admin')
                    <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Protected Role
                    </span>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Role Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Role <span class="text-red-500">*</span></label>
                @if($role->name === 'super_admin')
                    <input type="text" value="{{ $role->name }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-500" disabled>
                    <input type="hidden" name="name" value="{{ $role->name }}">
                    <p class="mt-1 text-xs text-amber-600">Nama role super_admin tidak dapat diubah</p>
                @else
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror" placeholder="contoh: content_editor">
                    <p class="mt-1 text-xs text-gray-500">Hanya huruf kecil, angka, dan underscore. Contoh: content_manager, finance_admin</p>
                @endif
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Permissions -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <label class="block text-sm font-medium text-gray-700">Permissions</label>
                    @if($role->name !== 'super_admin')
                        <div class="flex items-center gap-2">
                            <button type="button" id="selectAll" class="text-sm text-amber-600 hover:text-amber-700">Pilih Semua</button>
                            <span class="text-gray-300">|</span>
                            <button type="button" id="deselectAll" class="text-sm text-gray-600 hover:text-gray-700">Batalkan Semua</button>
                        </div>
                    @endif
                </div>

                @if($role->name === 'super_admin')
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-800">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-medium">Role super_admin memiliki akses penuh</p>
                                <p class="mt-1">Role ini selalu memiliki semua permission dan tidak dapat dibatasi.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($permissions as $group => $groupPermissions)
                            @php
                                $groupPermissionIds = $groupPermissions->pluck('id')->toArray();
                                $checkedCount = count(array_intersect($groupPermissionIds, $rolePermissionIds));
                                $allChecked = $checkedCount === count($groupPermissionIds);
                                $someChecked = $checkedCount > 0 && !$allChecked;
                            @endphp
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 flex items-center justify-between cursor-pointer" onclick="toggleGroup('{{ $group }}')">
                                    <div class="flex items-center">
                                        <input type="checkbox" class="group-checkbox rounded border-gray-300 text-amber-600 focus:ring-amber-500 mr-3" data-group="{{ $group }}" {{ $allChecked ? 'checked' : '' }} {{ $someChecked ? 'data-indeterminate="true"' : '' }} onclick="event.stopPropagation(); toggleGroupCheckbox('{{ $group }}')">
                                        <span class="font-medium text-gray-700">{{ $permissionGroups[$group] ?? ucfirst($group) }}</span>
                                        <span class="ml-2 px-2 py-0.5 text-xs bg-gray-200 text-gray-600 rounded-full">{{ $checkedCount }}/{{ $groupPermissions->count() }}</span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 transform transition-transform" id="arrow-{{ $group }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div class="hidden p-4 border-t border-gray-200 bg-white" id="group-{{ $group }}">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($groupPermissions as $permission)
                                            @php
                                                $parts = explode('.', $permission->name);
                                                $action = $parts[1] ?? $permission->name;
                                            @endphp
                                            <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" data-group="{{ $group }}" {{ in_array($permission->id, old('permissions', $rolePermissionIds)) ? 'checked' : '' }} class="permission-checkbox rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                                <span class="ml-2 text-sm text-gray-700">{{ ucfirst(str_replace('-', ' ', $action)) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="border-t border-gray-200 pt-6 flex items-center justify-between">
                @if($role->name !== 'super_admin')
                    <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-4 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                        Hapus Role
                    </button>
                @else
                    <div></div>
                @endif
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.roles.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
@if($role->name !== 'super_admin')
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="document.getElementById('deleteModal').classList.add('hidden')"></div>
        
        <div class="relative z-10 inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h3 class="mb-2 text-lg font-semibold text-center text-gray-900">Hapus Role</h3>
            <p class="mb-4 text-sm text-center text-gray-500">
                Apakah Anda yakin ingin menghapus role <strong>{{ $role->name }}</strong>? 
                @if($role->users->count() > 0)
                    <span class="text-red-600">Role ini digunakan oleh {{ $role->users->count() }} pengguna.</span>
                @endif
            </p>
            
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    // Set indeterminate state on load
    document.querySelectorAll('.group-checkbox[data-indeterminate="true"]').forEach(cb => {
        cb.indeterminate = true;
    });

    function toggleGroup(group) {
        const content = document.getElementById('group-' + group);
        const arrow = document.getElementById('arrow-' + group);
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    }

    function toggleGroupCheckbox(group) {
        const groupCheckbox = document.querySelector(`.group-checkbox[data-group="${group}"]`);
        const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
        
        checkboxes.forEach(cb => cb.checked = groupCheckbox.checked);
        groupCheckbox.indeterminate = false;
    }

    // Update group checkbox state based on individual checkboxes
    document.querySelectorAll('.permission-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const group = this.dataset.group;
            updateGroupCheckboxState(group);
        });
    });

    function updateGroupCheckboxState(group) {
        const groupCheckbox = document.querySelector(`.group-checkbox[data-group="${group}"]`);
        const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
        const checkedCount = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]:checked`).length;
        
        groupCheckbox.checked = checkedCount === checkboxes.length;
        groupCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
    }

    // Select all / Deselect all
    document.getElementById('selectAll')?.addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
        document.querySelectorAll('.group-checkbox').forEach(cb => {
            cb.checked = true;
            cb.indeterminate = false;
        });
    });

    document.getElementById('deselectAll')?.addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.group-checkbox').forEach(cb => {
            cb.checked = false;
            cb.indeterminate = false;
        });
    });
</script>
@endpush
@endsection
