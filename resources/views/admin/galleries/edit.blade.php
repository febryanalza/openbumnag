@extends('admin.layouts.app')

@section('title', 'Edit Media Galeri')
@section('page-title', 'Edit Media Galeri')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Current Media Preview -->
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/3">
                @if($gallery->file_type === 'image')
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" 
                        alt="{{ $gallery->title }}" 
                        class="w-full h-48 md:h-full object-cover">
                @else
                    <video src="{{ asset('storage/' . $gallery->file_path) }}" 
                        class="w-full h-48 md:h-full object-cover" controls></video>
                @endif
            </div>
            <div class="md:w-2/3 p-6 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ $gallery->title }}</h2>
                        <p class="text-gray-300 mt-1">{{ $galleryTypes[$gallery->type] ?? $gallery->type }}</p>
                    </div>
                    <div class="flex gap-2">
                        @if($gallery->is_featured)
                            <span class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-sm">⭐ Unggulan</span>
                        @endif
                        <span class="px-3 py-1 bg-white/10 text-gray-300 rounded-full text-sm capitalize">{{ $fileTypes[$gallery->file_type] ?? $gallery->file_type }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div>
                        <p class="text-gray-400 text-sm">Views</p>
                        <p class="text-lg font-semibold">{{ number_format($gallery->views) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Ukuran</p>
                        <p class="text-lg font-semibold">{{ number_format($gallery->file_size / 1024 / 1024, 2) }} MB</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Album</p>
                        <p class="text-lg font-semibold">{{ $gallery->album ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Dibuat</p>
                        <p class="text-lg font-semibold">{{ $gallery->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.galleries.update', $gallery) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Info Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Media</h3>
            </div>
            <div class="p-6 space-y-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type & File Type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="file_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe File <span class="text-red-500">*</span></label>
                        <select name="file_type" id="file_type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @foreach($fileTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('file_type', $gallery->file_type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @foreach($galleryTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('type', $gallery->type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Upload Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Ganti File (Opsional)</h3>
            </div>
            <div class="p-6">
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Upload File Baru</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                    <span>Upload file baru</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept="image/*,video/*" onchange="previewFile(this)">
                                </label>
                                <p class="pl-1">untuk mengganti</p>
                            </div>
                            <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti</p>
                        </div>
                    </div>
                    <!-- Preview -->
                    <div id="filePreview" class="mt-4 hidden">
                        <div class="relative inline-block">
                            <img id="imagePreview" src="" alt="Preview" class="max-h-48 rounded-lg shadow hidden">
                            <video id="videoPreview" src="" class="max-h-48 rounded-lg shadow hidden" controls></video>
                            <button type="button" onclick="clearPreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('file')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Album & Details Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Album & Detail</h3>
            </div>
            <div class="p-6 space-y-4">
                <!-- Album -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="album" class="block text-sm font-medium text-gray-700 mb-1">Pilih Album</label>
                        <select name="album" id="album"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">-- Tanpa Album --</option>
                            @foreach($albums as $album)
                                <option value="{{ $album }}" {{ old('album', $gallery->album) === $album ? 'selected' : '' }}>{{ $album }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="new_album" class="block text-sm font-medium text-gray-700 mb-1">Atau Buat Album Baru</label>
                        <input type="text" name="new_album" id="new_album" value="{{ old('new_album') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Nama album baru">
                    </div>
                </div>

                <!-- Photographer & Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="photographer" class="block text-sm font-medium text-gray-700 mb-1">Fotografer</label>
                        <input type="text" name="photographer" id="photographer" value="{{ old('photographer', $gallery->photographer) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $gallery->location) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <!-- Taken Date & Order -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="taken_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengambilan</label>
                        <input type="date" name="taken_date" id="taken_date" value="{{ old('taken_date', $gallery->taken_date?->format('Y-m-d')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $gallery->order) }}" min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <!-- Featured -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $gallery->is_featured) ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <label for="is_featured" class="text-sm font-medium text-gray-700">
                        Tandai sebagai unggulan
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                ← Kembali
            </a>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                    class="px-4 py-2 text-red-600 hover:text-red-700 border border-red-300 rounded-lg hover:bg-red-50 transition">
                    Hapus
                </button>
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="document.getElementById('deleteModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Media</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus media ini? Media akan dipindahkan ke sampah.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:w-auto sm:text-sm">
                        Ya, Hapus
                    </button>
                </form>
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewFile(input) {
        const preview = document.getElementById('filePreview');
        const imagePreview = document.getElementById('imagePreview');
        const videoPreview = document.getElementById('videoPreview');
        const fileTypeSelect = document.getElementById('file_type');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (file.type.startsWith('image/')) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    videoPreview.classList.add('hidden');
                    fileTypeSelect.value = 'image';
                } else if (file.type.startsWith('video/')) {
                    videoPreview.src = e.target.result;
                    videoPreview.classList.remove('hidden');
                    imagePreview.classList.add('hidden');
                    fileTypeSelect.value = 'video';
                }
                preview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    }

    function clearPreview() {
        const input = document.getElementById('file');
        const preview = document.getElementById('filePreview');
        const imagePreview = document.getElementById('imagePreview');
        const videoPreview = document.getElementById('videoPreview');
        
        input.value = '';
        preview.classList.add('hidden');
        imagePreview.classList.add('hidden');
        videoPreview.classList.add('hidden');
    }
</script>
@endpush
@endsection
