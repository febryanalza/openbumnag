@extends('admin.layouts.app')

@section('title', 'Tambah Laporan')
@section('page-title', 'Tambah Laporan')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.reports.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Info Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Dasar</h3>
            </div>
            <div class="p-6 space-y-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Laporan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('title') border-red-500 @enderror"
                        placeholder="Masukkan judul laporan">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug & Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug URL</label>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 text-sm">/laporan/</span>
                            <div class="flex-1 px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 text-sm">
                                <span id="slugDisplay">slug-akan-muncul-disini</span>
                            </div>
                        </div>
                        <input type="hidden" name="slug" id="slug" value="{{ old('slug') }}">
                        <p class="mt-1 text-xs text-gray-500">Slug akan dibuat otomatis dari judul</p>
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" id="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="Deskripsi singkat tentang laporan ini">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Type & Period Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Tipe & Periode</h3>
            </div>
            <div class="p-6 space-y-4">
                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Laporan <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($reportTypes as $key => $label)
                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="{{ $key }}" class="peer sr-only" {{ old('type', 'financial') === $key ? 'checked' : '' }}>
                                <div class="flex items-center justify-center gap-2 px-4 py-3 border-2 rounded-lg peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:bg-gray-50 transition">
                                    @if($key === 'financial')
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @elseif($key === 'activity')
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                    @elseif($key === 'annual')
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    @endif
                                    <span class="text-sm font-medium">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Period Fields -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                        <select name="year" id="year" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ old('year', date('Y')) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select name="month" id="month"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">-- Pilih Bulan --</option>
                            @foreach($months as $key => $label)
                                <option value="{{ $key }}" {{ old('month') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="quarter" class="block text-sm font-medium text-gray-700 mb-1">Kuartal</label>
                        <select name="quarter" id="quarter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">-- Pilih Kuartal --</option>
                            @foreach($quarters as $key => $label)
                                <option value="{{ $key }}" {{ old('quarter') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Upload Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">File & Media</h3>
            </div>
            <div class="p-6 space-y-4">
                <!-- File Upload -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File Laporan</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-amber-400 transition">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500">
                                    <span>Upload file</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept=".pdf,.doc,.docx,.xls,.xlsx" onchange="showFileName(this, 'fileNameDisplay')">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX hingga 20MB</p>
                        </div>
                    </div>
                    <p id="fileNameDisplay" class="mt-2 text-sm text-gray-600 hidden"></p>
                    @error('file')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*" onchange="previewImage(this, 'coverPreview')"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <div id="coverPreview" class="mt-2 hidden">
                        <img src="" alt="Preview" class="max-h-32 rounded-lg">
                    </div>
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Konten Tambahan</h3>
            </div>
            <div class="p-6">
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten / Ringkasan</label>
                    <textarea name="content" id="content" rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="Isi ringkasan atau konten detail laporan">{{ old('content') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Bisa berisi ringkasan, highlight, atau konten lengkap laporan</p>
                </div>
            </div>
        </div>

        <!-- Publishing Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Pengaturan Publikasi</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'draft') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi</label>
                        <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <p class="mt-1 text-xs text-gray-500">Biarkan kosong untuk menggunakan waktu saat publikasi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                ← Kembali
            </a>
            <div class="flex gap-3">
                <button type="submit" name="status" value="draft" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Simpan Draft
                </button>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition shadow-sm">
                    Simpan Laporan
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function showFileName(input, displayId) {
        const display = document.getElementById(displayId);
        if (input.files && input.files[0]) {
            display.textContent = '📄 ' + input.files[0].name + ' (' + (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
            display.classList.remove('hidden');
        } else {
            display.classList.add('hidden');
        }
    }

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Generate slug from title
    function generateSlug(title) {
        return title
            .toLowerCase()
            .trim()
            .replace(/[àáâãäå]/g, 'a')
            .replace(/[èéêë]/g, 'e')
            .replace(/[ìíîï]/g, 'i')
            .replace(/[òóôõö]/g, 'o')
            .replace(/[ùúûü]/g, 'u')
            .replace(/[ñ]/g, 'n')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    // Live slug update
    document.getElementById('title').addEventListener('input', function() {
        const slug = generateSlug(this.value);
        document.getElementById('slugDisplay').textContent = slug || 'slug-akan-muncul-disini';
        document.getElementById('slug').value = slug;
    });
</script>
@endpush
@endsection

