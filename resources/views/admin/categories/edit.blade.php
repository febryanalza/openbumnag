@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center">
            @if($category->icon)
                <div class="flex-shrink-0 w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center text-3xl">
                    <i class="{{ $category->icon }}"></i>
                </div>
            @else
                <div class="flex-shrink-0 w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
            @endif
            <div class="ml-4 flex-1">
                <h2 class="text-xl font-bold">{{ $category->name }}</h2>
                <p class="text-amber-100">{{ $category->slug }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                    {{ $types[$category->type] ?? $category->type }}
                </span>
                @if($category->is_active)
                    <span class="px-3 py-1 bg-green-500 rounded-full text-sm">Aktif</span>
                @else
                    <span class="px-3 py-1 bg-red-500 rounded-full text-sm">Nonaktif</span>
                @endif
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Informasi Dasar</h3>
                <p class="text-sm text-gray-500">Informasi utama kategori</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama kategori">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug (Auto-generated, display only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug URL</label>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 text-sm">
                            <span id="slugDisplay">{{ old('slug', $category->slug) }}</span>
                        </div>
                    </div>
                    <input type="hidden" name="slug" id="slug" value="{{ old('slug', $category->slug) }}">
                    <p class="mt-1 text-xs text-gray-500">Slug akan otomatis diperbarui saat mengubah nama</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('description') border-red-500 @enderror"
                        placeholder="Deskripsi singkat kategori">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Type & Appearance -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Tipe & Tampilan</h3>
                <p class="text-sm text-gray-500">Pengaturan tipe dan tampilan kategori</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Tipe Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($types as $key => $label)
                            @php
                                $typeIcons = [
                                    'general' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
                                    'news' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
                                    'report' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                                    'promotion' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>',
                                ];
                                $typeColors = [
                                    'general' => 'gray',
                                    'news' => 'blue',
                                    'report' => 'purple',
                                    'promotion' => 'orange',
                                ];
                            @endphp
                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="{{ $key }}" class="peer sr-only" {{ old('type', $category->type) == $key ? 'checked' : '' }}>
                                <div class="p-4 border-2 border-gray-200 rounded-lg text-center transition-all peer-checked:border-{{ $typeColors[$key] }}-500 peer-checked:bg-{{ $typeColors[$key] }}-50 hover:border-gray-300">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-{{ $typeColors[$key] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $typeIcons[$key] !!}
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon & Color -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                            Icon
                        </label>
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="fa-solid fa-tag">
                        <p class="mt-1 text-xs text-gray-500">Gunakan kelas icon Font Awesome atau Heroicons</p>
                    </div>
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                            Warna
                        </label>
                        <div class="flex gap-3">
                            <input type="color" name="color" id="color" value="{{ old('color', $category->color ?? '#f59e0b') }}"
                                class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" id="colorText" value="{{ old('color', $category->color ?? '#f59e0b') }}"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="#f59e0b">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Pengaturan</h3>
                <p class="text-sm text-gray-500">Pengaturan tambahan kategori</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan
                        </label>
                        <input type="number" name="order" id="order" value="{{ old('order', $category->order) }}" min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <p class="mt-1 text-xs text-gray-500">Urutan tampil (0 = paling atas)</p>
                    </div>

                    <!-- Is Active -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Aktif</span>
                        </label>
                        <p class="mt-1 text-xs text-gray-500">Kategori akan ditampilkan jika aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                Hapus Kategori
            </button>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                    Perbarui Kategori
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <div class="text-center">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Kategori</h3>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus kategori "{{ $category->name }}"? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-center gap-4">
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Sync color input with text input
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('colorText');
    
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
    });
    
    colorText.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            colorInput.value = this.value;
        }
    });

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

    // Live slug update
    document.getElementById('name').addEventListener('input', function() {
        const slug = generateSlug(this.value);
        document.getElementById('slugDisplay').textContent = slug || 'slug-akan-muncul-disini';
        document.getElementById('slug').value = slug;
    });

    // Close modal on outside click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
