@extends('admin.layouts.app')

@section('title', 'Edit Permission')
@section('page-title', 'Edit Permission')

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
            <h2 class="text-lg font-semibold text-gray-900">Edit Permission</h2>
            <p class="text-sm text-gray-500">Perbarui informasi permission</p>
        </div>

        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Permission Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Permission <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror" placeholder="contoh: news.create">
                <p class="mt-1 text-xs text-gray-500">Gunakan format: grup.aksi (contoh: news.view, catalog.delete). Hanya huruf kecil, angka, titik, underscore, dan dash.</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Guard Name (read-only) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Guard Name</label>
                <input type="text" value="{{ $permission->guard_name }}" disabled class="w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500">
                <p class="mt-1 text-xs text-gray-500">Guard name tidak dapat diubah</p>
            </div>

            <!-- Info -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">Perhatian</p>
                        <p class="mt-1">Mengubah nama permission akan mempengaruhi semua role yang menggunakan permission ini. Pastikan untuk memperbarui kode yang mereferensikan permission lama.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="border-t border-gray-200 pt-6 flex items-center justify-between">
                <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Permission
                </button>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.permissions.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
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
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl max-w-md w-full mx-4 p-6">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-center text-gray-900 mb-2">Hapus Permission</h3>
        <p class="text-sm text-gray-500 text-center mb-6">Apakah Anda yakin ingin menghapus permission "<strong>{{ $permission->name }}</strong>"? Permission akan dihapus dari semua role yang menggunakannya.</p>
        <div class="flex items-center justify-center gap-4">
            <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Batal
            </button>
            <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
