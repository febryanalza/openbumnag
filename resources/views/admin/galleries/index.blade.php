@extends('admin.layouts.app')

@section('title', 'Kelola Galeri')
@section('page-title', 'Kelola Galeri')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Media</p>
                    <p class="text-xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Gambar</p>
                    <p class="text-xl font-bold text-green-600">{{ number_format($stats['images']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Video</p>
                    <p class="text-xl font-bold text-purple-600">{{ number_format($stats['videos']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Di Sampah</p>
                    <p class="text-xl font-bold text-red-600">{{ number_format($stats['trashed']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari galeri..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- File Type Filter -->
            <select name="file_type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="all">Semua Tipe File</option>
                @foreach($fileTypes as $key => $label)
                    <option value="{{ $key }}" {{ request('file_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <!-- Type Filter -->
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="all">Semua Kategori</option>
                @foreach($galleryTypes as $key => $label)
                    <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <!-- Album Filter -->
            <select name="album" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="all">Semua Album</option>
                @foreach($albums as $album)
                    <option value="{{ $album }}" {{ request('album') === $album ? 'selected' : '' }}>{{ $album }}</option>
                @endforeach
            </select>

            <!-- Trashed Filter -->
            <select name="trashed" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="">Aktif</option>
                <option value="only" {{ request('trashed') === 'only' ? 'selected' : '' }}>Sampah</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">
                Filter
            </button>
            @if(request()->hasAny(['search', 'file_type', 'type', 'album', 'trashed']))
                <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-2" id="bulkActions" style="display: none;">
            <span class="text-sm text-gray-600"><span id="selectedCount">0</span> dipilih</span>
            <form method="POST" action="{{ route('admin.galleries.bulk-action') }}" id="bulkForm" class="flex gap-2">
                @csrf
                <input type="hidden" name="ids" id="bulkIds">
                @if(request('trashed') === 'only')
                    <button type="submit" name="action" value="restore" class="px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Pulihkan
                    </button>
                    <button type="submit" name="action" value="force_delete" class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition" 
                        onclick="return confirm('Hapus permanen media yang dipilih?')">
                        Hapus Permanen
                    </button>
                @else
                    <button type="submit" name="action" value="feature" class="px-3 py-1.5 text-sm bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                        Jadikan Unggulan
                    </button>
                    <button type="submit" name="action" value="unfeature" class="px-3 py-1.5 text-sm bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        Hapus Unggulan
                    </button>
                    <button type="submit" name="action" value="delete" class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Hapus
                    </button>
                @endif
            </form>
        </div>
        <a href="{{ route('admin.galleries.create') }}" 
            class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Media
        </a>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @forelse($galleries as $gallery)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group relative">
                <!-- Checkbox -->
                <div class="absolute top-2 left-2 z-10">
                    <input type="checkbox" class="gallery-checkbox w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500" 
                        value="{{ $gallery->id }}" onchange="updateBulkActions()">
                </div>

                <!-- Media Preview -->
                <a href="{{ route('admin.galleries.show', $gallery) }}" class="block aspect-square bg-gray-100 relative overflow-hidden">
                    @if($gallery->file_type === 'image')
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" 
                            alt="{{ $gallery->title }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-800">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @endif

                    <!-- Badges Overlay -->
                    <div class="absolute top-2 right-2 flex flex-col gap-1">
                        @if($gallery->is_featured)
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-yellow-500 rounded-full">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </span>
                        @endif
                        @if($gallery->file_type === 'video')
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-purple-500 rounded-full">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                        @endif
                    </div>

                    <!-- Trashed Overlay -->
                    @if($gallery->trashed())
                        <div class="absolute inset-0 bg-red-500/20 flex items-center justify-center">
                            <span class="bg-red-600 text-white text-xs px-2 py-1 rounded">Dihapus</span>
                        </div>
                    @endif
                </a>

                <!-- Info -->
                <div class="p-3">
                    <h3 class="font-medium text-gray-900 truncate text-sm" title="{{ $gallery->title }}">
                        {{ $gallery->title }}
                    </h3>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-xs px-2 py-0.5 rounded-full 
                            @if($gallery->type === 'event') bg-blue-100 text-blue-700
                            @elseif($gallery->type === 'activity') bg-green-100 text-green-700
                            @elseif($gallery->type === 'product') bg-purple-100 text-purple-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $galleryTypes[$gallery->type] ?? $gallery->type }}
                        </span>
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ number_format($gallery->views) }}
                        </span>
                    </div>
                    @if($gallery->album)
                        <p class="text-xs text-gray-400 mt-1 truncate">📁 {{ $gallery->album }}</p>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="px-3 pb-3 flex gap-2">
                    @if($gallery->trashed())
                        <form method="POST" action="{{ route('admin.galleries.restore', $gallery->id) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200 transition">
                                Pulihkan
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.galleries.force-delete', $gallery->id) }}" class="flex-1" onsubmit="return confirm('Hapus permanen media ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-2 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                Hapus Permanen
                            </button>
                        </form>
                    @else
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                            class="flex-1 px-2 py-1 text-xs text-center bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" class="flex-1" onsubmit="return confirm('Hapus media ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-2 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada media</h3>
                    <p class="text-gray-500 mb-4">Mulai tambahkan gambar atau video ke galeri Anda.</p>
                    <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Media Pertama
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            {{ $galleries->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    function updateBulkActions() {
        const checkboxes = document.querySelectorAll('.gallery-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        const bulkIds = document.getElementById('bulkIds');
        
        if (checkboxes.length > 0) {
            bulkActions.style.display = 'flex';
            selectedCount.textContent = checkboxes.length;
            bulkIds.value = JSON.stringify(Array.from(checkboxes).map(cb => parseInt(cb.value)));
        } else {
            bulkActions.style.display = 'none';
        }
    }

    // Select all functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllBtn = document.getElementById('selectAll');
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.gallery-checkbox');
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                checkboxes.forEach(cb => cb.checked = !allChecked);
                updateBulkActions();
            });
        }
    });
</script>
@endpush
@endsection
