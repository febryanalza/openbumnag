@extends('admin.layouts.app')

@section('title', 'Tambah Media Galeri')
@section('page-title', 'Tambah Media Galeri')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Info Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Media</h3>
            </div>
            <div class="p-6 space-y-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('title') border-red-500 @enderror"
                        placeholder="Masukkan judul media">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('description') border-red-500 @enderror"
                        placeholder="Deskripsi singkat tentang media ini">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type & File Type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="file_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe File <span class="text-red-500">*</span></label>
                        <select name="file_type" id="file_type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @foreach($fileTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('file_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('file_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @foreach($galleryTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- File Upload Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Upload File</h3>
            </div>
            <div class="p-6">
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File Media <span class="text-red-500">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-amber-400 transition" id="dropZone">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none">
                                    <span>Upload file</span>
                                    <input id="file" name="file" type="file" class="sr-only" required accept="image/*,video/*" onchange="previewFile(this)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, WEBP, MP4, WEBM hingga 50MB</p>
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">-- Tanpa Album --</option>
                            @foreach($albums as $album)
                                <option value="{{ $album }}" {{ old('album') === $album ? 'selected' : '' }}>{{ $album }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="new_album" class="block text-sm font-medium text-gray-700 mb-1">Atau Buat Album Baru</label>
                        <input type="text" name="new_album" id="new_album" value="{{ old('new_album') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Nama album baru">
                    </div>
                </div>

                <!-- Photographer & Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="photographer" class="block text-sm font-medium text-gray-700 mb-1">Fotografer</label>
                        <input type="text" name="photographer" id="photographer" value="{{ old('photographer') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Nama fotografer">
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Lokasi pengambilan">
                    </div>
                </div>

                <!-- Taken Date & Order -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="taken_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengambilan</label>
                        <input type="date" name="taken_date" id="taken_date" value="{{ old('taken_date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="0">
                        <p class="mt-1 text-xs text-gray-500">Angka lebih kecil ditampilkan lebih dulu</p>
                    </div>
                </div>

                <!-- Featured -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <label for="is_featured" class="text-sm font-medium text-gray-700">
                        Tandai sebagai unggulan
                        <span class="text-gray-400 font-normal">- Akan ditampilkan di halaman utama</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                ← Kembali
            </a>
            <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition shadow-sm">
                Simpan Media
            </button>
        </div>
    </form>
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

    // Drag and drop
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('file');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.add('border-amber-500', 'bg-amber-50'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.remove('border-amber-500', 'bg-amber-50'), false);
    });

    dropZone.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        previewFile(fileInput);
    }, false);
</script>
@endpush
@endsection

