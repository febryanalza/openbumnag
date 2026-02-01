@extends('admin.layouts.app')

@section('title', 'Tambah Role')
@section('page-title', 'Tambah Role')

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
            <h2 class="text-lg font-semibold text-gray-900">Tambah Role Baru</h2>
            <p class="text-sm text-gray-500">Buat role baru dengan permission yang sesuai</p>
        </div>

        <form method="POST" action="{{ route('admin.roles.store') }}" class="p-6 space-y-6">
            @csrf

            <!-- Role Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Role <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror" placeholder="contoh: content_editor">
                <p class="mt-1 text-xs text-gray-500">Hanya huruf kecil, angka, dan underscore. Contoh: content_manager, finance_admin</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Permissions -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <label class="block text-sm font-medium text-gray-700">Permissions</label>
                    <div class="flex items-center gap-2">
                        <button type="button" id="selectAll" class="text-sm text-amber-600 hover:text-amber-700">Pilih Semua</button>
                        <span class="text-gray-300">|</span>
                        <button type="button" id="deselectAll" class="text-sm text-gray-600 hover:text-gray-700">Batalkan Semua</button>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($permissions as $group => $groupPermissions)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 flex items-center justify-between cursor-pointer" onclick="toggleGroup('{{ $group }}')">
                                <div class="flex items-center">
                                    <input type="checkbox" class="group-checkbox rounded border-gray-300 text-amber-600 focus:ring-amber-500 mr-3" data-group="{{ $group }}" onclick="event.stopPropagation(); toggleGroupCheckbox('{{ $group }}')">
                                    <span class="font-medium text-gray-700">{{ $permissionGroups[$group] ?? ucfirst($group) }}</span>
                                    <span class="ml-2 px-2 py-0.5 text-xs bg-gray-200 text-gray-600 rounded-full">{{ $groupPermissions->count() }}</span>
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
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" data-group="{{ $group }}" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }} class="permission-checkbox rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ ucfirst(str_replace('-', ' ', $action)) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="border-t border-gray-200 pt-6 flex items-center justify-end gap-4">
                <a href="{{ route('admin.roles.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                    Simpan Role
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
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
    document.getElementById('selectAll').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
        document.querySelectorAll('.group-checkbox').forEach(cb => {
            cb.checked = true;
            cb.indeterminate = false;
        });
    });

    document.getElementById('deselectAll').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.group-checkbox').forEach(cb => {
            cb.checked = false;
            cb.indeterminate = false;
        });
    });
</script>
@endpush
@endsection
