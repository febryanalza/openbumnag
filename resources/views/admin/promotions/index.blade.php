@extends('admin.layouts.app')

@section('title', 'Kelola Promosi')
@section('page-title', 'Kelola Promosi')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Promosi</p>
                    <p class="text-xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Aktif</p>
                    <p class="text-xl font-bold text-green-600">{{ number_format($stats['active']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kadaluarsa</p>
                    <p class="text-xl font-bold text-orange-600">{{ number_format($stats['expired']) }}</p>
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
                        placeholder="Cari promosi..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Status Filter -->
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                <option value="all">Semua Status</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <!-- Type Filter -->
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                <option value="all">Semua Tipe</option>
                @foreach($promotionTypes as $key => $label)
                    <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <!-- Category Filter -->
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>

            <!-- Trashed Filter -->
            <select name="trashed" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                <option value="">Aktif</option>
                <option value="only" {{ request('trashed') === 'only' ? 'selected' : '' }}>Sampah</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.promotions.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                Reset
            </a>
        </form>
    </div>

    <!-- Actions Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-2">
            <form id="bulkForm" method="POST" action="{{ route('admin.promotions.bulk-action') }}" class="flex items-center gap-2">
                @csrf
                <select name="action" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500">
                    <option value="">Aksi Massal</option>
                    @if(request('trashed') === 'only')
                        <option value="restore">Pulihkan</option>
                        <option value="force_delete">Hapus Permanen</option>
                    @else
                        <option value="delete">Hapus</option>
                        <option value="activate">Aktifkan</option>
                        <option value="archive">Arsipkan</option>
                        <option value="expire">Tandai Kadaluarsa</option>
                        <option value="feature">Jadikan Unggulan</option>
                        <option value="unfeature">Hapus dari Unggulan</option>
                    @endif
                </select>
                <button type="submit" class="px-3 py-2 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700 transition-colors">
                    Terapkan
                </button>
            </form>
        </div>
        <a href="{{ route('admin.promotions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Promosi
        </a>
    </div>

    <!-- Promotions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($promotions as $promo)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Checkbox -->
                <div class="absolute top-3 left-3 z-10">
                    <input type="checkbox" name="ids[]" value="{{ $promo->id }}" form="bulkForm" 
                        class="bulk-checkbox rounded border-gray-300 text-amber-600 focus:ring-amber-500 bg-white">
                </div>

                <!-- Image -->
                <div class="relative h-48">
                    @if($promo->featured_image)
                        <img src="{{ Storage::url($promo->featured_image) }}" alt="{{ $promo->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                    @endif

                    <!-- Badges -->
                    <div class="absolute top-3 right-3 flex flex-col gap-1">
                        @if($promo->is_featured)
                            <span class="px-2 py-1 bg-yellow-500 text-white text-xs rounded-full font-medium shadow">
                                ⭐ Unggulan
                            </span>
                        @endif
                        @if($promo->discount_percentage)
                            <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full font-medium shadow">
                                -{{ $promo->discount_percentage }}%
                            </span>
                        @endif
                    </div>

                    <!-- Status Badge -->
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-500',
                            'active' => 'bg-green-500',
                            'expired' => 'bg-orange-500',
                            'archived' => 'bg-red-500',
                        ];
                    @endphp
                    <div class="absolute bottom-3 left-3">
                        <span class="px-2 py-1 text-white text-xs rounded-full font-medium shadow {{ $statusColors[$promo->status] ?? 'bg-gray-500' }}">
                            {{ $statuses[$promo->status] ?? $promo->status }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs rounded-full font-medium">
                            {{ $promotionTypes[$promo->promotion_type] ?? $promo->promotion_type }}
                        </span>
                        @if($promo->category)
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">
                                {{ $promo->category->name }}
                            </span>
                        @endif
                    </div>

                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('admin.promotions.show', $promo) }}" class="hover:text-amber-600">
                            {{ $promo->title }}
                        </a>
                    </h3>

                    <!-- Price -->
                    @if($promo->discount_price || $promo->original_price)
                        <div class="flex items-center gap-2 mb-3">
                            @if($promo->discount_price)
                                <span class="text-lg font-bold text-amber-600">Rp {{ number_format($promo->discount_price, 0, ',', '.') }}</span>
                                @if($promo->original_price)
                                    <span class="text-sm text-gray-400 line-through">Rp {{ number_format($promo->original_price, 0, ',', '.') }}</span>
                                @endif
                            @elseif($promo->original_price)
                                <span class="text-lg font-bold text-gray-900">Rp {{ number_format($promo->original_price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    @endif

                    <!-- Date Range -->
                    @if($promo->start_date || $promo->end_date)
                        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>
                                @if($promo->start_date && $promo->end_date)
                                    {{ $promo->start_date->format('d M') }} - {{ $promo->end_date->format('d M Y') }}
                                @elseif($promo->start_date)
                                    Mulai {{ $promo->start_date->format('d M Y') }}
                                @elseif($promo->end_date)
                                    Sampai {{ $promo->end_date->format('d M Y') }}
                                @endif
                            </span>
                        </div>
                    @endif

                    <!-- Stats -->
                    <div class="flex items-center justify-between text-sm text-gray-500 pt-3 border-t border-gray-100">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ number_format($promo->views) }}
                        </span>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-1">
                            @if($promo->trashed())
                                <form method="POST" action="{{ route('admin.promotions.restore', $promo->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-1 text-green-600 hover:text-green-800" title="Pulihkan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.promotions.force-delete', $promo->id) }}" class="inline" onsubmit="return confirm('Hapus permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-red-600 hover:text-red-800" title="Hapus Permanen">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.promotions.show', $promo) }}" class="p-1 text-gray-600 hover:text-gray-800" title="Lihat">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.promotions.edit', $promo) }}" class="p-1 text-blue-600 hover:text-blue-800" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.promotions.destroy', $promo) }}" class="inline" onsubmit="return confirm('Hapus promosi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-red-600 hover:text-red-800" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <p class="text-gray-500 mb-2">Tidak ada promosi ditemukan</p>
                    <a href="{{ route('admin.promotions.create') }}" class="text-amber-600 hover:text-amber-700">Tambah promosi baru</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($promotions->hasPages())
        <div class="flex justify-center">
            {{ $promotions->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.bulk-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush
@endsection

