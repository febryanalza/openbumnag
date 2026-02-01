@extends('admin.layouts.app')

@section('title', 'Tambah Permission')
@section('page-title', 'Tambah Permission')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Tambah Permission Baru</h2>
            <p class="text-sm text-gray-500">Buat permission baru untuk kontrol akses</p>
        </div>

        <form method="POST" action="{{ route('admin.permissions.store') }}" class="p-6 space-y-6">
            @csrf

            <!-- Permission Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Permission <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror" placeholder="contoh: news.create">
                <p class="mt-1 text-xs text-gray-500">Gunakan format: grup.aksi (contoh: news.view, catalog.delete). Hanya huruf kecil, angka, titik, underscore, dan dash.</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quick Format -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Format Cepat</label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <select id="groupSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Pilih Grup</option>
                            @foreach($permissionGroups as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                            <option value="custom">Custom...</option>
                        </select>
                    </div>
                    <div>
                        <select id="actionSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Pilih Aksi</option>
                            <option value="view-any">View Any (Lihat Semua)</option>
                            <option value="view">View (Lihat)</option>
                            <option value="create">Create (Buat)</option>
                            <option value="update">Update (Ubah)</option>
                            <option value="delete">Delete (Hapus)</option>
                            <option value="publish">Publish (Terbitkan)</option>
                            <option value="unpublish">Unpublish (Batalkan Terbit)</option>
                            <option value="restore">Restore (Pulihkan)</option>
                            <option value="force-delete">Force Delete (Hapus Permanen)</option>
                        </select>
                    </div>
                </div>
                <button type="button" id="applyFormat" class="mt-2 text-sm text-amber-600 hover:text-amber-700">
                    Terapkan Format →
                </button>
            </div>

            <!-- Guard Name -->
            <div>
                <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-2">Guard Name</label>
                <input type="text" name="guard_name" id="guard_name" value="{{ old('guard_name', 'web') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('guard_name') border-red-500 @enderror" placeholder="web">
                <p class="mt-1 text-xs text-gray-500">Biarkan 'web' untuk guard default</p>
                @error('guard_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Existing Permissions Reference -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Referensi Permission yang Ada</h3>
                <div class="bg-gray-50 rounded-lg p-4 max-h-48 overflow-y-auto">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                        @foreach($permissionGroups as $key => $label)
                            <div class="font-medium text-gray-700">{{ $label }}:</div>
                            <div class="col-span-1 md:col-span-2 text-gray-500">
                                {{ $key }}.view-any, {{ $key }}.view, {{ $key }}.create, {{ $key }}.update, {{ $key }}.delete
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="border-t border-gray-200 pt-6 flex items-center justify-end gap-4">
                <a href="{{ route('admin.permissions.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                    Simpan Permission
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('applyFormat').addEventListener('click', function() {
        const group = document.getElementById('groupSelect').value;
        const action = document.getElementById('actionSelect').value;
        
        if (group && action && group !== 'custom') {
            document.getElementById('name').value = group + '.' + action;
        }
    });
</script>
@endpush
@endsection
