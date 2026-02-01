@extends('admin.layouts.app')

@section('title', 'Edit Laporan')
@section('page-title', 'Edit Laporan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Current Report Header -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-900 rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/4 p-6 flex items-center justify-center">
                @if($report->cover_image)
                    <img src="{{ asset('storage/' . $report->cover_image) }}" 
                        alt="{{ $report->title }}" 
                        class="w-32 h-32 rounded-lg object-cover shadow-lg">
                @else
                    <div class="w-32 h-32 rounded-lg bg-white/10 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="md:w-3/4 p-6 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ $report->title }}</h2>
                        <p class="text-blue-200 mt-1">{{ $report->period }} • {{ $reportTypes[$report->type] ?? $report->type }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($report->status === 'published') bg-green-500/20 text-green-300
                        @elseif($report->status === 'draft') bg-yellow-500/20 text-yellow-300
                        @else bg-gray-500/20 text-gray-300 @endif">
                        {{ $statuses[$report->status] ?? $report->status }}
                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div>
                        <p class="text-blue-300 text-sm">Downloads</p>
                        <p class="text-lg font-semibold">{{ number_format($report->downloads) }}</p>
                    </div>
                    <div>
                        <p class="text-blue-300 text-sm">Tipe File</p>
                        <p class="text-lg font-semibold uppercase">{{ $report->file_type ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-300 text-sm">Ukuran</p>
                        <p class="text-lg font-semibold">{{ $report->file_path ? $report->getFileSizeFormatted() : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-300 text-sm">Dibuat</p>
                        <p class="text-lg font-semibold">{{ $report->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.reports.update', $report) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Info Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Dasar</h3>
            </div>
            <div class="p-6 space-y-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Laporan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $report->title) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug & Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug URL</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $report->slug) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" id="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $report->category_id) == $category->id ? 'selected' : '' }}>
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('description', $report->description) }}</textarea>
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
                                <input type="radio" name="type" value="{{ $key }}" class="peer sr-only" {{ old('type', $report->type) === $key ? 'checked' : '' }}>
                                <div class="flex items-center justify-center gap-2 px-4 py-3 border-2 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-gray-50 transition">
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ old('year', $report->year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select name="month" id="month"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">-- Pilih Bulan --</option>
                            @foreach($months as $key => $label)
                                <option value="{{ $key }}" {{ old('month', $report->month) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="quarter" class="block text-sm font-medium text-gray-700 mb-1">Kuartal</label>
                        <select name="quarter" id="quarter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">-- Pilih Kuartal --</option>
                            @foreach($quarters as $key => $label)
                                <option value="{{ $key }}" {{ old('quarter', $report->quarter) == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                <!-- Current File -->
                @if($report->file_path)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                @if($report->file_type === 'pdf') bg-red-100
                                @elseif(in_array($report->file_type, ['xls', 'xlsx'])) bg-green-100
                                @else bg-blue-100 @endif">
                                <span class="text-sm font-bold uppercase
                                    @if($report->file_type === 'pdf') text-red-600
                                    @elseif(in_array($report->file_type, ['xls', 'xlsx'])) text-green-600
                                    @else text-blue-600 @endif">
                                    {{ $report->file_type }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">File saat ini</p>
                                <p class="text-sm text-gray-500">{{ $report->getFileSizeFormatted() }}</p>
                            </div>
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remove_file" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <span class="text-sm text-red-600">Hapus file</span>
                        </label>
                    </div>
                @endif

                <!-- File Upload -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">{{ $report->file_path ? 'Ganti File' : 'Upload File' }}</label>
                    <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx" onchange="showFileName(this, 'fileNameDisplay')"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <p id="fileNameDisplay" class="mt-2 text-sm text-gray-600 hidden"></p>
                    <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX hingga 20MB</p>
                </div>

                <!-- Current Cover -->
                @if($report->cover_image)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('storage/' . $report->cover_image) }}" alt="Cover" class="w-12 h-12 rounded-lg object-cover">
                            <div>
                                <p class="font-medium text-gray-900">Cover image saat ini</p>
                            </div>
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remove_cover_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <span class="text-sm text-red-600">Hapus cover</span>
                        </label>
                    </div>
                @endif

                <!-- Cover Image Upload -->
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">{{ $report->cover_image ? 'Ganti Cover Image' : 'Cover Image' }}</label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*" onchange="previewImage(this, 'coverPreview')"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <div id="coverPreview" class="mt-2 hidden">
                        <img src="" alt="Preview" class="max-h-32 rounded-lg">
                    </div>
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('content', $report->content) }}</textarea>
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $report->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi</label>
                        <input type="datetime-local" name="published_at" id="published_at" 
                            value="{{ old('published_at', $report->published_at?->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
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
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Laporan</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus laporan ini? Laporan akan dipindahkan ke sampah.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                <form method="POST" action="{{ route('admin.reports.destroy', $report) }}">
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
</script>
@endpush
@endsection
