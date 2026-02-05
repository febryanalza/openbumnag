@extends('admin.layouts.app')

@section('title', 'Edit Promosi')
@section('page-title', 'Edit Promosi')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('admin.promotions.index') }}" class="hover:text-amber-600">Promosi</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 font-medium">Edit</li>
        </ol>
    </nav>

    <!-- Current Promotion Header -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-xl shadow-sm p-6 mb-6 text-white">
        <div class="flex items-start gap-4">
            @if($promotion->featured_image)
                <img src="{{ Storage::url($promotion->featured_image) }}" alt="{{ $promotion->title }}" class="w-24 h-20 object-cover rounded-lg">
            @else
                <div class="w-24 h-20 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            @endif
            <div class="flex-1">
                <h2 class="text-xl font-bold">{{ $promotion->title }}</h2>
                <div class="flex items-center gap-4 mt-2 text-white/80 text-sm">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ number_format($promotion->views) }} views
                    </span>
                    <span class="px-2 py-0.5 bg-white/20 rounded-full text-xs">
                        {{ $promotionTypes[$promotion->promotion_type] ?? $promotion->promotion_type }}
                    </span>
                    @if($promotion->discount_percentage)
                        <span class="px-2 py-0.5 bg-red-500 rounded-full text-xs font-medium">
                            -{{ $promotion->discount_percentage }}%
                        </span>
                    @endif
                </div>
            </div>
            @php
                $statusColors = [
                    'draft' => 'bg-gray-500',
                    'active' => 'bg-green-500',
                    'expired' => 'bg-orange-500',
                    'archived' => 'bg-red-500',
                ];
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$promotion->status] ?? 'bg-gray-500' }}">
                {{ $statuses[$promotion->status] ?? $promotion->status }}
            </span>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Info Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Promosi <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $promotion->title) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug (Auto-generated, display only) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug URL</label>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 text-sm">/promosi/</span>
                        <div class="flex-1 px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 text-sm">
                            <span id="slugDisplay">{{ old('slug', $promotion->slug) }}</span>
                        </div>
                    </div>
                    <input type="hidden" name="slug" id="slug" value="{{ old('slug', $promotion->slug) }}">
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $promotion->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Promotion Type -->
                <div>
                    <label for="promotion_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Promosi <span class="text-red-500">*</span></label>
                    <select name="promotion_type" id="promotion_type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @foreach($promotionTypes as $key => $label)
                            <option value="{{ $key }}" {{ old('promotion_type', $promotion->promotion_type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Excerpt -->
                <div class="md:col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Ringkasan</label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('excerpt', $promotion->excerpt) }}</textarea>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="6" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('description') border-red-500 @enderror">{{ old('description', $promotion->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Harga & Diskon</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Original Price -->
                <div>
                    <label for="original_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Asli</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2 text-gray-500">Rp</span>
                        <input type="number" name="original_price" id="original_price" value="{{ old('original_price', $promotion->original_price) }}" step="0.01" min="0"
                            class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <!-- Discount Price -->
                <div>
                    <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Diskon</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2 text-gray-500">Rp</span>
                        <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price', $promotion->discount_price) }}" step="0.01" min="0"
                            class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <!-- Discount Percentage -->
                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-1">Persentase Diskon</label>
                    <div class="relative">
                        <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $promotion->discount_percentage) }}" min="0" max="100" readonly
                            class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed">
                        <span class="absolute right-4 top-2 text-gray-500">%</span>
                    </div>
                    <p class="mt-1 text-sm text-green-600">✓ Dihitung otomatis berdasarkan harga</p>
                </div>
            </div>
        </div>

        <!-- Media Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Media</h2>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama</label>
                
                @if($promotion->featured_image)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-start gap-4">
                            <img src="{{ Storage::url($promotion->featured_image) }}" alt="Current Image" class="w-32 h-24 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">Gambar saat ini</p>
                                <label class="flex items-center gap-2 mt-2 text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_featured_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    Hapus gambar ini
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-amber-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <div id="imagePreview" class="hidden mb-4">
                            <img id="previewImg" src="" alt="Preview" class="mx-auto h-32 object-cover rounded-lg">
                        </div>
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500">
                                <span>{{ $promotion->featured_image ? 'Ganti gambar' : 'Upload gambar' }}</span>
                                <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP maks. 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Promosi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="datetime-local" name="start_date" id="start_date" 
                        value="{{ old('start_date', $promotion->start_date ? $promotion->start_date->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir</label>
                    <input type="datetime-local" name="end_date" id="end_date" 
                        value="{{ old('end_date', $promotion->end_date ? $promotion->end_date->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Contact Person -->
                <div>
                    <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-1">Nama Kontak</label>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $promotion->contact_person) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <!-- Contact Phone -->
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $promotion->contact_phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <!-- Contact Email -->
                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $promotion->contact_email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <!-- Location -->
                <div class="md:col-span-3">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $promotion->location) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
            </div>
        </div>

        <!-- Terms & Status Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Syarat & Status</h2>
            
            <div class="space-y-4">
                <!-- Terms -->
                <div>
                    <label for="terms_conditions" class="block text-sm font-medium text-gray-700 mb-1">Syarat & Ketentuan</label>
                    <textarea name="terms_conditions" id="terms_conditions" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('terms_conditions', $promotion->terms_conditions) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $promotion->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Featured -->
                    <div class="flex items-center">
                        <label class="flex items-center gap-3 mt-6">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $promotion->is_featured) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Promosi Unggulan</span>
                                <p class="text-sm text-gray-500">Tampilkan di bagian utama</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" 
                class="px-4 py-2 text-red-600 hover:text-red-800 transition-colors">
                Hapus Promosi
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.promotions.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Hapus Promosi</h3>
                <p class="text-sm text-gray-500">Promosi akan dipindahkan ke sampah</p>
            </div>
        </div>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus promosi "<strong>{{ $promotion->title }}</strong>"?</p>
        <div class="flex items-center justify-end gap-3">
            <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" 
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            };
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

    // Auto-calculate discount percentage
    function calculateDiscountPercentage() {
        const originalPrice = parseFloat(document.getElementById('original_price').value) || 0;
        const discountPrice = parseFloat(document.getElementById('discount_price').value) || 0;
        const discountPercentageField = document.getElementById('discount_percentage');
        
        if (originalPrice > 0 && discountPrice >= 0) {
            const percentage = Math.round(((originalPrice - discountPrice) / originalPrice) * 100);
            discountPercentageField.value = percentage;
        } else {
            discountPercentageField.value = '';
        }
    }

    // Listen to price changes
    document.getElementById('original_price').addEventListener('input', calculateDiscountPercentage);
    document.getElementById('discount_price').addEventListener('input', calculateDiscountPercentage);
    
    // Calculate on page load
    calculateDiscountPercentage();
</script>
@endpush
@endsection

