@extends('admin.layouts.app')

@section('title', $catalog->name)
@section('header', 'Detail Produk')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.catalogs.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <a href="{{ route('admin.catalogs.edit', $catalog) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Image --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="aspect-square">
                    @if($catalog->featured_image)
                        <img src="{{ Storage::url($catalog->featured_image) }}" alt="{{ $catalog->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                {{-- Badges --}}
                <div class="p-4 flex flex-wrap gap-2">
                    @if($catalog->is_featured)
                        <span class="px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">⭐ Unggulan</span>
                    @endif
                    @if($catalog->is_available)
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">✓ Tersedia</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">✗ Tidak Tersedia</span>
                    @endif
                    @if($catalog->stock == 0)
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">Stok Habis</span>
                    @endif
                </div>
            </div>
            
            {{-- Stats --}}
            <div class="mt-4 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Views</span>
                    <span class="font-semibold text-gray-900">{{ number_format($catalog->view_count) }}</span>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="mt-4 bg-gray-50 rounded-xl p-4 text-sm text-gray-500">
                <p>Dibuat: {{ $catalog->created_at->format('d M Y, H:i') }}</p>
                <p>Diperbarui: {{ $catalog->updated_at->format('d M Y, H:i') }}</p>
                <p class="mt-2 font-mono text-xs text-gray-400">Slug: {{ $catalog->slug }}</p>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Header --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                @if($catalog->category)
                    <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full mb-3">{{ $categories[$catalog->category] ?? $catalog->category }}</span>
                @endif
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $catalog->name }}</h1>
                
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('admin.bumnag-profiles.show', $catalog->bumnagProfile) }}" class="flex items-center gap-2 text-gray-600 hover:text-amber-600 transition-colors">
                        @if($catalog->bumnagProfile->logo)
                            <img src="{{ Storage::url($catalog->bumnagProfile->logo) }}" alt="" class="w-6 h-6 rounded-full object-cover">
                        @endif
                        <span class="text-sm">{{ $catalog->bumnagProfile->name }}</span>
                    </a>
                </div>

                <div class="flex items-baseline gap-4">
                    <span class="text-3xl font-bold text-amber-600">{{ $catalog->formatted_price }}</span>
                    @if($catalog->unit)
                        <span class="text-gray-500">/ {{ $units[$catalog->unit] ?? $catalog->unit }}</span>
                    @endif
                </div>
            </div>

            {{-- Stock & SKU --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Stok</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold {{ $catalog->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $catalog->stock }}</p>
                        <p class="text-sm text-gray-500">Stok</p>
                    </div>
                    @if($catalog->unit)
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $units[$catalog->unit] ?? $catalog->unit }}</p>
                            <p class="text-sm text-gray-500">Satuan</p>
                        </div>
                    @endif
                    @if($catalog->sku)
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-lg font-mono font-bold text-gray-900">{{ $catalog->sku }}</p>
                            <p class="text-sm text-gray-500">SKU</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Description --}}
            @if($catalog->description)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        {!! nl2br(e($catalog->description)) !!}
                    </div>
                </div>
            @endif

            {{-- Specifications --}}
            @if($catalog->specifications && count($catalog->specifications) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Spesifikasi</h3>
                    <div class="divide-y divide-gray-100">
                        @foreach($catalog->specifications as $key => $value)
                            <div class="flex py-3">
                                <span class="w-1/3 text-sm font-medium text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                <span class="w-2/3 text-sm text-gray-900">{{ is_array($value) ? json_encode($value) : $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Quick Update Stock --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Stok Cepat</h3>
                <form action="{{ route('admin.catalogs.update-stock', $catalog) }}" method="POST" class="flex items-end gap-3">
                    @csrf
                    <div class="flex-1">
                        <label for="quick_stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Baru</label>
                        <input type="number" name="stock" id="quick_stock" value="{{ $catalog->stock }}" min="0" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-lg transition-colors">
                        Update
                    </button>
                </form>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.catalogs.edit', $catalog) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Produk
                </a>
                <form action="{{ route('admin.catalogs.destroy', $catalog) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-3 border border-red-300 text-red-600 hover:bg-red-50 font-medium text-sm rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
