@extends('admin.layouts.app')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.catalogs.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Current Product Info --}}
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl p-6 mb-6 text-white">
        <div class="flex items-center gap-4">
            @if($catalog->featured_image)
                <img src="{{ Storage::url($catalog->featured_image) }}" alt="{{ $catalog->name }}" class="w-16 h-16 rounded-xl object-cover border-2 border-white/30">
            @else
                <div class="w-16 h-16 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            @endif
            <div>
                <h2 class="text-xl font-bold">{{ $catalog->name }}</h2>
                <p class="text-white/80">{{ $catalog->bumnagProfile->name ?? '-' }}</p>
                <p class="text-white/60 text-sm mt-1">{{ $catalog->formatted_price }} • Stok: {{ $catalog->stock }} {{ $catalog->unit }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.catalogs.update', $catalog) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Informasi Produk --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Produk</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="bumnag_profile_id" class="block text-sm font-medium text-gray-700 mb-1">BUMNag <span class="text-red-500">*</span></label>
                    <select name="bumnag_profile_id" id="bumnag_profile_id" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                        @foreach($bumnagProfiles as $id => $name)
                            <option value="{{ $id }}" {{ old('bumnag_profile_id', $catalog->bumnag_profile_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $catalog->name) }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug URL</label>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 text-sm">/kodai/</span>
                        <div class="flex-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 text-sm">
                            <span id="slugDisplay">{{ old('slug', $catalog->slug) }}</span>
                        </div>
                    </div>
                    <input type="hidden" name="slug" id="slug" value="{{ old('slug', $catalog->slug) }}">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">{{ old('description', $catalog->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" id="category" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category', $catalog->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $catalog->sku) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Harga & Stok --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h3 class="text-lg font-semibold text-gray-900">Harga & Stok</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $catalog->price) }}" min="0" step="100" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $catalog->stock) }}" min="0" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                        <select name="unit" id="unit" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Pilih Satuan</option>
                            @foreach($units as $key => $label)
                                <option value="{{ $key }}" {{ old('unit', $catalog->unit) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gambar --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-semibold text-gray-900">Gambar Produk</h3>
            </div>
            <div class="p-6 space-y-6">
                {{-- Featured Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama</label>
                    @if($catalog->featured_image)
                        <div class="flex items-start gap-4 mb-4">
                            <img src="{{ Storage::url($catalog->featured_image) }}" alt="{{ $catalog->name }}" class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                            <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                Hapus gambar
                            </label>
                        </div>
                    @endif
                    <input type="file" name="featured_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    <p class="mt-1 text-xs text-gray-500">Maksimal 2MB (JPG, PNG, WebP)</p>
                </div>

                {{-- Gallery Images --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Gambar</label>
                    @if($catalog->images && count($catalog->images) > 0)
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-3 mb-4">
                            @foreach($catalog->images as $image)
                                <div class="relative group">
                                    <img src="{{ Storage::url($image) }}" alt="Gallery" class="w-full h-20 object-cover rounded-lg border border-gray-200">
                                    <label class="absolute top-1 right-1 cursor-pointer">
                                        <input type="checkbox" name="remove_gallery_images[]" value="{{ $image }}" class="sr-only peer">
                                        <span class="w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 peer-checked:opacity-100 peer-checked:bg-red-700 transition-all" title="Hapus">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mb-3">Centang gambar yang ingin dihapus</p>
                    @endif
                    <div id="newGalleryPreview" class="grid grid-cols-4 sm:grid-cols-6 gap-3 mb-4 hidden"></div>
                    <input type="file" name="images[]" accept="image/*" multiple onchange="previewNewGallery(this)" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">Tambah gambar baru (maks. 10 total, 2MB per file)</p>
                </div>
            </div>
        </div>

        {{-- Spesifikasi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <h3 class="text-lg font-semibold text-gray-900">Spesifikasi</h3>
            </div>
            <div class="p-6">
                <textarea name="specifications" id="specifications" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-amber-500 focus:border-amber-500">{{ old('specifications', $catalog->specifications ? json_encode($catalog->specifications, JSON_PRETTY_PRINT) : '') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Format JSON: {"key": "value", ...}</p>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Status</h3>
            </div>
            <div class="p-6 space-y-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_available" value="0">
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', $catalog->is_available) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                    <div>
                        <span class="text-sm font-medium text-gray-900">Produk Tersedia</span>
                        <p class="text-xs text-gray-500">Produk dapat dilihat dan dipesan</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $catalog->is_featured) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                    <div>
                        <span class="text-sm font-medium text-gray-900">Produk Unggulan</span>
                        <p class="text-xs text-gray-500">Tampilkan di halaman utama</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-between">
            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-4 py-2 text-red-600 hover:bg-red-50 font-medium text-sm rounded-lg transition-colors">
                Hapus Produk
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.catalogs.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Delete Modal --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <div class="text-center">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Produk</h3>
            <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus <strong>{{ $catalog->name }}</strong>? Data akan dihapus permanen.</p>
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form action="{{ route('admin.catalogs.destroy', $catalog) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-lg">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Generate slug from name
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

    // Live slug update from name field
    document.getElementById('name').addEventListener('input', function() {
        const slug = generateSlug(this.value);
        document.getElementById('slugDisplay').textContent = slug || 'slug-akan-muncul-disini';
        document.getElementById('slug').value = slug;
    });

    // Preview new gallery images
    function previewNewGallery(input) {
        const container = document.getElementById('newGalleryPreview');
        container.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            container.classList.remove('hidden');
            
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="New ${index + 1}" class="w-full h-20 object-cover rounded-lg border-2 border-green-300">
                        <div class="absolute inset-0 bg-green-500 bg-opacity-40 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xs font-medium">Baru</span>
                        </div>
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
